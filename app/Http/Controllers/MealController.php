<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{
    function meal(){
        return view('meal');
    }

    function get_total_meals(){
        $mess_id     = $this->get_mess_id();
        $total_meals = DB::table('meal')->where('mess_id', $mess_id)->sum('meal.meal_quantity');
        return $total_meals;
    }

    function get_mess_id(){
        $mess_email = session('admin');
        $mess       = DB::table('mess')->where('mess_email', $mess_email)->get();
        $mess_id    = $mess[0]->id;
        return $mess_id;
    }

    function save_meal(Request $request){
        $meal_quantity = strip_tags(trim($request->input('meal_quantity')));
        $member_id     = strip_tags(trim($request->input('member_id')));
        $mess_id       = $this->get_mess_id();

        try{
            DB::table('meal')->insert([
                'meal_quantity' => $meal_quantity,
                'meal_date'     => Carbon::now()->toDateString(),
                'member_id'     => $member_id,
                'mess_id'       => $mess_id,
            ]);
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //read
    function get_meals(){
        $mess_id = $this->get_mess_id();

        return DB::table('meal')->where('meal.mess_id', $mess_id)
        ->join('member', 'meal.member_id', 'member.id')
        ->select('meal.*', 'member.member_name')
        ->orderBy('meal.id', 'DESC')
        ->get();
    }

    //update
    function update_meal(Request $request){
        $mess_id       = $this->get_mess_id();
        $meal_id       = strip_tags(trim($request->input('meal_id')));
        $meal_quantity = strip_tags(trim($request->input('meal_quantity')));
        
        try{
            DB::table('meal')
            ->where('id', $meal_id)
            ->where('mess_id', $mess_id)
            ->update([
                'meal_quantity' => $meal_quantity,
            ]);
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //delete
    function delete_meal(Request $request){
        $mess_id = $this->get_mess_id();
        $meal_id = strip_tags(trim($request->input('meal_id')));

        try{
            DB::table('meal')
            ->where('id', $meal_id)
            ->where('mess_id', $mess_id)
            ->delete();
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //filter
    function filter_meal(Request $request){
        $mess_id   = $this->get_mess_id();
        $member_id = strip_tags(trim($request->input('member_id')));

        if($member_id == ''){
            $total_meals = DB::table('meal')
                           ->where('mess_id', $mess_id)
                           ->sum('meal.meal_quantity');

            $records = DB::table('meal')->where('meal.mess_id', $mess_id)
                       ->join('member', 'meal.member_id', 'member.id')
                       ->select('meal.*', 'member.member_name')
                       ->orderBy('meal.id', 'DESC')
                       ->get();

            return ['amount' => $total_meals, 'records'=> $records];
        }
        else{
            $total_meals = DB::table('meal')
                           ->where('mess_id', $mess_id)
                           ->where('member_id', $member_id)
                           ->sum('meal.meal_quantity');

            $records = DB::table('meal')
                      ->where('meal.mess_id', $mess_id)
                      ->where('member_id', $member_id)
                      ->join('member', 'meal.member_id', 'member.id')
                      ->select('meal.*', 'member.member_name')
                      ->orderBy('id', 'DESC')
                      ->get();

            return ['amount' => $total_meals, 'records'=> $records];
        }
    }
}
