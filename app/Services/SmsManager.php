<?php


namespace App\Services;


interface SmsManager
{
    public function sendSmsWithOTP(string $phone, string $code);
}
