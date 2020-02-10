@extends('layouts.user.focused')

@section('content')

    <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="auth-form-transparent text-left p-3">

                    <div class="brand-logo">
                        {{-- <img src="{{ setting()->get('site_logo') }}" alt="logo"> --}}
                    </div>

                    @include('notifications.notification')

                    <h4>{{ tr('provider_password') }}</h4>

                    <h6 class="font-weight-light">{{ tr('happy_to_see') }}</h6>

                    <form class="pt-3" action="{{ route('password.request') }}" method="post">
                        @csrf

                         <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group">
                            <label>{{ tr('password') }}</label>

                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                    </span>
                                </div>
                                
                                <input type="password" name="password" class="form-control form-control-lg border-left-0"  placeholder="{{ tr('password') }}" required>                        
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ tr('confirm_password') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                    </span>
                                </div>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg border-left-0"  placeholder="{{ tr('confirm_password') }}" required>                        
                            </div>
                          </div>

                        <div class="my-3">
                            <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value=" {{ tr('reset_password') }}">
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                            {{ tr('dont_have_account') }} 
                            <a href="{{ route('register') }}" class="text-primary">{{ tr('sign_up') }}</a>
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                            {{ tr('already_account') }} 
                            <a href="{{ route('login') }}" class="text-primary">{{ tr('login') }}</a>
                        </div>

                    </form>
                </div>
            </div>
            
            <div class="col-lg-6 login-half-bg d-flex flex-row">
                <p class="text-white font-weight-medium text-center flex-grow align-self-end"></p>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->

@endsection