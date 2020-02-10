 @extends('layouts.user')

@section('content')
<div class="row">

    <div class="col-12 grid-margin">

        <div class="card card-password">
            <div class="card-body">
                <h4 class="card-title">{{ tr('edit_password') }}</h4>

                @include('notifications.notification')

                <form class="form-sample" action="{{ route('password.save') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">    
                        <input type="hidden" name="id" class="form-control" value="{{ $user_details->id }}" >
                    </div>

                     <div class="row">
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">{{ tr('old_password') }} *</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="old_password" placeholder="{{ tr('old_password') }}" value="{{ old('old_password') }}" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">{{ tr('new_password') }} *</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password" placeholder="{{ tr('new_password') }}" value="{{ old('password') }}" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">{{ tr('confirm_password') }} *</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="{{ tr('confirm_password') }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   <div class="row">
                        <div class="col-md-12">

                            <button type="reset" class="btn btn-danger">{{tr('reset')}}</button>
                            
                            <div class="form-group row float-right">
                                <input type="submit" name="submit" value="{{ tr('edit_password') }}" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
  @endsection