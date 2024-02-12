<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    function member(){
        return view('member');
    }

    function get_mess_id(){
        $mess_email = session('admin');
        $mess       = DB::table('mess')->where('mess_email', $mess_email)->get();
        $mess_id    = $mess[0]->id;
        return $mess_id;
    }

    function get_total_members(){
        $mess_id       = $this->get_mess_id();
        $total_members = DB::table('member')->where('mess_id', $mess_id)->count();
        return $total_members;
    }

    function save_member(Request $request){
        $member_name   = strip_tags(trim($request->input('member_name')));
        $member_email  = strip_tags(trim($request->input('member_email')));
        $member_number = strip_tags(trim($request->input('member_number')));

        $mess_id       = $this->get_mess_id();

        $is_member = DB::table('member')
                     ->where('member_name', $member_name)
                     ->where('mess_id', $mess_id)
                     ->count();

        if($is_member){
            return ['status' => 409];
        }
        else{
            try{
                DB::table('member')->insert([
                    'member_name'   => $member_name,
                    'member_email'  => $member_email,
                    'member_number' => $member_number,
                    'mess_id'       => $mess_id,
                ]);
                return ['status' => 200];
            }
            catch(\Exception $e){
                return ['status' => 400];
            }
        }
    }

    //read
    function get_members(){
        $mess_id = $this->get_mess_id();
        return DB::table('member')->where('mess_id', $mess_id)->orderBy('id', 'DESC')->get();
    }

    //update
    function update_member(Request $request){
        $mess_id       = $this->get_mess_id();
        $member_id     = strip_tags(trim($request->input('member_id')));
        $member_name   = strip_tags(trim($request->input('member_name')));
        $member_number = strip_tags(trim($request->input('member_number')));

        try{
            DB::table('member')
            ->where('id', $member_id)
            ->where('mess_id', $mess_id)
            ->update([
                'member_name'   => $member_name,
                'member_number' => $member_number,
                'mess_id'       => $mess_id,
            ]);
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //delete
    function delete_member(Request $request){
        $mess_id   = $this->get_mess_id();
        $member_id = strip_tags(trim($request->input('member_id')));

        try{
            DB::table('member')->where('id', $member_id)->where('mess_id', $mess_id)->delete();
            return ['status' => 200];
        }
        catch(\Exception $e){
            return ['status' => 400];
        }
    }

    //search
    function search_member(Request $request){
        $mess_id     = $this->get_mess_id();
        $member_name = strip_tags(trim($request->input('member_name')));

        return DB::table('member')
        ->where('mess_id', $mess_id)
        ->where('member_name', 'LIKE', "{$member_name}%")
        ->orderBy('id', 'DESC')
        ->get();
    }
}
