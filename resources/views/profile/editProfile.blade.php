@extends('profile.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('profile.sidebar')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile of {{ Auth::user()->name }}</div>

                <div class="card-body">
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <h4 align="center">Edit Your profile</h4><hr>

                    {{-- 

                    <img src="{{ asset('img/'.Auth::user()->pic) }}" alt="" height="100px" width="100px"><br>

                    <a href="{{ url('/changePhoto') }}">Change Profile Picture</a>

                    <input type="text" class="form-control" name="city" value="{{ $data->city }}"> --}}
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-sm-12 col-md-12">
                                <div class="thumbnail">
                                    <h3 align="center">{{ ucwords(Auth::user()->name) }}</h3>
                                    <img src="{{ asset('img/'.Auth::user()->pic) }}" alt="" height="120px" width="120px" class="rounded-circle mx-auto d-block"><br>
                                    <div class="caption">
                                      
                                      <p align="center">{{ $data->country }} - {{ $data->city }}</p>
                                      <p align="center"><a href="{{ url('/changePhoto') }}" class="btn btn-primary" role="button">Edit Profile picture</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="edit-profile">
                            
                            <form action="{{ url('/updateProfile') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        
                                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">City Name</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="City Name" name="city" value="{{ $data->city }}">
                                            </div>
            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Country Name</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Country Name" name="country" value="{{ $data->country }}">
                                            </div>
    
                                    </div>
        
                                    <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">About</label>
                                                
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="about">{{ $data->about }}</textarea>
                                            </div>
                                            <input type="submit" class="btn btn-success">
                                        
                                    </div>
                                </div>
                            </form>
                            
                        </div>

                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
