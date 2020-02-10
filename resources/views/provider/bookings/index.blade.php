@extends('layouts.provider')

@section('content')
    
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                
                <div class="card">
                <div class="card-body">
                    @include('notifications.notification')
                    <h4 class="card-title">{{ tr('bookings') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ tr('sno') }}</th>
                                    <th>{{ tr('user_name') }}</th>
                                    <th>{{ tr('space_name') }}</th>
                                    <th>{{ tr('checkin') }}</th>
                                    <th>{{ tr('checkout') }}</th>
                                    <th>{{ tr('status') }}</th>
                                    <th>{{ tr('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($bookings)>0)
                                    @foreach($bookings as $i => $booking_details)
                                        <tr>
                                            <td class="py-1">
                                              {{ $i+1 }}
                                            </td>

                                            <td>
                                                {{ $booking_details->user_name }}
                                            </td>

                                            <td>
                                                <a href="{{ route('provider.spaces.view', ['space_details_id' => $booking_details->space_id]) }}">{{ $booking_details->space_name }}</a>
                                            </td>

                                            <td>
                                               {{ common_date($booking_details->checkin) ?? tr('not_available') }}
                                            </td>

                                            <td>
                                               {{ common_date($booking_details->checkout) ?? tr('not_available') }}
                                            </td>

                                            <td>
                                                <span class='badge {{ booking_status_color($booking_details->status) }}'>{{ booking_status($booking_details->status) }}</span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">{{ tr('action') }}
                                                        <span class="caret"></span>
                                                    </button>
                                                  
                                                    <ul class="dropdown-menu">
                                                        <li> <a href="{{ route('provider.bookings.view', ['booking_details_id' => $booking_details->id]) }}" class="dropdown-item">{{ tr('view') }}</a></li>
                                                                    
                                                       @if($booking_details->status == BOOKING_INITIATE | $booking_details->status == BOOKING_ONPROGRESS | $booking_details->status == BOOKING_WAITING_FOR_PAYMENT | $booking_details->status == BOOKING_PAYMENT_DONE )
                  
                                                            <a href="{{ route('provider.bookings.cancel', ['booking_details_id' => $booking_details->id]) }}" class="dropdown-item">{{ tr('cancel') }}</a>

                                                        @endif  
                                                  </ul>
                                                </div> 
                                               
                                            </td>
                                        </tr>

                                    @endforeach    
                                @else

                                    <td colspan="8"><div><h4>{{ tr('no_booking_found') }}</h4></div></td>
                                @endif

                            </tbody>
                        </table>

                        @if(count($bookings)>0)

                            <div class="pull-right">{{ $bookings->links() }}</div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->

@endsection