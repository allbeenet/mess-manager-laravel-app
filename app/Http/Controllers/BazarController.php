<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BazarController extends Controller
{
    function bazar(){
        return view('bazar');
    }

    function get_total_bazar_amount(){
        $mess_id            = $this->get_mess_id();
        $total_bazar_amount = DB::table('bazar')->where('mess_id', $mess_id)->sum('bazar.bazar_amount');
        return $total_bazar_amount;
    }

    function save_bazar(Request $request){
        $bazar_amount = strip_tags(trim($request->input('bazar_amount')));
        $mess_id      = $this->get_mess_id();

        $is_bazar = DB::table('bazar')
                    ->where('bazar_amount', $bazar_amount)
                    ->where('bazar_date', Carbon::now()->toDateString())
                    ->count();

        if($is_bazar){
            return ['status' => 409];
        }
        else{
            try{
                DB::table('bazar')->insert([
                    'bazar_amount' => $bazar_amount,
                    'bazar_date'   => Carbon::now()->toDateString(),
                    'mess_id'      => $mess_id,
                ]);
                return ['status' => 200];
            }
            catch(\Exception $e){
                return ['status' => 400];
            }
        }
    }

    //read
    function get_bazars(){
        $mess_id = $this->get_mess_id();

        return DB::table('bazar')->where('mess_id', $mess_id)
        ->orderBy('id', 'DESC')
        ->get();
    }

    //update
    function update_bazar(Request $request){
        $mess_id      = $this->get_mess_id();
        $bazar_id     = strip_tags(trim($request->input('bazar_id')));
        $bazar_amount = strip_tags(trim($request->input('bazar_amount')));
        
        try{
            DB::table('bazar')
            ->where('id', $bazar_id)
            ->where('mess_id', $mess_id)
            ->update([
                'bazar_amount' => $bazar_amount,
            ]);
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //delete
    function delete_bazar(Request $request){
        $mess_id  = $this->get_mess_id();
        $bazar_id = strip_tags(trim($request->input('bazar_id')));

        try{
            DB::table('bazar')
            ->where('id', $bazar_id)
            ->where('mess_id', $mess_id)
            ->delete();
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    function get_mess_id(){
        $mess_email = session('admin');
        $mess       = DB::table('mess')->where('mess_email', $mess_email)->get();
        $mess_id    = $mess[0]->id;
        return $mess_id;
    }
}
