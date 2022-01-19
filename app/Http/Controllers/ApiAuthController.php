<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiAuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $credentials = request(['email', 'password', 'remember_me']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('appToken');
        $token       = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            //'user' => $user,
            'role_id'      => $user->role_id,
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function register(AuthRegisterRequest $request)
    {
        try {
            $user           = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $tokenResult = $user->createToken('appToken');
            $token       = $tokenResult->token;

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type'   => 'Bearer',
                //'user' => $user,
                'role_id'      => $user->role_id,
                'expires_at'   => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);

        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function otpLogin(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
            'otp'    => 'required|string',
        ]);

        $user = User::where([
            ['mobile', '=', request('mobile')],
            ['otp', '=', request('otp')],
            ['role_id', '=', '5']
        ])->first();
        if (!$user) {
            return response()->json(['message' => 'Access denied'], 403);
        }
        if ($user) {
            Auth::login($user, true);
            User::where('mobile', '=', $request->mobile)->update(['otp' => null]);
        }

//    $user = $request->user();

        $tokenResult = $user->createToken('Laravel Password Grant Client');
        $token       = $tokenResult->token;
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'user'         => $user,
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);

//        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
//        $response = ['token' => "Bearer ".$token];
//
//
//        if($request->remember_me){
//            $token->expires_at = Carbon::now()->addWeeks(1);
//        }
//        //For making login just Add "Bearer " before token and key name is "Authorization"
//
//        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request)
    {

        $otp = rand(1000, 9999);
        Log::info("otp = " . $otp);
        $user = User::where('mobile', '=', $request->mobile)->update(['otp' => $otp]);
        // send otp to mobile no using sms api
        return response()->json([$user], 200);
    }
}
