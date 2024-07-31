<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use Exception;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());
            if ($user) {
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->plainTextToken;

                return response()->json([
                    'data' => $user,
                    'message' => 'User registered successfully',
                    'accessToken' => $token,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User registration failed'
                ], 400);
            }
        } catch (Exception $exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
