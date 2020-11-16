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

                    Welcome to the profile <br>

                    <img src="{{ asset('img/'.Auth::user()->pic) }}" alt="" height="100px" width="100px"><br><br>

                    <form action="{{ url('/uploadPhoto') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="pic" id="pic" class="form-control">
                        <input type="submit" value="Change Profile picture" class="btn btn-success" name="btn">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
