@extends('layouts.admin') 

@section('title', tr('bookings'))

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>
    
    <li class="breadcrumb-item"><i class="fa fa-share"></i><a href="{{ route('admin.bookings.index') }}">&nbsp{{tr('bookings')}}</a></li>

           
@endsection 

@section('content')

<section class="content">

    @include('notification.notify')

    <div class="row">

        <div class="col-lg-12 grid-margin stretch-card">
            
            <div class="box box-primary">

                <div class="box-header bg-card-header ">

                    <h4 class="">{{tr('bookings')}}</h4>

                </div>

                <div class="box-body">

                    <div class="table-responsive">
                        
                        <table id="order-listing" class="table">
                            
                            <thead>
                                <tr>
                                    <th>{{tr('s_no')}}</th>
                                    <th>{{tr('user')}}</th>
                                    <th>{{tr('provider')}}</th>
                                    <th>{{tr('space')}}</th>
                                    <th>{{tr('checkin_out') }}</th>
                                    <th>{{tr('status')}}</th>
                                    <th>{{tr('action')}}</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @if(count($bookings)>0)
                             
                                    @foreach($bookings as $i => $booking_details)

                                        <tr>
                                            <td>{{$i+1}}</td>

                                            <td>
                                                <a href="{{ route('admin.users.view',['user_id' => $booking_details->users ? $booking_details->users->id : 0 ])}}"> {{ $booking_details->users ? $booking_details->users->name :tr('user_not_avail')}}</a>
                                               
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.providers.view',['provider_id' => $booking_details->providers ? $booking_details->providers->id : 0])}}">{{ $booking_details->providers ?$booking_details->providers->name :  tr('provider_not_avail')}}</a>
                                            </td>

                                            <td> 
                                                <a href="{{ route('admin.spaces.view',['space_id' => $booking_details->spaces ? $booking_details->spaces->id : 0])}}"> {{$booking_details->spaces ? $booking_details->spaces->name : tr('space_not_avail') }} </a>
                                            </td>

                                            <td>
                                                {{common_date($booking_details->checkin, Auth::guard('admin')->user()->timezone, 'd M Y')}}
                                                -
                                                {{common_date($booking_details->checkout, Auth::guard('admin')->user()->timezone, 'd M Y')}}

                                            </td>
                                          
                                            <td>                                    
                                                <span class='badge {{ booking_status_color($booking_details->status) }}'>{{ booking_status($booking_details->status )}}</span>
                                            </td>
                                           
                                            <td>   
                                                <a class="btn btn-primary" href="{{ route('admin.bookings.view', ['booking_id' => $booking_details->id])}}"><i class="fa fa-eye"></i>{{tr('view')}}</a>
                                                
                                            </td>

                                        </tr>

                                    @endforeach

                                @else
                                    <tr><td>{{tr('no_bookings_found')}}</td></tr>
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