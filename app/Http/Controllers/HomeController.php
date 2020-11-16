<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\profile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function findFriends() {
        $uid = Auth::user()->id;
        $allUsers = DB::table('profiles')->leftJoin('users', 'users.id', '=', 'profiles.user_id')->where('users.id', '!=', $uid)->get();
        
        return view('profile.findFriends')->with('users', $allUsers);
    }
}
