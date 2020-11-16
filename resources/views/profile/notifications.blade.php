@extends('profile.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('profile.sidebar')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Notifications</div>

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
                                        @if (session()->has('msg'))
                                            <p class="alert alert-success">
                                                {{ session()->get('msg') }}
                                            </p>
                                        @endif
                                        @foreach ($notes as $note)
                
                                            <ul>
                                                <li>
                                                    <p><a href="{{url('/profile')}}/{{$note->slug}}" class="text-success">{{ $note->name }}</a> {{ $note->note }}</p>
                                                </li>
                                            </ul>
                
                                        
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
