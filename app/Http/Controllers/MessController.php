<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MessController extends Controller
{
    function home(){
        return view('home');
    }

    function send_otp(Request $request){
        $otp   = strip_tags(trim($request->input('otp')));
        $email = strip_tags(trim($request->input('email')));

        try{
            //Mail::to($email)->send(new EmailVerification("Your OTP: " . $otp));
            return json_encode(['status' => 200]);
        }
        catch(\Exception $e){
           return json_encode(['status' => 400]);
        }
    }

    function authenticate(Request $request){
        $mess_email = strip_tags(trim($request->input('email')));
        $is_mess    = DB::table('mess')->where('mess_email', $mess_email)->count();

        if(!$is_mess){
            return ['status'=> 200, 'next_route'=> 'register'];
        }
        else{
            //setting session
            $request->session()->put('admin', $mess_email);
            return ['status'=> 200, 'next_route'=> 'dashboard'];
        }
    }

    function register(Request $request){
        $mess_name  = strip_tags(trim($request->input('mess_name')));
        $mess_email = strip_tags(trim($request->input('mess_email')));

        $is_mess = DB::table('mess')->where('mess_email', $mess_email)->count();

        if($is_mess){
            return json_encode(['status' => 409]);
        }
        else{
            try{
                DB::table('mess')->insert([
                    'mess_name'         => $mess_name,
                    'mess_email'        => $mess_email,
                    'joining_date'      => Carbon::now()->toDateString(),
                    'last_payment_date' => Carbon::now()->toDateString(),
                ]);

                //setting session
                $request->session()->put('admin', $mess_email);

                return json_encode(['status' => 200, 'next_route'=> 'dashboard']);
            }
            catch(\Exception $e){
                return json_encode(['status' => $e->getMessage()]);
            }
        }
    }

    function logout(Request $request){
        try{
            $request->session()->forget('admin');
            return json_encode(['status' => 200]);
        }
        catch(\Exception $e){
            return json_encode(['status' => 400]);
        }
    }
}
