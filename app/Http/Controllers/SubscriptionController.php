<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $input = $request->all();
        Newsletter::subscribe($input['user_email']);
        return ['ok' => true, "for" => $input['user_email']];
    }
}
