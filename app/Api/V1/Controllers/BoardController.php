<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Http\Controllers\Controller;

use App\Api\V1\Requests\BoardRequest;
use Illuminate\Http\Request;

use App\Api\V1\Controllers\FirebaseController;

use App\Board;
use App\Members;
use App\User;
use App\Components;

class BoardController extends Controller
{

    public function view(){
        return view('board.fetch');
    }

    public function fetch(Request $request){
        $data = $request->intersect(['email', 'mob', 'board']);

        try{
            if($user = User::where('email', '=', $data['email'])->where('phone', '=', $data['mob'])->first()){
                if($board = $user->boards->where('name', '=', $data['board'])->first()){
                    $components = $board->components;

                    return view('board.view')->with('board', $board);
                }else{
                    return view('board.fetch')->with('message', 'Board Not Found!!');
                }
            }else{
                return view('board.fetch')->with('message', 'User Not Found!!');
            }
        }catch(\Exception $ex){
            return view('board.fetch')->with('message', 'Something went Wrong!!');
        }
    }

    public static function markBoardUnstable($board_id){
        //some component is unstable with color code red
        //so the whole board should be unstable and give red color
        $board = Board::where('id', $board_id)->first();
        if(!$board){
            return Response()->json([
              'message' => 'Required Board was not Found!!',
            ], 404);
        }

        $data = array("color_code" => 4, "status" => "Unstable");
        try{
            if(Board::where('id', $board_id)->update($data)){
                //code red send a notification
                $tokens = array();
                $tokens[] = $board->user['registration_id'];
                //members user ids
                $ids = Members::where('board_id', $board->id)->pluck('user_id');
                foreach ($ids as $id) {
                    $token = User::where('id', $id)->first()->registration_id;
                    $tokens[] = $token;
                }
                FirebaseController::notifyMultible($board->name, "This is board is in Critical Danger!!", $tokens);

                return Response()->json([
                  'message' => 'success',
                ]);
            }else{
                return Response()->json([
                    'message' => 'Something went Wrong!!',
                ], 400);
            }
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

    public function update($board_code, Request $request){
        $user = JWTAuth::parseToken()->toUser();
        if($board = Board::where('code', $board_code)->first()){
            if($board->user_id == $user->id){
                //you have access to the board and can update it
                $data = $request->intersect(["color_code", "status", "advice", "output_efficiency", "temp", "humidity", "run_time"]);
                try{
                    if(Board::where('code', $board_code)->update($data)){
                        //checking for issues so we send Notifications
                        if($request->has('color_code')){
                            if($request['color_code'] == 4){
                                //code red send a notification
                                $tokens = array();
                                $tokens[] = $board->user['registration_id'];
                                //members user ids
                                $ids = Members::where('board_id', $board->id)->pluck('user_id');
                                foreach ($ids as $id) {
                                    $token = User::where('id', $id)->first()->registration_id;
                                    $tokens[] = $token;
                                }
                                FirebaseController::notifyMultible($board->name, "This is board is in Critical Danger!!", $tokens);
                            }
                        }

                        return Response()->json([
                          'message' => 'success',
                        ]);
                    }else{
                        return Response()->json([
                            'message' => 'Something went Wrong!!',
                        ], 400);
                    }
                }catch(\Exception $ex){
                    return Response()->json([
                        'message' => 'Something went Wrong!!',
                        'info' => $ex
                    ], 400);
                }
            }else{
                return Response()->json([
                    'message' => 'You do not have access to this Board!!',
                ], 403);
            }
        }else{
            return Response()->json([
                'message' => 'Required Board was not Found!!',
            ], 404);
        }
    }

    public function show($id){
        $user = JWTAuth::parseToken()->toUser();
        try{
            $boards = $user->boards;
            if($board = $boards->where('id', $id)->first()){
                $board['is_owner'] = true;
                return Response()->json([
                    'message' => 'success',
                    'board' => $board
                ]);
            }else{
                $member_boards = $user->member_boards;
                if($board = $member_boards->where('id', $id)->first()){
                    $board['is_owner'] = false;
                    return Response()->json([
                        'message' => 'success',
                        'board' => $board
                    ]);
                }else{
                    return Response()->json([
                        'message' => 'Required Board was not Found!!',
                        'board' => $board
                    ], 400);
                }

            }
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

    public function member_boards(){
        $user = JWTAuth::parseToken()->toUser();
        try{
            $boards = $user->member_boards;
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
        return Response()->json([
            'message' => 'success',
            'boards' => $boards
        ]);
    }

    public function index(){
        $user = JWTAuth::parseToken()->toUser();
        try{
            $boards = $user->boards;
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
        return Response()->json([
            'message' => 'success',
            'boards' => $boards
        ]);
    }

    public function create(BoardRequest $request){
        $user = JWTAuth::parseToken()->toUser();
        try{
          $board = new Board($request->boards);
          $user->boards()->save($board);
        }catch(\Illuminate\Database\QueryException $ex){
            // we have a duplicate entry problem
            return Response()->json([
                'message' => 'Choose another Board name',
            ], 409);
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }

        return Response()->json([
            'message' => 'Created'
        ], 200);
    }
}
