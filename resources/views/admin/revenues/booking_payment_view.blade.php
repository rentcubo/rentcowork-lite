@extends('layouts.admin') 

@section('title', tr('bookings'))

@section('breadcrumb')

    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item"><i class="fa fa-money"></i><a href="{{route('admin.bookings.payment')}}">&nbsp{{tr('revenues')}}</a></li>
  
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fa fa-ticket"></i><span>&nbsp{{ tr('bookings') }}</span>
    </li>
           
@endsection 

@section('content')

<section class="content">

    @include('notification.notify')

    <div class="row">

        <div class="col-lg-12 grid-margin stretch-card">
            
            <div class="box box-primary">

                <div class="box-header bg-card-header ">

                    <h4 class="">{{tr('booking_payment')}}</h4>

                </div>

                <div class="box-body">
                        
                        <h4 class="card-title">{{tr('payment_details')}}</h4>

                        <div class="row">
                            
                            <div class="col-md-6 col-sm-6 d-flex justify-content-center border-right">      
                                <table class="table mb-0">
                                                                    
                                    <tbody>

                                        <tr>
                                          <td class="pl-0">{{ tr('username') }}</td>
                                          <td class="pr-0 text-right"><a href="{{ route('admin.users.view')}}">{{  $booking_payment_details->users->name ?? tr('user_not_avail')}}</a></td>
                                        </tr>

                                        <tr>
                                          <td class="pl-0">{{ tr('space') }}</td>
                                          <td class="pr-0 text-right"><a href="{{ route('admin.spaces.view')}}">{{  $booking_payment_details->spaces->name ?? tr('space_not_avail')}}</a></td>
                                        </tr>

                                        <tr>
                                          <td class="pl-0">{{ tr('provider') }}</td>
                                          <td class="pr-0 text-right"><a href="{{ route('admin.providers.view')}}">{{ $booking_payment_details->providers->name ?? tr('provider_not_avail')}}</a></td>
                                        </tr>
                                        <tr>
                                          <td class="pl-0">{{ tr('payment_id') }}</td>
                                          <td class="pr-0 text-right"><div class="badge badge-primary">#{{ $booking_payment_details->payment_id}}</div></td>
                                        </tr>

                                        <tr>
                                          <td class="pl-0">{{ tr('payment_mode') }}</td>
                                          <td class="pr-0 text-right"><div class="badge badge-info">{{ $booking_payment_details->payment_mode}}</div></td>
                                        </tr>

                                        <tr>
                                            <td class="pl-0">{{ tr('total_time') }}</td>
                                            <td class="pr-0 text-right">
                                                <div class="badge badge-danger">
                                                    {{ time_show($booking_payment_details->total_time) }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pl-0">{{tr('tax_price')}}</td>
                                            <td class="pr-0 text-right">
                                                <div class="badge badge-pill badge-primary">
                                                    {{ formatted_amount($booking_payment_details->tax_price) }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pl-0">{{tr('total')}}</td>
                                            <td class="pr-0 text-right">
                                                <div class="badge badge-pill badge-primary">
                                                    {{formatted_amount($booking_payment_details->total)}}
                                                </div>
                                            </td>
                                        </tr> 

                                        <tr>
                                            <td class="pl-0">{{tr('paid_amount')}}</td>
                                            <td class="pr-0 text-right">
                                                <div class="badge badge-pill badge-primary">
                                                    {{formatted_amount($booking_payment_details->paid_amount)}}
                                                </div>
                                            </td>
                                        </tr>

                                       
                                    </tbody>

                                </table>

                            </div>
                            
                            <div class="col-md-6 col-sm-6 d-flex justify-content-center border-right">  
                                <table class="table mb-0">
                                                                    
                                    <tbody>
                                        <tr>
                                            <td class="pl-0">{{tr('sub_total')}}</td>
                                            <td class="pr-0 text-right">
                                                <div class="badge badge-pill badge-primary">
                                                    {{ formatted_amount($booking_payment_details->sub_total)}}
                                                </div>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td class="pl-0">{{tr('paid_date')}}</td>

                                            <td class="pr-0 text-right">
                                                <div class="badge badge-pill badge-primary">
                                                    {{common_date($booking_payment_details->paid_date)}}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pl-0">{{tr('admin_amount')}}</td>
                                            <td class="pr-0 text-right">
                                                <div class="badge badge-pill badge-primary">
                                                    {{formatted_amount($booking_payment_details->admin_amount)}}
                                                </div>
                                            </td>
                                        </tr> 

                                        <tr>
                                            <td class="pl-0">{{tr('provider_amount')}}</td>
                                            <td class="pr-0 text-right">
                                                <div class="badge badge-pill badge-primary">
                                                    {{formatted_amount($booking_payment_details->provider_amount)}}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                
                                </table>
                            </div>

                        </div>

                    </div>

            </div>

        </div>
    </div>
    
</section>

@endsection