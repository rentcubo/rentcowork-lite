@extends('layouts.user') 

@section('content')

    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    @include('notifications.notification')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="border-bottom text-center pb-4">
                                    <img src="{{ Auth()->user()->picture }}" alt="profile" class="img-lg rounded-circle mb-3" />

                                    <p>{{ $user_details->description }} </p>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('password.change') }}">
                                            <button class="btn btn-primary">{{ tr('change_password') }}</button>
                                        </a>
                                        <a href="{{ route('password.check') }}">
                                            <button class="btn btn-danger">{{ tr('delete_account') }}</button>
                                        </a>
                                    </div>
                                </div>

                                <div class="py-4">
                                    <p class="clearfix">
                                        <span class="float-left">
                                            {{ tr('username') }}
                                        </span>

                                        <span class="float-right text-muted">
                                            {{ $user_details->username }}
                                        </span>
                                    </p>

                                    <p class="clearfix">
                                        <span class="float-left">
                                            {{ tr('mobile') }}
                                        </span>

                                        <span class="float-right text-muted">
                                            {{ $user_details->mobile ?? '-'}}
                                        </span>
                                    </p>

                                    <p class="clearfix">
                                        <span class="float-left">
                                            {{ tr('email') }}
                                        </span>

                                        <span class="float-right text-muted">
                                            {{ $user_details->email }}
                                        </span>
                                    </p>
                                </div>

                                <a href="{{ route('profile.edit') }}">
                                    <button class="btn btn-primary btn-block">{{ tr('edit') }}</button>
                                </a>
                            </div>

                            <div class="col-lg-8">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>{{ Auth()->guard()->user()->name }}</h3>
                                    </div>
                                </div>

                                <div class="mt-4 py-2 border-top border-bottom">
                                    <ul class="nav profile-navbar">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">
                                                <i class="mdi mdi-account-outline"></i> {{ tr('info') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="profile-feed">
                                    <div class="py-4">
                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('device_type') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $user_details->device_type }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('register_type') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $user_details->register_type }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('login_by') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $user_details->login_by }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('is_email_verified') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $user_details->is_verified == EMAIL_VERIFIED ? tr('email_verified') : tr('email_not_verified')  }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                               {{ tr('status') }}
                                            </span>
                                            
                                            <span class="float-right text-muted">
                                                {{ $user_details->status == PROVIDER_ACTIVE ? tr('account_active') : tr('account_not_active') }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('created_at') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($user_details->created_at) }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('updated_at') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($user_details->updated_at) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
@endsection