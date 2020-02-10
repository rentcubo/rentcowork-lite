@extends('layouts.provider')

@section('content')

    <div class="row">

    <div class="col-12 grid-margin">

        <div class="card card-password1">
            <div class="card-body">
                <h4 class="card-title">{{ tr('delete_account') }}</h4>

                @include('notifications.notification')

                <form class="form-sample" action="{{ route('provider.account.delete') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">{{ tr('confirm_password') }} *</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" name="password" placeholder="{{ tr('confirm_password') }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">

                            <button type="reset" class="btn btn-light">{{tr('reset')}}</button>

                            <div class="form-group row float-right">
                                <input type="submit" name="submit" value="{{ tr('delete_account') }}" class="btn btn-danger">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection