<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:users',
            'name'     => 'required',
            'password' => 'required',
        ]);

        $token = DB::transaction(function () use ($request) {
            $user = $this->userService->create($request);
            return auth('api')->attempt(['email' => $user->email, 'password' => $request->password]);
        });

        return jResponse()
            ->setdata($this->respondWithToken($token))
            ->toJson();
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required',
        ]);

        $credentials = ['email' => $request->email, 'password' => $request->password];
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return jResponse()
            ->setdata($this->respondWithToken($token))
            ->toJson();
    }

    public function logout()
    {
        auth('api')->logout();

        return jResponse()->toJsonSuccess();
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ];
    }
}
