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

                    <h4>{{ tr('new_here') }}</h4>

                    <h6 class="font-weight-light">{{ tr('join_us') }}</h6>

                    <form action="{{ route('provider.register.post') }}" method="POST" class="pt-3">
                        
                        @csrf

                        <input type="hidden" name="timezone" class="form-control " id="timezone"  value="" />

                        <div class="form-group">

                            <label>{{ tr('name') }} *</label>

                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-account-outline text-primary"></i>
                                    </span>
                                </div>

                                <input type="text" name="name" class="form-control form-control-lg border-left-0" placeholder="{{ tr('name') }}" value="{{ old('name') }}" required>

                            </div>
                        </div>

                        <div class="form-group">

                            <label>{{ tr('email') }} *</label>

                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-email-outline text-primary"></i>
                                    </span>
                                </div>

                                <input type="email" name="email" class="form-control form-control-lg border-left-0" placeholder="{{ tr('email') }}" value="{{ old('email') }}" required>

                            </div>
                        </div>

                        <div class="form-group">

                            <label>{{ tr('password') }} *</label>

                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                    </span>
                                </div>

                                <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="{{ tr('password') }}" required>

                            </div>
                        </div>

                        <div class="form-group">

                            <label>{{ tr('confirm_password') }} *</label>

                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                    </span>
                                </div>

                                <input type="password" name="password_confirmation" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="{{ tr('confirm_password') }}" required>

                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">

                                <label class="form-check-label text-muted">
                                    <input type="checkbox" class="form-check-input" required> {{ tr('agree_conditions') }}
                                </label>

                            </div>
                        </div>

                        <div class="mt-3">
                            <input type="submit" value="{{ tr('sign_up') }}" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                             {{ tr('already_account') }}

                             <a href="{{ route('provider.login') }}" class="text-primary">{{ tr('login') }}</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 register-half-bg d-flex flex-row">
     
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->

     <script type="text/javascript">

        timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        document.getElementById('timezone').value = timezone;

    </script>
@endsection