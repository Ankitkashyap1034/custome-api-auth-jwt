<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Exceptions\JWTException;




class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $validator = new Validator(app('translator'), $request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
            if ($validator->fails()) {
                throw new HttpResponseException(response()->json([
                    'errors' => $validator->errors(),
                ], 422));
                die;
            } else {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    //Request is validated
                    //Crean token
                    try {
                        if (!$token = JWTAuth::attempt($credentials)) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Login credentials are invalid.',
                            ], 400);
                        }
                    } catch (JWTException $e) {
                        return $credentials;
                        return response()->json([
                            'success' => false,
                            'message' => 'Could not create token.',
                        ], 500);
                    }

                    //Token created, return with success response and jwt token
                    return response()->json([
                        'success' => true,
                        'token' => $token,
                    ]);
                } else {
                    return response()->json(['faild', 'User does not exists']);
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
