<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if (!auth()->attempt($request->all())) {
            return response()->json([
                'message' => 'Invalid Email and Password combination'
            ], 403);
        }

        $user = auth()->user();

        $accessToken = $user->createToken('assessment')->accessToken;

        return response()->success([
            'user' => $user, 
            'accessToken' => $accessToken, 
            'role' => $user->roles->pluck('name')
        ]);
    }
}
