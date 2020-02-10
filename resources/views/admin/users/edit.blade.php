@extends('layouts.admin')

@section('title', tr('edit_user'))

@section('breadcrumb')
	<li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>
    
    <li class="breadcrumb-item"><i class="fa fa-user"></i><a href="{{ route('admin.users.index')}}">&nbsp{{tr('users')}}</a></li>

    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-user-plus"></i><span>&nbsp{{ tr('edit_user') }}</span></li> 
           
@endsection 

@section('content')

	@include('admin.users._form')

@endsection