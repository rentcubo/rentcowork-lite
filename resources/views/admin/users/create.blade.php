@extends('layouts.admin') 

@section('title', tr('add_user'))

@section('breadcrumb')

	<li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>
    
    <li class="breadcrumb-item"><i class="fa fa-user"></i><a href="{{ route('admin.users.index')}}">&nbsp{{tr('users')}}</a></li>

    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-user-plus"></i><span>&nbsp{{ tr('add_user') }}</span></li> 
           
@endsection 

@section('content') 

	@include('admin.users._form') 

@endsection