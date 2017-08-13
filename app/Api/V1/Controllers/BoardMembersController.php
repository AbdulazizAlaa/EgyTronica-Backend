<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Board;
use App\User;
use App\Components;

class BoardMembersController extends Controller
{
    public function show_members($id){
        $user = JWTAuth::parseToken()->toUser();
        try{
            $boards = $user->boards;
            if($board = $boards->where('id', $id)->first()){
                if($members = $board->members){
                    return Response()->json([
                      'message' => 'success',
                      'users' => $members
                    ], 200);
                }else{
                    return Response()->json([
                        'message' => 'No Members Found!!',
                        'users' => []
                    ], 200);
                }
            }else{
                return Response()->json([
                    'message' => 'No Board Found!!',
                ], 404);
            }
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

    public function delete_member($board_id, $member_id){
        $user = JWTAuth::parseToken()->toUser();
        try{
            if($member = User::where('id', $member_id)->first()){
                $boards = $user->boards;
                if($board = $boards->where('id', $board_id)->first()){
                    if($board->members()->detach($member_id)){
                      return Response()->json([
                        'message' => 'success',
                      ], 200);
                    }else{
                      return Response()->json([
                          'message' => 'Something went Wrong!!',
                      ], 400);
                    }
                }else{
                    return Response()->json([
                        'message' => 'Could not find desired Board.',
                    ], 400);
                }
            }else{
                return Response()->json([
                    'message' => 'Could not find Member with given Email Address.',
                ], 400);
            }
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

    public function create_member(Request $request, $id){
        $user = JWTAuth::parseToken()->toUser();
        try{
            if($member = User::where('email', $request->user['email'])->first()){
                $boards = $user->boards;
                if($board = $boards->where('id', $id)->first()){
                    $board->members()->attach($member->id, ['type' => $request->user['type']]);
                    $member = $board->members()->where('user_id', $member->id)->first();
                    return Response()->json([
                        'message' => 'success',
                        'user' => $member,
                        'type' => $member->pivot->type
                    ]);

                }else{
                    return Response()->json([
                        'message' => 'Could not find desired Board.',
                    ], 400);
                }
            }else{
                return Response()->json([
                    'message' => 'Could not find Member with given Email Address.',
                ], 400);
            }
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }
}
