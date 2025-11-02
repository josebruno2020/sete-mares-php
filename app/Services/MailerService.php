<?php

namespace App\Services;

use App\Models\Contact;
use Exception;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;

class MailerService
{
  public function sendMail(Contact $contact): void
  {
    try {
      $mail = new PHPMailer(true);

      $mail->isSMTP();
      $mail->Host = config('mail.mailers.smtp.host');
      $mail->SMTPAuth = true;
      $mail->Username = config('mail.mailers.smtp.username');
      $mail->Password = config('mail.mailers.smtp.password');
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = config('mail.mailers.smtp.port');
      if (config('mail.contact.cc')) {
        $mail->addCC(config('mail.contact.cc'));
      }
      $mail->CharSet = 'UTF-8';

      // Recipients
      $mail->setFrom(config('mail.from.address'), 'Site Colégio Sete Mares');
      $mail->addAddress(config('mail.contact.to'));

      // Content
      $mail->isHTML(true);
      $mail->Subject = '[Site Colégio Sete Mares] Nova mensagem do formulário de contato';
      $mail->Body = "
            <h3>Nova mensagem do formulário de contato</h3>
            <b>Nome:</b> {$contact->name} <br />
            <b>E-mail:</b> {$contact->email} <br />
            <b>Telefone:</b> {$contact->phone} <br />
            <b>Mensagem:</b> {$contact->message} <br />
        ";

      $mail->send();
      Log::info('Email sent successfully', ['to' => config('mail.contact.to')]);
    } catch (\Exception $e) {
      Log::error('Failed to send email', ['error' => $e->getMessage()]);
      throw new Exception('Email could not be sent. Error: ' . $e->getMessage());
    }
  }
}