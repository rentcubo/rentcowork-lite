
<section class="content">

    @include('notification.notify')

    <div class="row">
       
        <div class="col-lg-12 grid-margin stretch-card">
            
            <div class="box box-primary">

                <div class="box-header bg-card-header">

                    <h4 class="">
                        @if($user_details->id) 

                            {{tr('edit_user')}}

                        @else
                            {{tr('add_user')}}

                        @endif
                        <button class="btn btn-secondary pull-right">
                        <a  href="{{route('admin.users.index')}}">
                            <i class="fa fa-eye"></i> {{tr('view_users')}}
                        </a>
                        </button>
                        
                    </h4>

                </div>
                <div class="box-body">

                    <form class="forms-sample" action="{{ route('admin.users.save') }}" method="POST" enctype="multipart/form-data" role="form">

                        @csrf 

                        @if($user_details->id)

                        <input type="hidden" name="user_id" id="user_id" value="{{$user_details->id}}"> 

                        @endif

                        <input type="hidden" name="login_by" id="login_by" value="{{$user_details->login_by ?? 'manual'}}">

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="first_name">{{ tr('first_name') }} <span class="admin-required">*</span> </label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="{{ tr('first_name_placeholder') }}" value="{{ old('first_name') ?? $user_details->first_name}}" required>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name">{{ tr('last_name') }} <span class="admin-required">*</span> </label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="{{ tr('last_name_placeholder') }}" value="{{ old('last_name') ?? $user_details->last_name}}" required>

                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="mobile">{{ tr('mobile') }} </label>
                                <input type="number" class="form-control" pattern="[0-9]{6,13}" id="mobile" name="mobile" placeholder="{{ tr('mobile_placeholder') }}" value="{{ old('mobile') ?? $user_details->mobile}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="description">{{ tr('description')}}</label>
                                <textarea  class="form-control" id="description" name="description" placeholder="{{ tr('description_placeholder')}}">{{ old('description') ?? $user_details->description}}</textarea>
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>{{tr('upload_image')}}</label>
                                <div class="input-group col-xs-12">
                                    <input type="file" class="form-control file-upload-info" name="picture">
                                </div>
                            </div>

                             <div class="form-group col-md-6">
                                <label for="email">{{ tr('email')}} <span class="admin-required">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ tr('email_placeholder')}}" value="{{ old('email') ?? $user_details->email}}" required>
                            </div>

                            @if(!$user_details->id)

                            <div class="form-group col-md-6">
                                <label for="password">{{ tr('password') }} <span class="admin-required">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{ tr('password_placeholder') }}" value="{{old('password')}}" required title="{{ tr('password_notes') }}">
                            </div>

                            @endif

                        </div>

                        <button type="reset" class="btn btn-light">{{ tr('reset')}}</button>

                        <button type="submit" class="btn btn-success mr-2 pull-right">{{ tr('submit') }} </button>

                    </form>
                </div>

            </div>

        </div>
    </div>
</section>