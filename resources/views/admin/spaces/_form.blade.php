
<section class="content">

    @include('notification.notify')
    
    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">

            <div class="box box-primary">

                <div class="box-header bg-card-header">

                    <h4 class="">
                        @if($space_details->id) 

                            {{tr('edit_space')}}

                        @else
                            {{tr('add_space')}}

                        @endif
                        <button class="btn btn-secondary pull-right">
                        <a  href="{{route('admin.spaces.index')}}">
                            <i class="fa fa-eye"></i> {{tr('view_spaces')}}
                        </a>
                        </button>
                        
                    </h4>

                </div>
                <div class="box-body">

                    <form class="forms-sample" action="{{ route('admin.spaces.save') }}" method="POST" enctype="multipart/form-data" role="form">

                        @csrf 

                        @if($space_details->id)

                        <input type="hidden" name="space_id" id="space_id" value="{{$space_details->id}}"> 

                        @endif

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="provider">{{ tr('select_provider') }}<span class="admin-required">*</span>  </label>
                                <select class="form-control select2" name="provider_id">
                                    <option value="">{{tr('select')}}</option>
                                    @foreach($providers as $provider_details)
                                        <option value="{{$provider_details->id}}" @if($provider_details->is_selected== YES || old('provider_id')) selected @endif>{{$provider_details->name}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="name">{{ tr('space_name') }} <span class="admin-required">*</span> </label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ tr('name_placeholder') }}" value="{{ old('name') ?? $space_details->name}}" required>

                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="tagline">{{ tr('tagline') }}<span class="admin-required">*</span>  </label>
                                <input type="text" class="form-control" id="tagline" name="tagline" placeholder="{{ tr('tagline_placeholder') }}" value="{{ old('tagline') ?? $space_details->tagline}}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="description">{{ tr('description')}}</label>
                                <textarea  class="form-control" id="description" name="description" placeholder="{{ tr('description_placeholder')}}">{{ old('description') ?? $space_details->description}}</textarea>
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
                                <label for="full_address">{{ tr('full_address')}} <span class="admin-required">*</span></label>
                                <input type="text" class="form-control" id="full_address" name="full_address" placeholder="{{ tr('full_address_placeholder')}}" value="{{ old('full_address') ?? $space_details->full_address}}" required>
                            </div>

                        </div>

                        <div class="row">

                             <div class="form-group col-md-6">
                                <label for="instructions">{{ tr('instructions') }} <span class="admin-required">*</span></label>
                                <input type="text" class="form-control" id="instructions" name="instructions" placeholder="{{ tr('instructions_placeholder') }}" value="{{old('instructions') ?? $space_details->instructions}}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="per_hour">{{ tr('per_hour')}} <span class="admin-required">*</span></label>
                                <input type="number" class="form-control" id="per_hour" name="per_hour" placeholder="{{Setting::get('currency')}}" value="{{ old('per_hour') ?? $space_details->per_hour}}" required>
                            </div>
                        </div>

                        <button type="reset" class="btn btn-light">{{ tr('reset')}}</button>

                        <button type="submit" class="btn btn-success mr-2 pull-right">{{ tr('submit') }} </button>

                    </form>
                </div>

            </div>

        </div>
    </div>
</section>