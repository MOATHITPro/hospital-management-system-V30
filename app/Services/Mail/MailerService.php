<?php

namespace App\Services\Mail;

class MailerService
{
    public function determineMailer(string $email): ?string
    {
        $localDomains = '@localhost';

        if (str_contains($email, $localDomains)) {
            return 'mercury';
        }

        return null;
    }
}
