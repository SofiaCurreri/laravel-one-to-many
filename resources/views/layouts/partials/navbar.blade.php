<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        @auth
        <a class="navbar-brand d-flex align-items-center" href="{{ url('home') }} ">          
            <h1 class="text-primary"> {{env('APP_NAME')}} </h1>
        </a>
        @endauth

        @guest
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }} ">          
            <h1 class="text-primary"> {{env('APP_NAME')}} </h1>
        </a>
        @endguest

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            {{-- Questo link qui sotto lo vede solo l' utente autenticato --}}
            @auth
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        {{-- L' asterisco sta ad indicare "tutte le rotte che cominciano con admin.projects" --}}
                        <a class="nav-link @if (request()->routeIs('admin.projects*')) active @endif" href="{{route('admin.projects.index') }}">{{ __('Projects') }}</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link  @if (request()->routeIs('admin.types*')) active @endif" href="{{route('admin.types.index') }}">{{ __('Tipologie') }}</a>
                    </li>
                </ul>
            @endauth

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto d-flex flex-end">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('login')) active @endif" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link  @if (request()->routeIs('register')) active @endif" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        {{-- <a class="dropdown-item" href="{{ route('home') }}">{{__('Dashboard')}}</a> --}}
                        <a class="dropdown-item  @if (request()->routeIs('profile')) active @endif" href="{{ route('profile.edit') }}">{{__('Profile')}}</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>