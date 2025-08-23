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
    public function handelRegister($data)
    {
        if (Customer::where('phone', $data['phone'])->exists()) {
            return [
                'status' => false,
                'message' => "Invalid process",
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
    public function handleLogin($credentials, $model, $resource)
    {
        $user = $this->getByPhone($credentials['phone'], $model);
        if (!$user || !Hash::check($credentials['password'], $user->password) || !$user->canLogin()) {
            return [
                'status' => false,
                'message' => 'Invalid phone or password',
            ];
        }
        $token = $user->createToken('Ajous-Motor-Token')->plainTextToken;
        return [
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                class_basename($model) => $resource::make($user),
                'access_token' => $token,
            ]
        ];
    }
    public function handleVerifyOTP($phone, $otp, $model, OTPTypeEnum $type)
    {
        $user = $this->getByPhone($phone, $model);
        if (!$user) {
            return [
                'status' => false,
                'message' => 'Invalid process',
                'code' => 400,
            ];
        }
        $verified = $this->verifyOTP($phone, $otp, $type);
        if (!$verified) {
            return [
                'status' => false,
                'message' => 'Invalid OTP or expired',
                'code' => 401,
            ];
        }
        return [
            'status' => true,
            'user' => $user,
            'message' => 'Verified successfully',
        ];
    }
    public function handleForgetPassword($phone, $model)
    {
        $user = $this->getByPhone($phone, $model);
        if (!$user || !$user->canLogin()) {
            return [
                'status' => false,
                'message' => 'Invalid process',
                'code' => 400
            ];
        }
        $result = $this->otpService->sendOTP($phone, OTPTypeEnum::ResetPassword);
        return [
            'status' => $result['status'],
            'message' => $result['message'],
            'code' => $result['status'] ? 200 : ($result['code'] ?? 500)
        ];
    }

    public function verifyOTP($phone, $code, OTPTypeEnum $type)
    {
        $otp = $this->getOtp($phone, $type);
        if (!$otp || !Hash::check($code, $otp->code)) {
            return false;
        }
        return true;
    }

    private function getOtp($phone, $type)
    {
        return OTP::where('phone', $phone)
            ->where('type', $type)
            ->latest()
            ->first();
    }

    public function getByPhone($phone, $model)
    {
        return $model::where('phone', $phone)->first();
    }

}
