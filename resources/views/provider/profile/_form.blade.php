<div class="row">

    <div class="col-12 grid-margin">

        <div class="card card-edit">
            <div class="card-body">
                <h4 class="card-title">{{ tr('edit_profile') }}</h4>

                @include('notifications.notification')

                <form class="form-sample" action="{{ route('provider.profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">    
                        <input type="hidden" name="id" class="form-control" value="{{ $provider_details->id }}" >
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('name') }} *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" placeholder="{{ tr('name') }}" value="{{ old('name') ?? $provider_details->name }}" required />
                                </div>
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('email') }} *</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" placeholder="{{ tr('email') }}" value="{{ old('email') ?? $provider_details->email }}" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('mobile') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="mobile" placeholder="{{ tr('mobile') }}" value="{{ old('mobile') ?? $provider_details->mobile }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('description') }} *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="description" placeholder="{{ tr('description') }}" value="{{ old('description') ?? $provider_details->description }}" required />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">{{ tr('picture') }}</label>

                                <div class="col-sm-9">

                                    <input type="file" name="picture"  onchange="readURL(this);" class="form-control-file" value="{{ $provider_details->picture }}" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('full_address') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="full_address" placeholder="{{ tr('full_address') }}" value="{{ old('full_address') ?? $provider_details->full_address }}" />
                                </div>
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">

                                <div class="col-sm-9">
                                    
                                    <img src="{{ $provider_details->picture }}" id="preview" class="preview">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <button type="reset" class="btn btn-danger">{{tr('reset')}}</button>
                            
                            <div class="form-group row float-right">
                                <input type="submit" name="submit" value="{{ tr('save') }}" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>