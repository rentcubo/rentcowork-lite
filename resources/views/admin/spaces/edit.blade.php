@extends('layouts.admin')

@section('title', tr('edit_sapce'))

@section('breadcrumb')

   <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{route('admin.dashboard')}}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item">
    	<i class="fa fa-home"></i><a href="{{ route('admin.spaces.index') }}">&nbsp{{tr('spaces')}}</a>
    </li>
   
    <li class="breadcrumb-item active" aria-current="page">
    	<i class="fa fa-home"></i><span>&nbsp{{tr('edit_space')}}</span>
    </li>
           
@endsection 

@section('content')

	@include('admin.spaces._form')

@endsection