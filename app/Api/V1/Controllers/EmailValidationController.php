<?php

namespace App\Api\V1\Controllers;

use App\User;
use App\email_token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailValidationController extends Controller
{
    //email validation function
    //takes token and validates users email
    public function validation($token)
    {

        $email_token = email_token::get()->where('token', $token)->first();
        if($email_token !== null){
            $user = $email_token->user()->first();
            if($user->email_valid == 1){
                return response()->json([
                    'message' => 'User already has a verified email.',
                ], 400);
            }else{
                $user->email_valid = 1;
                $user->save();
                $email_token->delete();
            }
        }else{
            return response()->json([
                'message' => 'This email verification link is not valid.',
            ], 400);
        }
        return response()->json([
            'message' => 'User verified.',
        ], 200);
    }
}
