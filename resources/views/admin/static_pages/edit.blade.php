@extends('layouts.admin')

@section('title', tr('edit_static_page'))

@section('breadcrumb')

	  <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}"&nbsp>{{tr('home')}}</a></li>
    
    <li class="breadcrumb-item"><i class="fa fa-book"></i>
    	<a href="{{ route('admin.static_pages.index') }}">&nbsp{{tr('static_pages')}}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
    	<i class="fa fa-plus"></i><span>&nbsp{{tr('edit_static_page')}}</span>
    </li>
           
@endsection 

@section('content')

    @include('admin.static_pages._form')

@endsection
