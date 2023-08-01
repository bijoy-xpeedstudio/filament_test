<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \XpeedNotify\XpeedNotify;

class HomeController extends Controller
{
    public function notification()
    {
        $data = [
            [
                'email' => 'bijoy.xpeedstudio@gmail.com',
                'name' => 'Bijoy Karmokar',
                'user_id' => 1
            ]
        ];
        $notify = new XpeedNotify($data);
        //$notify->sendMail();
        //$notify->sendMarkDown();
        // $notify->saveIntoDatabase();
        $notify->sendBrodcust();
    }
}
