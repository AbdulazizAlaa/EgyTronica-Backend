<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\ContactUs;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{

    public function store(Request $request){
        try{
            $contact = new ContactUs($request->all());
            $contact->save();
            return view('contactus');
        }catch(\Exception $ex){
            return Response()->json([
                'message' => 'Something went Wrong!!',
                'info' => $ex
            ], 400);
        }
    }

}
