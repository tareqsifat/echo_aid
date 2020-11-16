<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\profile;
use App\Friendships;
use App\Notifications;
use DB;

class ProfileController extends Controller
{
    public function index($slug) {

        $userData = DB::table('users')
        ->leftJoin('profiles', 'profiles.user_id', 'users.id')
        ->where('slug', $slug)
        ->get();

        return view('profile.index', compact('userData'))->with('data', Auth::user()->profile);
    }

    //retuen a view for updating profile pic
    public function changePhoto() {
        return view('profile.pic');
    }

    //Update the profile picture
    public function uploadPhoto(Request $request) {
        if($request->hasFile('pic')) {
            //Upload it
            $file = request()->file('pic');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/img/', $fileName);

            $oldfilename = Auth::user()->pic;

            //Uodate the database
            $user_id = Auth::user()->id;
            
            $user = User::find($user_id);

            $user->pic = $fileName;

            $user->save();

            return redirect()->back();
            //delete the old file
            $user->deleteImage();

        }
    }

    //return a view for updating profile data
    public function editProfile() {
        return view('profile.editProfile')->with('data', Auth::user()->profile);
    }

    public function updateProfile(Request $request) {
        $user_id = Auth::user()->id;

        $user = profile::find($user_id);
        $user->update([
            'country' => $request->country,
            'city' => $request->city,
            'about' => $request->about
        ]);

        return back();
    }

    public function addFriend($id) {
        echo Auth::user()->addFriend($id);
        return back(); 
    }
    
    public function requests()
    {
        $uid = Auth::user()->id;

        $Friendrequest = DB::table('friendships')
        ->rightJoin('users', 'users.id', '=', 'friendships.requester')
        ->where('status', '=', Null)
        ->where('friendships.user_requested', '=', $uid)->get(); 

        return view('profile.requests', compact('Friendrequest'));

    }

    public function accept($id)
    {
        $uid = Auth::user()->id;
        $checkRequest = friendships::where('requester', $id)
        ->where('user_requested', $uid)
        ->first();

        if($checkRequest) {
            //echo "updating";
            $updateFriend = DB::table('friendships')
              ->where('user_requested', $uid)
              ->where('requester', $id)
              ->update(['status' => 1]);


            $notifications = new Notifications;
            $notifications->note = 'Accepted Your Request'; 
            $notifications->user_from = $id;
            $notifications->user_to = Auth::user()->id;
            $notifications->status = '1';
            $notifications->save();

            if($updateFriend) {
                return back()->with('msg','Yor are now Friend with each other');
            }

        }
        else {
            echo "Something went wrong";
            
        }
    }

    //Add Friend
    public function friends() {
        $uid = Auth::user()->id;

        $friendTo = DB::table('friendships')
        ->leftJoin('users', 'users.id', 'friendships.user_requested')
        ->where('status', 1)
        ->where('requester', $uid)
        ->get();

        $friendFrom = DB::table('friendships')
        ->leftJoin('users', 'users.id', 'friendships.requester')
        ->where('status', 1)
        ->where('user_requested', $uid)
        ->get();

        $friends = array_merge($friendTo->toArray(), $friendFrom->toArray());

        return view('profile.friends', compact('friends'));
    }

    //Cancel Friend Request
    public function removeRequest($id)
    {
        DB::table('friendships')->where('user_requested', Auth::user()->id)
        ->where('requester', $id)
        ->delete();
        
        return back()->with('msg','Request has been deleted');
    }

    //sending Notifications
    public function notifications($id) {
        
        $notes = DB::table('notifications')
        ->leftJoin('users', 'users.id', 'notifications.user_to')
        ->where('notifications.id', $id)
        ->where('user_from', Auth::user()->id)
        ->orderBy('notifications.created_at', 'desc')
        ->get();

        $updateNote = DB::table('notifications')
        ->where('notifications.id', $id)
        ->update(['status' => 0]);

        return view('profile.notifications', compact('notes'));

    }

    //Unfreind Functionality
    public function unfriend($id) {
        
        $loggedUser = Auth::user()->id;

        DB::table('friendships')
        ->where('requester', $loggedUser)
        ->where('user_requested', $id)
        ->delete();

        return back()->with('msg','You are no longer firend with this user');
    }
}
