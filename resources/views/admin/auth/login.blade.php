@extends('layouts.admin.focused')

@section('content')
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-heading">
            <h2 class="text-center">{{tr('admin_login')}}</h2>
        </div>
        <hr />
        <div class="modal-body">
             <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                        </span>
                         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Setting::get('demo_admin_email') }}" required autocomplete="email" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-lock"></span>
                        </span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('email') ?? Setting::get('demo_admin_password') }}" name="password" required autocomplete="current-password">

                    </div>

                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-lg">{{tr('login')}}</button>
                    
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

