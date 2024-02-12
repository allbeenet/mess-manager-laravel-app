<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function dashboard(){
        $mess_id                = $this->get_mess_id();
        $total_deposited_amount = DB::table('deposit')->where('mess_id', $mess_id)->sum('deposit.deposit_amount');
        $total_meals            = DB::table('meal')->where('mess_id', $mess_id)->sum('meal.meal_quantity');
        $total_members          = DB::table('member')->where('mess_id', $mess_id)->count();
        $total_bazar_amount     = DB::table('bazar')->where('mess_id', $mess_id)->sum('bazar.bazar_amount');
        $meal_rate;
        $total_remaining        = $total_deposited_amount - $total_bazar_amount;

        try {
            $meal_rate = round($total_bazar_amount / $total_meals);
        } 
        catch (\Throwable $e) {
            $meal_rate = 0;
        }
        return view('dashboard', ['total_remaining'=> $total_remaining, 'meal_rate'=> $meal_rate, 'total_bazar_amount'=> $total_bazar_amount,'total_deposited_amount'=> $total_deposited_amount, 'total_meals'=> $total_meals, 'total_members'=> $total_members]);
    }

    function get_members_data(Request $request){

    }

    //getting mess id
    function get_mess_id(){
        $mess_email = session('admin');
        $mess       = DB::table('mess')->where('mess_email', $mess_email)->get();
        $mess_id    = $mess[0]->id;
        return $mess_id;
    }
}
