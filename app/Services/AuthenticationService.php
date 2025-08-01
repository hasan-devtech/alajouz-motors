<?php

namespace App\Services;

use App\Enums\OTPTypeEnum;
use App\Models\Customer;
use App\Models\OTP;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function __construct(public OTPService $otpService)
    {
    }
    public function register(array $data): array
    {
        if (Customer::where('phone', $data['phone'])->exists()) {
            return [
                'status' => false,
                'message' => "Unable process",
                'code' => 400
            ];
        }
        Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
        ]);
        return $this->otpService->sendOTP($data['phone'], OTPTypeEnum::Register);
    }

    public function login($credentials, $model)
    {
        $user = $this->getByPhone($credentials['phone'], $model);
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return [
                'status' => false,
                'message' => 'Invalid phone or password',
            ];
        }
        if (!$user->canLogin()) {
            return [
                'status' => false,
                'message' => 'account is not activated yet',
            ];
        }
        return [
            'status' => true,
            'user' => $user,
        ];
    }
    public function resendVerificationCode($phone, $model, $type)
    {
        $user = $this->getByPhone($phone, $model);
        if (!$user) {
            return [
                'status' => false,
                'message' => 'Phone number not found',
            ];
        }
        $otp = $this->otpService->sendOTP($phone, $type);
        return [
            'status' => true,
            'request_code' => $otp["request_code"],
        ];
    }

    public function verifyOTP($phone, $code, OTPTypeEnum $type, $model)
    {
        $user = $this->getByPhone($phone, $model);
        if (!$user)
            return false;
        $otp = $this->getOtp($phone, $type);
        if (!$otp || !Hash::check($code, $otp->code)) {
            return false;
        }
        $otp->delete();
        return $user;
    }
    private function getOtp($phone, $type)
    {
        return OTP::where('phone', $phone)
            ->where('type', $type)
            ->latest()
            ->first();
    }

    public static function getByPhone($phone, $model)
    {
        return $model::where('phone', $phone)->first();
    }


}
