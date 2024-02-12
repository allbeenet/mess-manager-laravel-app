<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    function deposit(){
        return view('deposit');
    }

    function get_total_deposited_amount(){
        $mess_id                = $this->get_mess_id();
        $total_deposited_amount = DB::table('deposit')->where('mess_id', $mess_id)->sum('deposit.deposit_amount');
        return $total_deposited_amount;
    }

    function get_mess_id(){
        $mess_email = session('admin');
        $mess       = DB::table('mess')->where('mess_email', $mess_email)->get();
        $mess_id    = $mess[0]->id;
        return $mess_id;
    }

    function save_deposit(Request $request){
        $deposit_amount = strip_tags(trim($request->input('deposit_amount')));
        $member_id      = strip_tags(trim($request->input('member_id')));
        $mess_id        = $this->get_mess_id();

        try{
            DB::table('deposit')->insert([
                'deposit_amount' => $deposit_amount,
                'deposit_date'   => Carbon::now()->toDateString(),
                'member_id'      => $member_id,
                'mess_id'        => $mess_id,
            ]);
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //read
    function get_deposits(){
        $mess_id = $this->get_mess_id();

        return DB::table('deposit')->where('deposit.mess_id', $mess_id)
        ->join('member', 'deposit.member_id', 'member.id')
        ->select('deposit.*', 'member.member_name')
        ->orderBy('deposit.id', 'DESC')
        ->get();
    }

    //update
    function update_deposit(Request $request){
        $mess_id        = $this->get_mess_id();
        $deposit_id     = strip_tags(trim($request->input('deposit_id')));
        $deposit_amount = strip_tags(trim($request->input('deposit_amount')));
        
        try{
            DB::table('deposit')
            ->where('id', $deposit_id)
            ->where('mess_id', $mess_id)
            ->update([
                'deposit_amount' => $deposit_amount,
            ]);
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //delete
    function delete_deposit(Request $request){
        $mess_id    = $this->get_mess_id();
        $deposit_id = strip_tags(trim($request->input('deposit_id')));

        try{
            DB::table('deposit')
            ->where('id', $deposit_id)
            ->where('mess_id', $mess_id)
            ->delete();
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //filter
    function filter_deposit(Request $request){
        $mess_id   = $this->get_mess_id();
        $member_id = strip_tags(trim($request->input('member_id')));

        if($member_id == ''){
            $total_deposited_amount = DB::table('deposit')
                                      ->where('mess_id', $mess_id)
                                      ->sum('deposit.deposit_amount');

            $records = DB::table('deposit')->where('deposit.mess_id', $mess_id)
                      ->join('member', 'deposit.member_id', 'member.id')
                      ->select('deposit.*', 'member.member_name')
                      ->orderBy('deposit.id', 'DESC')
                      ->get();

            return ['amount' => $total_deposited_amount, 'records'=> $records];
        }
        else{
            $total_deposited_amount = DB::table('deposit')
                                      ->where('mess_id', $mess_id)
                                      ->where('member_id', $member_id)
                                      ->sum('deposit.deposit_amount');

            $records = DB::table('deposit')
                      ->where('deposit.mess_id', $mess_id)
                      ->where('member_id', $member_id)
                      ->join('member', 'deposit.member_id', 'member.id')
                      ->select('deposit.*', 'member.member_name')
                      ->orderBy('id', 'DESC')
                      ->get();

            return ['amount' => $total_deposited_amount, 'records'=> $records];
        }
    }
}
