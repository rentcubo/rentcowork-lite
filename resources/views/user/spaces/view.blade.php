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
                                <img src="{{ $space_details->picture }}" class="picture-size">
                            </div>

                            <div class="col-lg-8">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>{{ $space_details->name }}</h3>
                                    </div>

                                    <a href="{{ route('spaces.index') }}"><button class="btn btn-primary">{{ tr('view_spaces') }}</button></a>
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
                                                {{ tr('space_type') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->space_type }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('tagline') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->tagline ?? '-'}}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('description') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->description ?? '-' }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('full_address') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->full_address ?? '-'}}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('instructions') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->instructions ?? '-' }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('per_hour') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ formatted_amount($space_details->per_hour) }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('created_at') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($space_details->created_at) }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('updated_at') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($space_details->updated_at) }}
                                            </span>
                                        </p>
                                        <br>
                                         <div class="d-flex justify-content-between">
                                            <a href="#"  data-toggle="modal" data-target="#bookingModal">
                                                <button class="btn btn-success">{{ tr('book_now') }}</button>
                                            </a>

                                        </div>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ tr('booking') }}</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                
                <div class="modal-body">
                    
                    <form class="form-sample" action="{{ route('bookings.save', ['space_details_id' => $space_details->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="timezone" class="form-control " id="timezone"  value="" />

                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ tr('checkin') }} *</label>
                                    <div class="col-sm-8">
                                        <div class="input-group date" id="checkin" data-target-input="nearest">
                                            <div class="input-group" data-target="#checkin" data-toggle="datetimepicker">
                                                <input type="datetime" name="check_in" class="form-control datetimepicker-input" data-target="#checkin" autocomplete="off" required />
                                                <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                                            </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ tr('checkout') }} *</label>
                                    <div class="col-sm-8">
                                        <div class="input-group date" id="checkout" data-target-input="nearest">
                                            <div class="input-group" data-target="#checkout" data-toggle="datetimepicker">
                                                <input type="datetime" name="check_out" class="form-control datetimepicker-input" data-target="#checkout" autocomplete="off" required />
                                                <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                                            </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ tr('description') }} *</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="description" placeholder="{{ tr('description') }}" value="{{ old('description') }}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    
                    <div class="modal-footer">
                      <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ tr('cancel') }}</button>

                       <button type="submit" class="btn btn-primary">
                           {{ tr('book_now') }}
                       </button>

                    </div>
                </form>
            </div>
       
        </div>
   
    </div>

    <script type="text/javascript">

        timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        document.getElementById('timezone').value = timezone;

    </script>
@endsection