<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title') @yield('title') | @endif {{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="https://www.comitedesolidaridad.com/sites/default/files/favicon_0.ico" type="image/vnd.microsoft.icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin-lte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin-lte/dist/css/adminlte.min.css')}}">
    <!-- Live Wire -->
    @livewireStyles
    <!-- Stacks -->
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->                

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{url('/')}}" class="brand-link">
                <img src="{{asset('img/logo_cssp.svg')}}" alt="CSPP" class="img-fluid">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @else
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if(Auth::user()->img_user == "null")
                        <img class="img-circle elevation-2" src="{{asset('sb-admin/img/user.svg')}}" width="50%">
                        @else
                        <img class="img-circle elevation-2" src="{{ asset('storage/profile-photos/'.Auth::user()->img_user) }}">
                        @endif
                        <!--img src="{{asset('admin-lte/dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image"-->
                    </div>
                    <div class="info">
                    <a href="{{url('perfil')}}" class="d-block">{{Auth::user()->nombres}}</a>
                    </div>
                </div>
                @endguest

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{url('/')}}" class="nav-link {{ request()->routeIs('home') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('roles') || request()->routeIs('modulos') || request()->routeIs('permisos') || request()->routeIs('users') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('roles') || request()->routeIs('modulos') || request()->routeIs('permisos') || request()->routeIs('users') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Usuarios
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('roles')}}" class="nav-link {{ request()->routeIs('roles') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('modulos')}}" class="nav-link {{ request()->routeIs('modulos') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Módulos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('permisos')}}" class="nav-link {{ request()->routeIs('permisos') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permisos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('users')}}" class="nav-link {{ request()->routeIs('users') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Usuarios</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ request()->routeIs('paises') || request()->routeIs('departamentos') || request()->routeIs('municipios') || request()->routeIs('organizacions') || request()->routeIs('areas') || request()->routeIs('empleados') || request()->routeIs('rubros') || request()->routeIs('donantes') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('paises') || request()->routeIs('departamentos') || request()->routeIs('municipios') || request()->routeIs('organizacions') || request()->routeIs('areas') || request()->routeIs('empleados') || request()->routeIs('rubros') || request()->routeIs('donantes') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Configuración
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('paises')}}" class="nav-link {{ request()->routeIs('paises') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Paises</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('departamentos')}}" class="nav-link {{ request()->routeIs('departamentos') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Departamentos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('municipios')}}" class="nav-link {{ request()->routeIs('municipios') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Municipios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('organizacions')}}" class="nav-link {{ request()->routeIs('organizacions') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Organizaciones</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('areas')}}" class="nav-link {{ request()->routeIs('areas') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Áreas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('empleados')}}" class="nav-link {{ request()->routeIs('empleados') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Empleados</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('rubros')}}" class="nav-link {{ request()->routeIs('rubros') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rubros</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('donantes')}}" class="nav-link {{ request()->routeIs('donantes') ? 'active' : ''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Donantes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">FORMULACIÓN PROYECTOS</li>
                        <li class="nav-item">
                            <a href="{{url('proyectos')}}" class="nav-link {{ request()->routeIs('proyectos') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-project-diagram"></i>
                                <p>Proyectos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('resultados')}}" class="nav-link {{ request()->routeIs('resultados') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-chart-line"></i>
                                <p>Resultados</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('actividades')}}" class="nav-link {{ request()->routeIs('actividades') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-tasks"></i>
                                <p>Actividades</p>
                            </a>
                        </li>
                        <li class="nav-header">EJECUCIÓN DEL PROYECTO</li>
                        <li class="nav-item">
                            <a href="{{url('avances')}}" class="nav-link {{ request()->routeIs('avances') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-plus"></i>
                                <p>Avances</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('anticipos')}}" class="nav-link {{ request()->routeIs('anticipos') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>Anticipos</p>
                            </a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>{{ __('Cerrar Sesión') }}</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">

            @yield('content')

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.1.0
            </div>
            <strong>Copyright &copy; {{date('Y')}} <a href="https://edgasanc.com" target="_blank">EDGASANC.COM</a>.</strong> Todos los derechos reservados.
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{asset('admin-lte/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin-lte/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('admin-lte/dist/js/demo.js')}}"></script>
    <!-- Live Wire -->
    @livewireScripts
    <!-- OpenModal -->
    <script type="text/javascript">
        window.livewire.on('closeModal', () => {
            $('#createDataModal').modal('hide');
            $('#aprobarModal').modal('hide');
        });
    </script>
    <!-- Stacks -->
    @stack('scripts')
</body>
</html>
