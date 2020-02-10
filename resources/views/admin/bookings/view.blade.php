@extends('layouts.admin') 

@section('title', tr('view_booking'))

@section('breadcrumb')

	<li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item"><i class="fa fa-share"></i> &nbsp<a href="{{route('admin.bookings.index')}}">&nbsp{{tr('bookings')}}</a></li>

    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-ticket"></i>
        <span>&nbsp{{tr('view_bookings')}}</span>
    </li>
           
@endsection  

@section('content')
<section class="content">

	@include('notification.notify')
	
	<div class="row ">
		
		<div class="col-md-6 grid-margin stretch-card">
          	
          	<div class="box box-primary">
          		
          		<div class="box-body">

          		  	<div class="d-flex justify-content-between align-items-center">
	          		    <div class="d-inline-block">
	          		      	<div class="d-lg-flex">
		          		        <h5 class="mb-2 text-uppercase">
		          		        	<b>
		          		        		{{ tr('booking_id')}}: 
		          		        		<span class="text-success">#{{$booking_details->unique_id}}</span>
		          		        	</b>
		          		        </h5>
	          		      	</div>

	          		        <p class="">

          		          		<i class="mdi mdi-clock text-muted"></i>

	          		        	{{common_date($booking_details->checkin, Auth::guard('admin')->user()->timezone, 'd M Y H:i')}}

	          		        	-
	          		        	{{common_date($booking_details->checkout, Auth::guard('admin')->user()->timezone, 'd M Y H:i')}}

	          		        </p>
	          		    </div>
	                    	
	          		    <div class="d-inline-block">
	          		      	<div class="px-3 px-md-4 py-2 rounded text-uppercase text-success">
		          		        <b>{!! booking_status( $booking_details->status) !!}</b>

		          		        <h4 class="card-title">{{ tr('user') }}</h4>
	 		                	<a href="{{ route('admin.users.view', ['user_id' => $booking_details->user_id ]) }}">{{ $booking_details->users ? $booking_details->users->name : tr('user_not_avail') }}</a>

	 		                	<h4 class="card-title">{{ tr('provider') }}</h4>
	 		                	<a href="{{ route('admin.providers.view', ['provider_id' => $booking_details->provider_id ]) }}">{{ $booking_details->providers ? $booking_details->providers->name: tr('provider_not_avail') }}</a>

	 		                	<h4 class="card-title">{{ tr('space') }}</h4>
	 		                	<a href="{{ route('admin.spaces.view', ['space_id' => $booking_details->space_id ]) }}">{{ $booking_details->spaces ? $booking_details->spaces->name : tr('space_not_avail') }}</a>

	          		      	</div>
	          		    </div>

          		  	</div>

          		</div>

          	</div>

        </div>

        <div class="col-md-6 grid-margin stretch-card">
			<div class="box box-primary">
				<div class="box-body">
					<div class="preview-list">

						<div class="preview-item border-bottom px-0">
							
							<div class="preview-item-content d-flex flex-grow">
								<div class="flex-grow">
									<h4 class="preview-subject">{{tr('total')}}
										<span class="float-right small">
											<span class="text-muted pr-3 pull-right">{{ formatted_amount($booking_details->total) }}</span>
										</span>
									</h4>
								</div>
							</div>
						</div>

						<div class="preview-item border-bottom px-0">
							
							<div class="preview-item-content d-flex flex-grow">
								<div class="flex-grow">
									<h4 class="preview-subject">{{tr('payment_mode')}}
										<span class="float-right small">
											<span class="text-muted pr-3 pull-right">{{ $booking_details->payment_mode }}</span>
										</span>
									</h4>
								</div>
							</div>
						</div>

						<div class="preview-item border-bottom px-0">
							
							<div class="preview-item-content d-flex flex-grow">
								<div class="flex-grow">
									<h4 class="preview-subject">{{tr('updated_at')}}
										<span class="float-right small">
											<span class="text-muted pr-3 pull-right">{{ common_date($booking_details->updated_at) }}</span>
										</span>
									</h4>
								</div>
							</div>
						</div>	

						<div class="preview-item border-bottom px-0">
							
							<div class="preview-item-content d-flex flex-grow">
								<div class="flex-grow">
									<h4 class="preview-subject">{{tr('created_at')}}
										<span class="float-right small">
											<span class="text-muted pr-3 pull-right">{{ common_date($booking_details->created_at) }}</span>
										</span>
									</h4>
								</div>
							</div>
						</div>

						<div class="preview-item border-bottom px-0">	
							<div class="preview-item-content d-flex flex-grow">
								<div class="flex-grow">
									<h4 class="preview-subject">{{tr('description')}}
										<span class="float-right small">
											<span class="text-muted pr-3 pull-right">{{ substr($booking_details->description,0,50)?? "-" }}</span>
										</span>
									</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

 	<!-- booking payments details begins -->

 	@if($booking_payment_details) 
		
		<div class="row">
			
			<div class="col-md-12 grid-margin stretch-card">
			
			  	<div class="box box-primary">
			
				    <div class="box-body">
				      	
				      	<h4 class="card-title">{{tr('payment_details')}}</h4>

				      	<div class="row">
			                
			                <div class="col-md-6 col-sm-6 d-flex justify-content-center border-right">  	
					        	<table class="table mb-0">
						          						          	
						          	<tbody>
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
	@endif

	<!-- booking payments details begins -->
</section>

@endsection