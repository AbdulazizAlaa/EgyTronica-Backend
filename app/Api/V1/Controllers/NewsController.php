<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;

class NewsController extends Controller
{
    //returns all news
    public function index(){
        try{
            $news = News::all();

            return Response()->json([
              'message' => 'success',
              'news_list' => $news
            ]);
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

    //returns one news json
    public function show($id){
        try{
            $news = News::all();

            if($news_item = $news->where('id', $id)->first()){
                return Response()->json([
                  'message' => 'success',
                  'news' => $news_item
                ]);
            }else{
                return Response()->json([
                    'message' => 'Required news was not Found!!',
                    'news' => array('id' => '', 'title' => '', 'content' => '')
                ], 404);
            }
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

    //handles serving news form html
    public function create(){
        return view('news.news_form');
    }

    //handles creation of a new news
    public function store(Request $request){
        $data = $request->intersect(['title', 'content']);
        $news = new News($data);
        $news->save();

        return view('news.news_form')->with('message', 'Record Added');
    }

}
