<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use JWTAuth;

use App\Api\V1\Controllers\BoardController;

use App\Board;
use App\Members;
use App\User;
use App\Components;

class BoardComponentsController extends Controller
{

    public function update($board_code, $component_name, Request $request){
        $user = JWTAuth::parseToken()->toUser();
        if($board = Board::where('code', $board_code)->first()){
            if($board->user_id == $user->id){
                //you have access to the board and can update it
                $data = $request->intersect(["color_code", "status", "heat_loss", "effect_on_power"]);
                try{
                    if(Components::where('board_id', $board->id)->where('name', $component_name)->update($data)){
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

                                //update the color code and status for the board it self and notify
                                BoardController::markBoardUnstable($board->id);
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
            ], 400);
        }
    }

    public function control_component(Request $request, $board_id, $component_id){
        $user = JWTAuth::parseToken()->toUser();
        try{
          $boards = $user->boards;
          if($board = $boards->where('id', $board_id)->first()){
              if($components = $board->components){
                  if($component = $components->where('id', $component_id)->first()){
                      $component->close = $request->component['close'];
                      $component->close_time = $request->component['close_time'];
                      $component->save();
                      return Response()->json([
                        'message' => 'success',
                        'component' => $component,
                      ], 200);
                  }else{
                      return Response()->json([
                          'message' => 'Could not find your requested Component.',
                      ], 400);
                  }
              }else{
                  return Response()->json([
                      'message' => 'Could not find any Components.',
                  ], 400);
              }
          }else{
              $member_boards = $user->member_boards;
              if($board = $member_boards->where('id', $board_id)->first()){
                  if($components = $board->components){
                      if($component = $components->where('id', $component_id)->first()){
                          $component->close = $request->component->close;
                          $component->close_time = $request->component->close_time;
                          $component->save();
                          return Response()->json([
                            'message' => 'success',
                            'component' => $component,
                          ], 200);
                      }else{
                          return Response()->json([
                              'message' => 'Could not find your requested Component.',
                          ], 400);
                      }
                  }else{
                      return Response()->json([
                          'message' => 'Could not find any Components.',
                      ], 400);
                  }
              }else{
                  return Response()->json([
                      'message' => 'could not find any boards',
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

    public function create_component(Request $request, $id){
        $user = JWTAuth::parseToken()->toUser();
        try{
            if($boards = $user->boards){
                if($board = $boards->where('id', $id)->first()){
                    $component = new Components($request->component);
                    $board->components()->save($component);
                    return Response()->json([
                        'message' => 'success',
                        'component' => $component,
                    ]);
                }else{
                    return Response()->json([
                        'message' => 'Could not find desired Board.',
                    ], 400);
                }
            }else{
                return Response()->json([
                    'message' => 'This user does not have any boards.',
                ], 400);
            }
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

    public function show_component($board_code, $component_name){
        $user = JWTAuth::parseToken()->toUser();
        try{
          $boards = $user->boards;
          if($board = $boards->where('code', $board_code)->first()){
              if($components = $board->components){
                if($component = $components->where('name', $component_name)->first()){
                    return Response()->json([
                      'message' => 'success',
                      'component' => $component,
                    ], 200);
                }else{
                    return Response()->json([
                        'message' => 'Could not find the Component.',
                    ], 404);
                }
              }else{
                  return Response()->json([
                      'message' => 'Could not find any Components.',
                  ], 404);
              }
          }else{
              $member_boards = $user->member_boards;
              if($board = $member_boards->where('code', $board_code)->first()){
                  if($components = $board->components){
                      if($component = $components->where('name', $component_name)->first()){
                          return Response()->json([
                            'message' => 'success',
                            'component' => $component,
                          ], 200);
                      }else{
                          return Response()->json([
                              'message' => 'Could not find the Component.',
                          ], 404);
                      }
                  }else{
                      return Response()->json([
                          'message' => 'Could not find any Components.',
                      ], 404);
                  }
              }else{
                  return Response()->json([
                      'message' => 'could not find any boards',
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

    public function show_components($id){
        $user = JWTAuth::parseToken()->toUser();
        try{
          $boards = $user->boards;
          if($board = $boards->where('id', $id)->first()){
              if($components = $board->components){
                $board['is_owner'] = true;
                return Response()->json([
                  'message' => 'success',
                  'components' => $components,
                  'board' => $board
                ], 200);
              }else{
                  return Response()->json([
                      'message' => 'Could not find any Components.',
                      'components' => [],
                      'board' => $board
                  ], 200);
              }
          }else{
              $member_boards = $user->member_boards;
              if($board = $member_boards->where('id', $id)->first()){
                  if($components = $board->components){
                      $board['m_type'] = Board::board_member_type($id, $user['id'])->first()->m_type;
                      $board['is_owner'] = false;
                      return Response()->json([
                        'message' => 'success',
                        'components' => $components,
                        'board' => $board
                      ], 200);
                  }else{
                      return Response()->json([
                          'message' => 'Could not find any Components.',
                          'components' => [],
                          'board' => $board
                      ], 200);
                  }
              }else{
                  return Response()->json([
                      'message' => 'could not find any boards',
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
}
