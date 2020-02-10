<div class="row">

    <div class="col-12 grid-margin">

        <div class="card card-edit">
            <div class="card-body">
                <h4 class="card-title">
                    @if($space_details->id) 
                        {{ tr('edit_space') }} 
                    @else
                        {{ tr('add_space') }}
                    @endif

                    <a href="{{ route('provider.spaces.index') }}"><button class="btn btn-primary float-right">{{ tr('view_spaces') }}</button></a>
                </h4>
                <br>
                @include('notifications.notification')

                <form class="form-sample" action="{{ route('provider.spaces.save') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">    
                        <input type="hidden" name="space_details_id" class="form-control" @if($space_details->id) value="{{ $space_details->id }}" @endif >
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('name') }} *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" placeholder="{{ tr('name') }}" @if($space_details) value="{{ old('name') ?? $space_details->name  }}" @else value="{{ old('name') }}" @endif required />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('tagline') }} *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tagline" placeholder="{{ tr('tagline') }}"  @if($space_details) value="{{ old('tagline') ?? $space_details->tagline  }}" @else value="{{ old('tagline') }}" @endif required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('space_type') }} *</label>
                                <div class="col-sm-9">

                                    <select class="form-control" name="space_type" required>
                                        <option value="">{{tr('space_type')}}</option>

                                        @foreach($space_types as $space_type_details)

                                           <option value="{{ $space_type_details }}" @if($space_details) {{ $space_details->space_type ===  $space_type_details? 'selected' : $space_type_details   }}@endif>{{ $space_type_details }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('description') }} *</label>
                                <div class="col-sm-9">
                                    <textarea  class="form-control" id="description" name="description" placeholder="{{ tr('description_placeholder')}}" required="required">@if($space_details){{ old('description') ?? $space_details->description}}@else {{ old('description') }} @endif</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('per_hour') }} *</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="per_hour" step="0.01"  placeholder="{{ tr('per_hour') }}" @if($space_details) value="{{ old('per_hour') ?? $space_details->per_hour  }}" @else value="{{ old('per_hour') }}" @endif  required />
                                </div>
                            </div>
                        </div>

                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('full_address') }} *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="full_address" placeholder="{{ tr('full_address') }}" @if($space_details) value="{{ old('full_address') ?? $space_details->full_address  }}" @else value="{{ old('full_address') }}" @endif required />
                                </div>
                            </div>
                        </div>
                
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">{{ tr('picture') }}</label>

                                <div class="col-sm-9">

                                    <input type="file" name="picture"  onchange="readURL(this);" class="form-control-file" value="" accept="image/*">
                                </div>
                            </div>
                        </div>

                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ tr('instructions') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="instructions" placeholder="{{ tr('instructions') }}" @if($space_details) value="{{ old('instructions') ?? $space_details->instructions  }}" @else value="{{ old('instructions') }}" @endif />
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group row">

                                <div class="col-sm-9">
                                    
                                    <img src="{{ $space_details->picture ?? asset('space-placeholder.jpg') }}" id="preview" class="preview">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <button type="reset" class="btn btn-danger">{{tr('reset')}}</button>
                            
                            <div class="form-group row  float-right">
                                <input type="submit" name="submit" value="{{ tr('save') }}" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>