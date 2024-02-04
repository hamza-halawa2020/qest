<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;


class LoginController extends Controller
{
    public function login(Request $request)
    {

        try {

            $this->validate($request, [
                'phone' => ['required', 'regex:/^(010|011|012|015)\d{8}$/'],
                "password" => "required",
            ]);

            $login = $request->only("phone", "password");
            if (!Auth::attempt($login)) {
                return response(['message' => 'invalid login'], 401);
            }
            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken($user->phone);
            return response([
                // 'id' => $user->id,
                // 'name' => $user->name,
                // 'phone' => $user->phone,
                'token' => $token->plainTextToken
            ], 200);

        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    //login for clients
    public function clientLogin(Request $request)
    {
        try {
            $this->validate($request, [
                'national_id' => ['required', 'regex:/^([1-9]{1})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})[0-9]{3}([0-9]{1})[0-9]{1}$/'],
                "password" => "required",
            ]);

            $login = $request->only("national_id", "password");
            if (!Auth::guard('clients')->attempt($login)) {
                return response(['message' => 'invalid client login'], 401);
            }

            $client = Auth::guard('clients')->user();
            $client->tokens()->delete();
            $token = $client->createToken($client->national_id);

            return response([
                'token' => $token->plainTextToken
            ], 200);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

}