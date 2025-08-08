<?php

namespace App\Http\Controllers\Api;

use App\Enums\OTPTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\UserResource;
use App\Models\Customer;    
use App\Services\AuthenticationService;
use Illuminate\Http\Request;

use function App\Helpers\getModelsFromRoute;
use function App\Helpers\sendResponseHelper;

class AuthenticationController extends Controller
{
    public function __construct(private AuthenticationService $service)
    {
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->service->handelRegister($request->validated());
        return $result['status']
            ? sendResponseHelper(201, "successfully registered and the otp has been sent to verify your account")
            : sendResponseHelper($result['code'], $result['message']);
    }

    public function login(LoginRequest $request)
    {
        $model = getModelsFromRoute($request);
        $resource = $model === Customer::class
            ? CustomerResource::class
            : UserResource::class;
        $response = $this->service->handleLogin($request->validated(), $model, $resource);
        return sendResponseHelper(
            $response['status'] ? 200 : 401,
            $response['message'],
            $response['data'] ?? null
        );
    }


    public function logout(Request $request)
    {
        $guard = $request->routeIs('customer.*') ? 'customer-api' : 'user-api';
        $request->user($guard)?->currentAccessToken()?->delete();
        return sendResponseHelper(msg: 'Logged out successfully');
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^((\+963|0)?9\d{8})$/', 'string', 'max:15'],
        ]);
        $model = getModelsFromRoute($request);
        $response = $this->service->handleForgetPassword($request->phone, $model);
        return sendResponseHelper($response['status'] ? 200 : ($response['code'] ?? 400), $response['message']);
    }

    public function verifyRegisterCode(VerifyOtpRequest $request)
    {
        $response = $this->service->handleVerifyOTP(
            $request->phone,
            $request->otp,
            Customer::class,
            OTPTypeEnum::Register
        );
        if (!$response['status']) {
            return sendResponseHelper($response['code'] ?? 400, $response['message']);
        }
        $response['user']->update(['is_verified' => 1]);
        return sendResponseHelper(msg: $response['message']);
    }


    public function verifyPasswordRecoveryCode(VerifyOtpRequest $request)
    {
        $model = getModelsFromRoute($request);
        $response = $this->service->handleVerifyOTP(
            $request->phone,
            $request->otp,
            $model,
            OTPTypeEnum::ResetPassword
        );
        return sendResponseHelper(
            $response['status'] ? 200 : ($response['code'] ?? 400),
            $response['message']
        );
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $model = getModelsFromRoute($request);
        $response = $this->service->handleVerifyOTP(
            $request->phone,
            $request->otp,
            $model,
            OTPTypeEnum::ResetPassword
        );
        if (!$response['status']) {
            return sendResponseHelper($response['code'] ?? 400, $response['message']);
        }
        $response['user']->update(['password'=>$request->new_password]);
        return sendResponseHelper(200, 'Password reset successfully');
    }
}
