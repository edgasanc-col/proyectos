@extends('layouts.admin-lte')
@section('title', __('Dashboard'))
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Dashboard</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container-fluid">
    <!-- Content Header (Page header) -->
    @livewire('dashboard')
</div>
@endsection