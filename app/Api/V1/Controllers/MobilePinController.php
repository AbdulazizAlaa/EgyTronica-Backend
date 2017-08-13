<?php

namespace App\Api\V1\Controllers;

use Mail;
use JWTAuth;
use App\User;
use App\MobilePin;
use App\Mail\MobilePinMailable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MobilePinController extends Controller
{

  public function resend(Request $request){

      $user = JWTAuth::parseToken()->authenticate();

      if($pin = $user->mobile_pin['pin']){
          Mail::to($user->email)->send(new MobilePinMailable($pin));
          return response()->json([
              'message' => 'Pin code is sent.',
          ], 200);
      }else{
          return response()->json([
              'message' => 'Pin code is already verified.',
          ], 200);
      }
  }

  //mobile validation function
  //takes a pin and validates users mobile
  public function validation(Request $request)
  {
      $user = JWTAuth::parseToken()->authenticate();

      $match = [
        ['pin', $request->pin],
        ['user_id', $user->id]
      ];
      $mobile_pin = MobilePin::where($match)->first();
      if($mobile_pin !== null){
          $user = $mobile_pin->user()->first();
          if($user->mobile_valid == 1){
              return response()->json([
                  'message' => 'User already has a verified number.',
              ], 400);
          }else{
              $user->mobile_valid = 1;
              $user->save();
              $mobile_pin->delete();
          }
      }else{
          return response()->json([
              'message' => 'This Pin code is not valid.',
          ], 400);
      }
      return response()->json([
          'message' => 'User number is verified.',
      ], 200);
  }
}
