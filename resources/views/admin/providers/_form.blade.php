<section class="content">

     @include('notification.notify')
     
    <div class="row">
       
        <div class="col-lg-12 grid-margin stretch-card">

            <div class="box box-primary">

                <div class="box-header bg-card-header">

                    <h4 class="">
                        @if($provider_details->id) 

                            {{tr('edit_provider')}}

                        @else
                            {{tr('add_provider')}}

                        @endif
                        <button class="btn btn-secondary pull-right">
                        <a  href="{{route('admin.providers.index')}}">
                            <i class="fa fa-eye"></i> {{tr('view_providers')}}
                        </a>
                        </button>
                        
                    </h4>

                </div>
                <div class="box-body">

                    <form class="forms-sample" action="{{ route('admin.providers.save') }}" method="POST" enctype="multipart/form-data" role="form">

                        @csrf 

                        @if($provider_details->id)

                        <input type="hidden" name="provider_id" id="provider_id" value="{{$provider_details->id}}"> 

                        @endif

                        <input type="hidden" name="login_by" id="login_by" value="{{$provider_details->login_by ?? 'manual'}}">

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="name">{{ tr('name') }} <span class="admin-required">*</span> </label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ tr('name_placeholder') }}" value="{{ old('name') ?? $provider_details->name}}" required>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="email">{{ tr('email')}} <span class="admin-required">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ tr('email_placeholder')}}" value="{{ old('email') ?? $provider_details->email}}" required>
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="mobile">{{ tr('mobile') }} <span class="admin-required">*</span> </label>
                                <input type="number" class="form-control" pattern="[0-9]{6,13}" id="mobile" name="mobile" placeholder="{{ tr('mobile_placeholder') }}" value="{{ old('mobile') ?? $provider_details->mobile}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{tr('upload_image')}}<span class="admin-required">*</span></label>
                                <div class="input-group col-xs-12">
                                    <input type="file" class="form-control file-upload-info" name="picture">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="description">{{ tr('description')}}</label>
                                <textarea type="description" class="form-control" id="description" name="description" placeholder="{{ tr('description_placeholder')}}">{{ old('description') ?? $provider_details->description}}</textarea>
                            </div>

                        </div>

                        <div class="row">

                            @if(!$provider_details->id)

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