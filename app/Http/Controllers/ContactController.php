<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Services\MailerService;
use Exception;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;

class ContactController extends Controller
{
    private string $cloudflareUrl = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    public function __construct(
        private MailerService $mailerService
    ) {

    }

    public function handle(ContactRequest $request)
    {
        $data = $request->validated();
        $logData = $request->except(['token', '_token']);
        Log::info('Received contact form submission', $logData);

        $validation = $this->validateTurnstileToken($request->token, config('services.turnstile.secret_key'));

        if (!$validation || !$validation['success']) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        // Sanitize input
        $name = htmlspecialchars($data['name']);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars($data['phone']);
        $message = htmlspecialchars($data['message']);

        $contact = Contact::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message
        ]);

        try {
            $this->mailerService->sendMail($contact);
            return response()->json(['message' => 'Email sent successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to send email. Please try again later.'], 500);
        }
    }

    private function validateTurnstileToken($token, $secretKey)
    {
        $data = [
            'secret' => $secretKey,
            'response' => $token
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($this->cloudflareUrl, false, $context);

        return json_decode($result, true);
    }
}
