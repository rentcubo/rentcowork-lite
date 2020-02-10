@extends('layouts.provider.focused') 

@section('content')

    <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="auth-form-transparent text-left p-3">

                    <div class="brand-logo">
                        <img src="{{ setting()->get('site_logo') }}" alt="logo">
                    </div>

                    @include('notifications.notification')

                    <h4>{{ tr('welcome_back') }}</h4>

                    <h6 class="font-weight-light">{{ tr('happy_to_see') }}</h6>

                    <form class="pt-3" action="{{ route('provider.login.post') }}" method="post">
                        @csrf

                        <div class="form-group">

                            <label for="exampleInputEmail">{{ tr('email') }}</label>

                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                      <i class="mdi mdi-account-outline text-primary"></i>
                                  </span>
                                </div>

                                <input type="email" name="email" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="{{ tr('email') }}" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="exampleInputPassword">{{ tr('password') }}</label>

                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                    </span>
                                </div>

                                <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="{{ tr('password') }}" required>
                            </div>
                        </div>

                        <div class="my-2 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <label class="form-check-label text-muted">
                                    <input type="checkbox" name="remember" class="form-check-input"> {{ tr('keep_me_signed') }}
                                </label>
                            </div>
                            <a href="{{ route('provider.password.request') }}" class="auth-link text-black">{{ tr('forgot_password') }}</a>
                        </div>

                        <div class="my-3">
                            <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="{{ tr('login') }}">
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                            {{ tr('dont_have_account') }} 
                            <a href="{{ route('provider.register') }}" class="text-primary">{{ tr('sign_up') }}</a>
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