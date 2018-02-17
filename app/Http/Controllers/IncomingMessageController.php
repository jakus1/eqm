<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
// ngrok http --host-header=eq-municator.local 80

class MailgunWidgetsController extends Controller
{
    public function store()
    {
        $data = request()->all();
        Log::info('This is the text body: '.$data['stripped-text']);
        Log::info('This is the subject: '.$data['subject']);
        Log::info('This message is from: '.$data['from']);
        // Log::info('this is the request: '.print_r(request()->all(),1));



        return response()->json(['status' => 'ok']);
    }
}
