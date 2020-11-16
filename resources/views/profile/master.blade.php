<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .notify-count {
            padding: 3px 5px;
            margin-left: -7px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            background-color: #F00;
            border-radius: 10px;
            position: absolute;
        }
        #notification_drop {
            width: 350px;
        }
        #notification_drop:hover {
            background-color: #cad3e4;
        }
        .notify {
            border-bottom: solid 1px #ababab;
            background-color: #E4e9F2;
        }
        /* #notify_img {
            margin-right: 20px;
        }
        #notify_txt {
            margin-left: 20px;
        } */
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ '../findFriends' }}">Find Friends</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ '../friends' }}">Friends</a>
                            </li>
                        @endauth
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset('img/'.Auth::user()->pic) }}" alt="" height="40px" width="40px" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ '../profile' }}/{{ Auth::user()->slug }}">Profile</a>
                                    <a class="dropdown-item" href="{{ url('editProfile') }}">Edit Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="{{ '../requests' }}"><i class="fa fa-users fa-2x"></i>
                                    <span class="notify-count">{{App\friendships::where('status', Null)
                                        ->where('user_requested', Auth::user()->id)
                                        ->count()}}</span>
                                </a>
                            </li> 

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-globe fa-2x"></i><span class="notify-count">
                                        {{ App\Notifications::where('status', 1)
                                            ->where('user_from', Auth::user()->id)
                                            ->count()
                                        }}
                                    </span>
                                </a>
                                @php
                                    $notes = DB::table('users')
                                    ->leftJoin('notifications', 'users.id', 'notifications.user_to')
                                    ->where('user_from', Auth::user()->id)
                                    ->orderBy('notifications.created_at', 'desc')
                                    ->get()
                                @endphp
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    @foreach ($notes as $note)
                                    {{-- 
                                        <span style="background-color: #E4e9F2">
                                    
                                        <span>
                                     --}}
                                            @if ($note->status == 1)
                                                <div class="notify">
                                            @else
                                                <div>
                                            @endif
                                                <a class="dropdown-item" href="{{ url('notifications', $note->id) }}" id="notification_drop">
                                                    <div class="row">
                                                        <div class="col-md-2 float-left" id="notify_img">
                                                            <img src="{{ asset('img/'.$note->pic) }}" width="45px" height="45px" class="rounded">
                                                        </div>
                                                        <div class="col-md-10" id="notify_txt">
                                                            <b class="text-success">{{ ucwords($note->name) }}</b> {{ $note->note }}
                                                            <br>
                                                            <small>
                                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                                {{ date('F j, Y', strtotime($note->created_at)) }}
                                                                at {{ date('H: i', strtotime($note->created_at)) }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        
                                    @endforeach
                                </div>
                            </li>
                            
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
