@extends('layouts.admin')

@section('title', tr('edit_provider'))

@section('breadcrumb')

<li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

<li class="breadcrumb-item"><i class="fa fa-users"></i><a href="{{route('admin.providers.index')}}">&nbsp{{tr('providers')}}</a>
</li>

<li class="breadcrumb-item active" aria-current="page">
    <i class="fa fa-user"></i>
    <span>&nbsp{{tr('edit_provider')}}</span>
</li>
           
@endsection 

@section('content')

	@include('admin.providers._form')

@endsection