<?php


namespace App\Services;

use Sendpulse\RestApi\ApiClient as Client;


class SendPulseService implements SmsManager
{
    private static ?Client $apiClient = null;

    public static function getApiClient(): Client
    {
        if (static::$apiClient === null) {
            static::$apiClient = new Client(
                config('services.send_pulse.key'),
                config('services.send_pulse.secret'),
            );
        }

        return static::$apiClient;
    }

    public function sendSmsWithOTP(string $phone, string $code)
    {
        $response = self::getApiClient()->sendSmsByList(
            [$phone],
            [
                'sender'  => 'test',
                'body'    => $code,
                'transliterate' => 0,
            ],
            [],
        );

        if($response->result !== true) {
            return response()->json('Try again late');
        }

        return response()->json([
            'message' => 'Enter number and code in '.env('APP_URL').route('login')
        ], 200);
    }
}
