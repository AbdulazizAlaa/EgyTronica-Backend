<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class FirebaseController extends Controller
{
    public static function notifyMultible($title, $message, $tokens){
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)
                  ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['title' => $title, 'message' => $message]);

        $option = $optionBuiler->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // $token = ["fbjrA0-Ueoc:APA91bEBKFoTLCvQZ19LRCjw5v99CZSF5mCKbvYzfPzJiP2UxHvR4gmdcp_Aq9fNxrjqiOa7Cm4wYLo5Y3kB3YrCKXOCR1S-dxXeZPfeaExG4h9ukYxmNMYZO24RX7ovlqDYmRhnrlJX",
        //           "f_BiKGl8f3I:APA91bG513i3MohQZx0eajkr6PR2uE0ZDxupO2-yZGkeiy6gsWhu07lYVl2Vpoqq_HK63RLl1obFpDXZ8L4E0wBhnIAeJ9FvYEScHnplD_ofeqej1pLul4ypK93M7EiLRk96GV2aCdVD"];

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
    }
}
