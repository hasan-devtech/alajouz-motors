<?php

namespace App\Http\Controllers\Api;

use App\Enums\OTPTypeEnum;
use App\Http\Controllers\Controller;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\UserResource;
use App\Models\Customer;
use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function App\Helpers\sendResponseHelper;

class AuthenticationController extends Controller
{

    public function __construct(private AuthenticationService $service)
    {
    }
    public function register(RegisterRequest $request)
    {
        $result = $this->service->register($request->validated());
        if (!$result['status']) {
            return sendResponseHelper($result['code'], $result['message']);
        }
        return sendResponseHelper(201, data: ['request_code' => $result['request_code']]);
    }

    public function loginCustomer(LoginRequest $request)
    {
        return $this->login($request, Customer::class, 'customer', CustomerResource::class);
    }

    public function loginUser(LoginRequest $request)
    {
        return $this->login($request, User::class, 'user', UserResource::class);
    }

    public function logoutUser(){
        request()->user('user-api')->currentAccessToken()->delete();
        return sendResponseHelper(msg:"logout successfully");
    }

        public function logoutCustomer(){
        request()->user('customer-api')->currentAccessToken()->delete();
        return sendResponseHelper(msg:"logout successfully");
    }

    private function login(Request $request, $model, $resourceKey, $resourceClass)
    {
        $result = $this->service->login($request->validated(), $model);
        if (!$result['status']) {
            return sendResponseHelper(401, $result['message']);
        }
        $token = $result['user']->createToken('Ajous-Motor-Token')->plainTextToken;
        return sendResponseHelper(data: [
            $resourceKey => $resourceClass::make($result['user']),
            'access_token' => $token,
        ]);
    }

    public function verifyRegisterCode(VerifyOtpRequest $request)
    {
        $validated = $request->validated();
        $result = $this->service->verifyOTP(
            $validated['phone'],
            $validated['otp'],
            OTPTypeEnum::Register,
            Customer::class
        );
        if (!$result) {
            return sendResponseHelper(401, 'Invalid OTP or expired');
        }
        $result->update(['is_verified' => true]);
        return sendResponseHelper(200, 'Verified successfully');
    }
    public function resendVerificationCode(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'regex:/^((\+963|0)?9\d{8})$/' ,'string'],
            'otp_type' => ['required', Rule::in(enumValues(OTPTypeEnum::class))]
        ]);
        $otpType = OTPTypeEnum::from($validated['otp_type']);
        $result = $this->service->otpService->sendOTP($validated['phone'], $otpType);
        if (!$result['status']) {
            return sendResponseHelper($result['code'], $result['message']);
        }
        return sendResponseHelper(201, data: ['request_code' => $result['request_code']]);
    }
}
