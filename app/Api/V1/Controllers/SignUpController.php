<?php

namespace App\Api\V1\Controllers;

use Config;
use App\User;
use App\email_token;
use App\MobilePin;
use App\Mail\EmailVerification;
use App\Mail\MobilePinMailable;

use Mail;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $user = new User($request->all());
        if(!$user->save()) {
            return response()->json([
              'message' => 'Could not verify User'
            ], 500);
        }

        $email_token_obj = $this->create_email_token();
        $user->email_token()->save($email_token_obj);
        Mail::to($user->email)->send(new EmailVerification($email_token_obj->token));

        $mobile_pin_obj = $this->create_mobile_pin();
        $user->mobile_pin()->save($mobile_pin_obj);
        Mail::to($user->email)->send(new MobilePinMailable($mobile_pin_obj->pin));

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'message' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'message' => 'ok',
            'token' => $token
        ], 201);
    }

    private function create_mobile_pin()
    {
        do
        {
            $value = rand(0, 99999);
            $otp = str_pad($value, 5, '0', STR_PAD_LEFT);
            $mobile_pin = MobilePin::where('pin', $otp)->first();
        }
        while(!empty($mobile_pin));

        $mobile_pin = new MobilePin(['pin' => $otp]);

        return $mobile_pin;
    }

    private function create_email_token(){
        do
        {
            $token = str_random(16);
            $code = 'EN'. $token . substr(strftime("%Y", time()),2);
            $email_code = email_token::where('token', $code)->first();
        }
        while(!empty($email_code));

        $email_token = new email_token(['token' => $code]);

        return $email_token;
    }
}
