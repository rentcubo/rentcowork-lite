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
                                <img src="{{ $booking_details->picture }}" class="picture-size">
                            </div>

                            <div class="col-lg-8">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>{{ $booking_details->space_name }}</h3>
                                    </div>

                                     <a href="{{ route('bookings.index') }}"><button class="btn btn-primary">{{ tr('view_bookings') }}</button></a>

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
                                                {{ tr('booking_id') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                #{{ $booking_details->unique_id }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('description') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $booking_details->description }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('checkin') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($booking_details->checkin) ?? tr('not_available') }}
                                            </span>
                                        </p>

                                         <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('checkout') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($booking_details->checkout) ?? tr('not_available') }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('total_time') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ time_show($booking_details->total_time) ?? tr('not_available')}}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('per_hour') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ formatted_amount($booking_details->per_hour) }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('total') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ formatted_amount($booking_details->total) }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('payment_mode') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $booking_details->payment_mode ?? tr('not_available')}}
                                            </span>
                                        </p>

                                         <p class="clearfix">
                                            <span class="float-left">
                                               {{ tr('status') }}
                                            </span>
                                            
                                            <span class="float-right"><span class='badge {{ booking_status_color($booking_details->status) }}'>{{ booking_status($booking_details->status) }}</span></span>
   
                                        </p>

                                        @if($booking_details->status!=BOOKING_INITIATE)
                                            <p class="clearfix">
                                                <span class="float-left">
                                                   {{ tr('total_amount_with_tax') }}
                                                </span>
                                                
                                                <span class="float-right text-muted">
                                                    {{ formatted_amount($booking_details->total_amount) ?? tr('not_available')}}
                                                </span>
       
                                            </p>

                                            <p class="clearfix">
                                                <span class="float-left">
                                                   {{ tr('paid_amount') }}
                                                </span>
                                                
                                                <span class="float-right text-muted">
                                                    {{ formatted_amount($booking_details->paid_amount) ?? tr('not_available')}}
                                                </span>
       
                                            </p>

                                            <p class="clearfix">
                                                <span class="float-left">
                                                   {{ tr('paid_date') }}
                                                </span>
                                                
                                                <span class="float-right text-muted">
                                                    {{ common_date($booking_details->paid_date) ?? tr('not_available')}}
                                                </span>
       
                                            </p>
                                        @endif

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('created_at') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($booking_details->created_at) ?? tr('not_available') }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('updated_at') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($booking_details->updated_at) ?? tr('not_available') }}
                                            </span>
                                        </p>

                                        @if($booking_details->status==BOOKING_CHECKOUT)

                                            <p class="clearfix">
                                                <span class="float-left">
                                                    {{ tr('review') }}
                                                </span>

                                                <span class="float-right text-muted">
                                                    <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#bookingModal">{{ tr('review_me') }}</button>

                                                    <div class="modal fade" id="bookingModal" role="dialog">
                                                        <div class="modal-dialog">
                                                      
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="h3 text-success" >{{ tr('bookings_review') }}</h3>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form action="{{ route('bookings.review', ['booking_details_id'=>$booking_details->id]) }}" method="post">       
                                                                        @csrf

                                                                        <input type="hidden" name="booking_id" class="form-control" value="{{ $booking_details->id }}" >

                                                                        <div class="form-group">
                                                                            <label>{{ tr('rating') }} *</label>
                                                                           <select id="example-fontawesome" name="rating" autocomplete="off">
                                                                                <option value="1">1</option>
                                                                                <option value="2">2</option>
                                                                                <option value="3">3</option>
                                                                                <option value="4">4</option>
                                                                                <option value="5">5</option>
                                                                            </select>
                                                                     
                                                                        <div class="form-group">
                                                                            <label>{{ tr('review') }} *</label>
                                                                            <input type="text" name="review" class="form-control "  placeholder="{{ tr('review') }}">

                                                                        </div>
                                
                                                                    </div>
                                                                
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-info" data-dismiss="modal">{{ tr('close') }}</button>
                                                                         <input type="submit" name="submit" class="btn btn-success" value="{{ tr('submit') }}">
                                                       
                                                                   
                                                                    </div>
                                                                 </form>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </span>
                                            </p>
                                        @endif

                                        @if($booking_details->status == BOOKING_COMPLETED | $booking_details->status == BOOKING_REVIEW_DONE)
                                            <p class="clearfix">
                                                <span class="float-left">
                                                    {{ tr('review') }}
                                                </span>

                                                <span class="float-right text-muted">
                                                    @if($booking_details->users_review)
                                                        {{ $booking_details->users_review }}
                                                    @endif
                                                </span>
                                            </p>

                                             <p class="clearfix">
                                                <span class="float-left">
                                                    {{ tr('rating') }}
                                                </span>

                                                <span class="float-right">
                                                   <label class="booking-rating"></label>
                                                </span>
                                            </p>
                                        @endif
                                        <br>
                                         <div class="d-flex justify-content-between float-right">
        

                                            @if($booking_details->status == BOOKING_INITIATE | $booking_details->status == BOOKING_ONPROGRESS | $booking_details->status == BOOKING_WAITING_FOR_PAYMENT)
                                                
                                                <a href="{{ route('bookings.cancel', ['booking_details_id' => $booking_details->id]) }}" class="btn btn-danger mr-1">{{ tr('cancel') }}</a>

                                                <a href="{{ route('bookings.payment',['booking_details_id'=>$booking_details->id]) }}" class="btn btn-success mr-1" onclick="return confirm('{{ tr('payment_confirm').$booking_details->space_name }} ?')">{{ tr('pay_now') }} </a>

                                            @endif

                                             @if($booking_details->status == BOOKING_PAYMENT_DONE )
                                                
                                                <a href="{{ route('bookings.cancel', ['booking_details_id' => $booking_details->id]) }}" class="btn btn-danger mr-1">{{ tr('cancel') }}</a>

                                                <a href="{{ route('bookings.checkin',['booking_details_id'=>$booking_details->id]) }}" class="btn btn-success mr-1" onclick="return confirm('{{ tr('checkin_confirm').$booking_details->space_name }} ?')">{{ tr('checkin') }} </a>

                                            @endif
                                            
                                            @if($booking_details->status == BOOKING_CHECKIN )
                                                              
                                                <a href="{{ route('bookings.checkout',['booking_details_id'=>$booking_details->id]) }}" class="btn btn-primary mr-1" onclick="return confirm('{{ tr('checkout_confirm').$booking_details->space_name }} ?')">{{ tr('checkout') }} </a></li>
                                            
                                            @endif

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
    <script type="text/javascript" src="{{asset('user-assets/js/jquery.star-rating-svg.min.js')}}"> </script>

    <script type="text/javascript">

        $(".booking-rating").starRating({
            starSize: 20,
            initialRating: "{{ $booking_details->rating }}",
            readOnly: true,
            callback: function(currentRating, $el){
                // make a server call here
            }
        });
    </script>
@endsection