<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PostsController extends Controller
{
    
    public function index() {
        
        $posts = DB::table('posts')->get();

        return view('welcome', compact('posts'));
    }
}
