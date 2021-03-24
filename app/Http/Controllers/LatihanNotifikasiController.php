<?php

namespace App\Http\Controllers;

use App\LatihanNotifikasi;
// use App\User;
use App\fcmUser;
use Illuminate\Http\Request;

class LatihanNotifikasiController extends Controller
{
    public function index(Request $req)
    {
        $input = $req->all();

        // $fcm_token = $input['token'];
        // $user_id = $input['user_id'];

        // $user = User::findOrFail($user_id);
        // $user->fcm_token = $fcm_token;

        $user = fcmUser::create([
            'name' => $input['name'],
            'fcm_token' => $input['token'],
        ]);
        
        $user->save();
        // return response()->json(['test' => $user->id]);
        return response()->json([
            'success' => true,
            'message' => 'User token updated succesfully'
        ]);
        // return view('index');
    }
}
