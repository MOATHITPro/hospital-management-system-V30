<?php

namespace App\Services\Signup;

use App\Mail\OtpMail;
use App\Models\Otp;
use App\Services\Mail\MailerService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Random\RandomException;

class OtpService
{
    /**
     * @throws RandomException
     */
    public function generateAndSendOtp(array $data): void
    {
        $otpCode = random_int(100000, 999999);

        Otp::create([
            'email'      => $data['email'],
            'otp_code'   => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(10),
            'data'       => json_encode($data),
        ]);

        $mailer = app(MailerService::class)->determineMailer($data['email']);
        Mail::mailer($mailer)->to($data['email'])->send(new OtpMail($otpCode));
    }

    public function verifyOtp(string $email, string $otp): bool
    {
        $otpRecord = Otp::where('email', $email)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        return $otpRecord && $otpRecord->otp_code === $otp;
    }
}
