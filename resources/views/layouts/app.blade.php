<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@hasSection('title') @yield('title') | @endif {{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="https://www.comitedesolidaridad.com/sites/default/files/favicon_0.ico" type="image/vnd.microsoft.icon">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	 @livewireStyles
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
					@auth()
                    <ul class="navbar-nav mr-auto">
						<!--Nav Bar Hooks - Do not delete!!-->
						<li class="nav-item">
                            <a href="{{ url('/anticipos') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Anticipos</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/avances') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Avances</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/actividades') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Actividades</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/resultados') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Resultados</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/proyectos') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Proyectos</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/donantes') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Donantes</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/rubros') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Rubros</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/empleados') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Empleados</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/areas') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Areas</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/organizacions') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Organizacions</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/municipios') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Municipios</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/departamentos') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Departamentos</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/paises') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Paises</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/users') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Users</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/permisos') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Permisos</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/modulos') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Modulos</a> 
                        </li>
						<li class="nav-item">
                            <a href="{{ url('/roles') }}" class="nav-link"><i class="fab fa-laravel text-info"></i> Roles</a> 
                        </li>
                    </ul>
					@endauth()
					
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                                <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nombres }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
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

        <main class="py-2">
            @yield('content')
        </main>
    </div>
    @livewireScripts
<script type="text/javascript">
	window.livewire.on('closeModal', () => {
		$('#createDataModal').modal('hide');
	});
</script>
</body>
</html>
