@extends('layouts.provider.focused')

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

                    <form class="pt-3" action="{{ route('provider.password.request') }}" method="post">
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
                            <a href="{{ route('provider.register') }}" class="text-primary">{{ tr('sign_up') }}</a>
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                            {{ tr('already_account') }} 
                            <a href="{{ route('provider.login') }}" class="text-primary">{{ tr('login') }}</a>
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

 <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">{{ tr('provider_password') }}</h1>
                    <p class="mb-4">{{ tr('password_reset_info') }}</p>
                  </div>
                   @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                  <form class="user" method="POST" action="{{ route('provider.password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                <input id="password" type="password" class="form-control form-control-user" placeholder="{{ tr('new_password') }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            
                                <input id="password-confirm" type="password" class="form-control form-control-user" name="password_confirmation" placeholder="{{ tr('confirm_new_password') }}" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                           
                        </div>

                       
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            {{ tr('reset_password') }}
                        </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ route('provider.register') }}">{{ tr('create_account') }}</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{ route('provider.login') }}">{{ tr('already_account') }}</a>
                  </div>
                </div>
              </div>
            </div>
@endsection