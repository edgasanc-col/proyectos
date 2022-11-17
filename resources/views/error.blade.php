@extends('layouts.admin-lte')
@section('title', __('Error 404'))
@section('content')
<div class="container-fluid">
	<!-- 404 Error Text -->
    <div class="text-center">
        <div class="error mx-auto" data-text="404"><h1 style="font-size: 200px">404</h1></div>
        <p class="lead text-gray-800 mb-5">Página No Encontrada</p>
        <p class="text-gray-500 mb-0">No cuenta con los permisos necesarios para visualizar este módulo...</p>
        <a href="{{route('home')}}">&larr; Regrese al Dashboard</a>
    </div>
</div>
@endsection