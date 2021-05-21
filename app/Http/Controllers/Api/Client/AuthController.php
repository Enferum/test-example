<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Jobs\ClearClientsOTPJob;
use App\Models\Client;
use App\Models\SmsNotification;
use App\Services\SmsManager;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private SmsManager $smsManager;

    public function __construct(SmsManager $smsManager)
    {
        $this->smsManager = $smsManager;
    }

    public function login(Request $request)
    {
        $code = $request->validate(['code' => 'required|string']);
        $otp = $this->checkOtp($code['code']);

        if(!$otp){
            return response()->json('Expired code');
        }

        $clientCode = SmsNotification::whereCode($code)->first();

        auth('client')->loginUsingId($clientCode->client_id);

        /* @var $client Client */
        $client = auth('client')->user();

        $clientCode->expired = true;
        $clientCode->save();

        $accessToken = $client->createToken('authToken')->accessToken;

        dispatch(new ClearClientsOTPJob($client));

        return response([
            'client' => $client,
            'accessToken' => $accessToken
        ]);
    }

    public function getCode(Request $request)
    {
        $phone = $request->validate(['phone' => 'required|string|exists:clients,phone']);

        $client = Client::wherePhone(Arr::first($phone))->first();

        $otp = new SmsNotification();
        $otp->client()->associate($client->id);
        $otp->code =  Str::random(6);
        $otp->expired = false;
        $otp->save();

        $this->smsManager->sendSmsWithOTP($client->phone, $otp->code);
    }

    public function checkOtp(string $code): bool
    {
        $checkedCode = SmsNotification::whereCode($code)->first();

        if (!$checkedCode) {
            return false;
        }

        return  $this->isExpiredCode($checkedCode);
    }

    public function isExpiredCode(SmsNotification $code): bool
    {
        $checkDate =  Carbon::parse($code->created_at)
                     ->addMinutes(config('settings.expire_time_minutes'))
                     ->isPast();

        if($checkDate) {
            $code->expired = true;
            $code->save();

            return false;
        }

        return true;
    }
}
