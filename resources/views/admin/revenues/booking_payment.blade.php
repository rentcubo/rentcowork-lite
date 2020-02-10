@extends('layouts.admin') 

@section('title', tr('bookings_payments'))

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item"><i class="fa fa-money"></i><a href="{{route('admin.bookings.payment')}}">&nbsp{{tr('revenues')}}</a></li>
           
@endsection 

@section('content') 
<section class="content">

    @include('notification.notify')
    
    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">
        
            <div class="box box-primary">

                <div class="box-header bg-card-header ">

                    <h4 class="">{{tr('bookings_payments')}}</h4>

                </div>

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="order-listing" class="table">
                            
                            <thead>

                                <tr>
                                    <th>{{tr('s_no')}}</th>
                                    <th>{{tr('booking_id')}}</th>
                                    <th>{{tr('user')}}</th>
                                    <th>{{tr('provider')}}</th>
                                    <th>{{tr('space')}}</th>
                                    <th>{{tr('pay_via')}}</th>
                                    <th>{{tr('total')}}</th>
                                    <th>{{tr('status')}}</th>
                                    <th>{{tr('action')}}</th>
                                </tr>

                            </thead>
                            
                            <tbody>

                                @if(count($booking_payments) > 0 )
                                
                                    @foreach($booking_payments as $i => $booking_payment_details)

                                        <tr>
                                            <td>{{ $i+1 }}</td>

                                            <td>
                                                <a href="{{route('admin.bookings.view', ['booking_id' => $booking_payment_details->booking_id])}}">
                                                    #{{ $booking_payment_details->bookings ? $booking_payment_details->bookings->unique_id:tr('booking_not_avail')}}
                                                </a> 
                                            </td>
                                                                                    
                                            <td> 
                                                <a href="{{ route('admin.users.view',['user_id' => $booking_payment_details->user_id])}}">{{ $booking_payment_details->users ? $booking_payment_details->users->name : tr('user_not_avail')}}</a>
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.providers.view',['provider_id' => $booking_payment_details->provider_id])}}">{{ $booking_payment_details->providers ? $booking_payment_details->providers->name : tr('provider_not_avail') }}</a>
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.spaces.view',['space_id' => $booking_payment_details->space_id])}}">{{ $booking_payment_details->spaces ? $booking_payment_details->spaces->name : tr('space_not_avail') }}</a>
                                            </td>
                                            
                                            <td> 
                                                {{ $booking_payment_details->payment_mode }}
                                            </td>

                                            <td>
                                                {{formatted_amount($booking_payment_details->total)}}                   
                                            </td>

                                            <td>
                                                @if($booking_payment_details->status == PAYMENT_PAID)

                                                    <div class="badge badge-success badge-fw">{{ tr('paid')}}</div>
                                              
                                                @elseif($booking_payment_details->status == PAYMENT_NOT_PAID)

                                                     <div class="badge badge-danger badge-fw">{{ tr('not_paid')}}</div>
                                              
                                                @else

                                                     <div class="badge badge-danger badge-fw">{{ tr('cancelled')}}</div>
                                              
                                                @endif
                                            </td>

                                            <td>
                                                <a class="btn btn-primary" href="{{ route('admin.bookings.payments.view', ['payment_id' => $booking_payment_details->id] )}}">
                                                    {{tr('view')}}
                                                </a> 
                                            </td>

                                        </tr>

                                    @endforeach

                                @else

                                    <tr>
                                        <td>{{ tr('no_results_found') }}</td>
                                    </tr>

                                @endif

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
		

    
@endsection