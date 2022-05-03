<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request){
        $user = json_decode($request->dados);
        $result = User::where('email', $user->email)
            ->where('password', sha1($user->password))
            ->get();         
        return json_encode($result);
    }
}
