@extends('profile.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('profile.sidebar')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">FInd Friends</div>

                <div class="card-body">
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card card-default">
                                <div class="card-header">{{Auth::user()->name}}</div>
                
                                <div class="card-body">
                                    <div class="col-sm-12 col-md-12">
                                        @foreach ($users as $user)
                
                                        <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                                            <div class="col-md-2 pull-left">
                                                <img src="{{ asset('img/'.$user->pic) }}"
                                                width="80px" height="80px" class="rounded">
                                            </div>
                
                                            <div class="col-md-7 pull-left">
                                                <h3 style="margin:0px;"><a href="{{url('/profile')}}/{{$user->slug}}">
                                                  {{ucwords($user->name)}}</a></h3>
                                                <p><i class="fa fa-globe"></i> {{$user->city}}  - {{$user->country}}</p>
                                                <p>{{$user->about}}</p>
                                            </div>
                
                                            <div class="col-md-3 pull-right">
                
                                                <?php
                                                $check = DB::table('friendships')
                                                        ->where('user_requested', '=', $user->id)
                                                        ->where('requester', '=', Auth::user()->id)
                                                        ->first();
                
                                                if($check == ''){
                                                ?>
                                                   <p>
                                                        <a href="{{url('/')}}/addFriend/{{$user->id}}"
                                                           class="btn btn-info btn-sm">Add to Friend</a>
                                                    </p>
                                                 <?php } else {?>

                                                    <p>Request Already Sent</p>

                                                <?php }?>

                                            </div>
                
                                        </div>
                                        @endforeach
                                    </div>
                
                
                
                
                                </div>
                            </div>
                        </div>

                    </div>

                    


                    
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
