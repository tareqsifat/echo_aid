@extends('profile.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        @include('profile.sidebar')
        
        @foreach ($userData as $user)
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile of {{ $user->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4 align="center">Welcome to the profile</h4><hr>

                    
                          <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="thumbnail">
                                        <h3 align="center">{{ ucwords( $user->name) }}</h3>
                                        <img src="{{ asset('img/'.$user->pic) }}" alt="" height="120px" width="120px" class="rounded-circle mx-auto d-block"><br>
                                        <div class="caption">
                                          
                                          <p align="center">{{ $user->country }} - {{ $user->city }}</p>

                                            @if ($user->user_id == Auth::user()->id)
                                                <p align="center"><a href="{{ url('editProfile') }}" class="btn btn-primary" role="button">Edit Profile</a></p>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <h4>About</h4>
                                    <p>{{ $user->about }}</p>
                                </div>
                            </div>
                          </div>
                        

                    
                    
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
</div>
@endsection
