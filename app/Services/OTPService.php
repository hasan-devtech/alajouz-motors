<?php

namespace App\Services;

use App\Enums\OTPTypeEnum;
use App\Models\OTP;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Client\RequestException;

class OTPService
{
    public function sendOTP($phone, OTPTypeEnum $type)
    {
        $code = $this->generateCode();
        $requestCode = Str::uuid();
        OTP::create(attributes: [
            'code' => $code,
            'request_code' => $requestCode,
            'phone' => $phone,
            'type' => $type
        ]);
        $message = "Your OTP is: " . $code;
        $isSent = $this->send($phone, $message);
        return $isSent
            ? ['status' => true , 'message' => 'otp has been send successfully']
            : ['status' => false, 'message' => 'SMS failed', 'code' => 500];
    }
    private static function generateCode()
    {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= random_int(0, 9);
        }
        return $code;
    }

    private static function send($phone, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => config('services.sms.token'),
                'Accept' => 'application/json',
            ])->post(config('services.sms.gateway_url'), [
                        'to' => '+963943653015',
                        'message' => $message,
                    ]);
            if (!$response->successful()) {
                Log::error('SMS sending failed', [
                    'phone' => $phone,
                    'response' => $response->body(),
                ]);
                throw new RequestException($response);
            }
            return true;
        } catch (\Throwable $e) {
            Log::error('SMS Exception', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }


}
