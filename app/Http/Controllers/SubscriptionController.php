<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        // subscribe just returns true / false
        $res = Newsletter::subscribePending($input['user_email']);

        // hence we double check if the user is already there
        $subscribed = Newsletter::isSubscribed($input['user_email']);

        return ['res' => $res, "subscribed" => $subscribed];
    }
}
