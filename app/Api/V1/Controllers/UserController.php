<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Board;
use App\User;
use App\Components;

class UserController extends Controller
{
    public function update_registration_id(Request $request){
        $user = JWTAuth::parseToken()->toUser();
        if($reg_id = $request['registration_id']){
            $user->registration_id = $reg_id;
            if($user->save()){
                return Response()->json([
                  'message' => 'success',
                  'user' => $user
                ], 200);
            }else{
                return Response()->json([
                  'message' => 'Something went wrong!!',
                ], 400);
            }
        }else {
            return Response()->json([
              'message' => 'Missing Registration Id!!',
            ], 400);

        }
    }
}
