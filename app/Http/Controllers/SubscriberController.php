<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeMail;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    const SUBSCRIBE = 1;
    const UNSUBSCRIBE = 0;

    public function sendConfirmCode(Request $request)
    {   
        self::checkEmail($request);

        $email = $request->input('email');

        $confirmCode = strval(random_int(100000, 999999));
        Cache::put($email, $confirmCode, 60*5);

        Mail::to($email)->send(new SubscribeMail($confirmCode));
        return response()->json(['message' => 'Confirmation email sent']);
    }

    public function confirmSubscribe(Request $request)
    {
        return self::confirm($request, self::SUBSCRIBE);
    }

    public function confirmUnsubscribe(Request $request)
    {
        return self::confirm($request, self::UNSUBSCRIBE);
    }

    // Helper functions
    private function confirm(Request $request, $type)
    {
        self::checkEmail($request);
        $email = $request->input('email');
        $confirmCode = $request->input('code');
        
        if (!$confirmCode) {
            return response()->json(['error' => 'Confirmation code is required'], 400);
        }
        
        if (Cache::get($email) == $confirmCode) {
            $subscriber = Subscriber::where('email', $email)->first();
        
            if ($subscriber) {
                $subscriber->update(['status' => $type]);
            } else {
                Subscriber::create(['email' => $email, 'status' => $type]);
            }
            Cache::forget($email);
        
            return response()->json(['message' => 'Email ' . ($type ? 'subscribed' : 'unsubscribed')]);
        } else {
            return response()->json(['error' => 'Confirmation code is invalid'], 400);
        }
    }

    // Check if the email is valid and not already subscribed
    private function checkEmail(Request $request){
        if(!($request->has('email') && filter_var($request->has('email'), FILTER_VALIDATE_EMAIL))){
            return response()->json(['error' => 'Email is required'],400);
        }
    }
}
