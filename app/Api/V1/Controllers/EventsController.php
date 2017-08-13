<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Event;

use Carbon\Carbon;

class EventsController extends Controller
{
    //returns all events
    public function index(){
        try{
            $events = Event::all();

            return Response()->json([
              'message' => 'success',
              'events' => $events
            ]);
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

    //handles serving event form html
    public function create(){
        return view('event.event_form');
    }

    //handles creation of a new event
    public function store(Request $request){
        $data = $request->intersect(['title', 'address', 'lat', 'lng', 'date']);
        $data['date'] = Carbon::parse($data['date'])->timestamp;
        $event = new Event($data);
        $event->save();

        return view('event.event_form')->with('message', 'Record Added');
    }


}
