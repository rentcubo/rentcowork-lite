@extends('layouts.admin')

@section('title',tr('profile'))

@section('breadcrumb')

    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item active"><i class="fa fa-user-plus"></i><a href="{{ route('admin.profile') }}">&nbsp{{tr('profile')}}</a></li>
@endsection 

@section('content')

<!-- Main content -->
<section class="content">

    <div class="row">

    <div class="col-md-5 grid-margin stretch-card">
       
        <div class="box">
            <div class="box-body">
                <h4 class="card-title">{{ tr('update_profile') }}</h4>
                
                <form class="forms-sample" role="form" method="POST" action="{{route('admin.profile.save')}}" enctype="multipart/form-data">

                    @csrf
                    
                    <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id }}">

                    <div class="form-group">
                        <label for="name">{{tr('name')}}</label>
                        <input type="text" class="form-control" name="name" required id="name" placeholder="Enter {{tr('name')}}" value="{{old('name') ? old('name') : Auth::guard('admin')->user()->name}}" pattern="[a-zA-Z0-9\s\-]{2,255}">
                    </div>

                    <div class="form-group">
                        <label for="email">{{tr('email')}}</label>
                        <input type="email" name="email" required class="form-control" id="email" placeholder="Enter {{tr('email')}}" value="{{old('email') ? old('email') : Auth::guard('admin')->user()->email}}">
                    </div>

                    <div class="form-group">
                        <label for="picture">{{tr('picture')}}</label>
                        <input type="file" name="picture" class="form-control" id="picture" accept="image/*">
                    </div>

                    <button type="reset" class="btn btn-light">{{tr('reset')}}</button>

                    <button type="submit" class="btn btn-success ">
                        {{tr('submit')}}
                    </button>
                   
                </form>

            </div>

        </div>

    </div>

    <div class="col-md-5 d-flex align-items-stretch grid-margin">
        <div class="row flex-grow">
            <div class="col-12 grid-margin">
                <div class="box">
                    <div class="box-body">
                        <h4 class="card-title">{{ tr('change_password')}}</h4>

                        <form  action="{{route('admin.change.password')}}" method="POST" enctype="multipart/form-data" role="form">

                            @csrf

                            <div class="form-group">
                                <label for="old_password">{{tr('old_password')}}<span class="required" aria-required="true"> * </span></label>
                                <input type="password" required class="form-control" name="old_password" id="old_password" placeholder="Enter {{tr('old_password')}}" pattern=".{6,}" title="tr('old_password_title')">
                            </div>

                            <div class="form-group">
                                <label for="new_password">{{tr('new_password')}}<span class="required" aria-required="true"> * </span></label>
                                <input type="password" required class="form-control" name="password" id="new_password" placeholder="Enter {{tr('new_password')}}" pattern=".{6,}" title="tr('new_password_title')">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">{{tr('confirm_password')}}<span class="required" aria-required="true"> * </span></label>
                                <input type="password" required class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter {{tr('confirm_password')}}" pattern=".{6,}" title="tr('confirm_password_title')">
                            </div>

                            <button type="reset" class="btn btn-light">
                                {{tr('reset')}}
                            </button>

                            <button type="submit" class="btn btn-success mr-2">{{ tr('submit') }}</button> 

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</section>

@endsection