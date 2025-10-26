<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('index');
});

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/contact', function (Request $request) {
    // Validate required fields
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'message' => 'required|string|max:1000',
        'token' => 'required|string'
    ]);

    // Log the submission (without token for security)
    $logData = $request->except(['token', '_token']);
    Log::info('Received contact form submission', $logData);

    // Validate Turnstile token
    $validation = validateTurnstileToken($request->token, config('services.turnstile.secret_key'));

    if (!$validation || !$validation['success']) {
        return response()->json(['message' => 'Invalid token'], 400);
    }

    // Sanitize input
    $name = htmlspecialchars($request->name);
    $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($request->phone);
    $message = htmlspecialchars($request->message);

    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = config('mail.mailers.smtp.host');
        $mail->SMTPAuth = true;
        $mail->Username = config('mail.mailers.smtp.username');
        $mail->Password = config('mail.mailers.smtp.password');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = config('mail.mailers.smtp.port');
        $mail->addCC(config('mail.contact.cc'));
        $mail->CharSet = 'UTF-8';

        // Recipients
        $mail->setFrom(config('mail.from.address'), 'Site Colégio Sete Mares');
        $mail->addAddress(config('mail.contact.to'));

        // Content
        $mail->isHTML(true);
        $mail->Subject = '[Site Colégio Sete Mares] Nova mensagem do formulário de contato';
        $mail->Body = "
            <h3>Nova mensagem do formulário de contato</h3>
            <b>Nome:</b> {$name} <br />
            <b>E-mail:</b> {$email} <br />
            <b>Telefone:</b> {$phone} <br />
            <b>Mensagem:</b> {$message} <br />
        ";

        $mail->send();
        Log::info('Email sent successfully', ['to' => config('mail.contact.to')]);
        
        return response()->json(['message' => 'Email sent successfully']);

    } catch (Exception $e) {
        Log::error('Failed to send email', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Email could not be sent. Error: ' . $e->getMessage()], 500);
    }
});

function validateTurnstileToken($token, $secretKey)
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
    $result = file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, $context);

    return json_decode($result, true);
}
