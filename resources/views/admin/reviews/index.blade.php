@extends('layouts.admin') 

@section('title', tr('reviews'))

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item" aria-current="page"><i class="fa fa-smile-o"></i>
    	<a href="javascript:void(0)">&nbsp{{tr('reviews')}}</a>
    </li>

    @if($sub_page == 'users-review')
    <li class="breadcrumb-item active"><i class="fa fa-smile-o"></i>&nbsp{{tr('user_reviews')}}</li>
    @else
    <li class="breadcrumb-item active"><i class="fa fa-smile-o"></i>&nbsp{{tr('provider_reviews')}}</li>
    @endif
         
@endsection 

@section('styles')

<link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/star-rating-svg.css')}}">

@endsection

@section('content') 
<section class="content">
    @include('notification.notify')
    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">
        
            <div class="box box-primary">

                <div class="box-header bg-card-header ">
                
                @if($sub_page == 'users-review')
                    <h4 class="">{{ tr('user_reviews') }}</h4>
                @else
                    <h4 class="">{{ tr('provider_reviews') }}</h4>
                @endif
                
                </div>

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="order-listing" class="table">

                            <thead>
                                <th>{{tr('s_no')}}</th>
                                <th>{{tr('user')}}</th>
                                <th>{{tr('provider')}}</th>
                                <th>{{ tr('date') }}</th>
                                <th>{{tr('rating')}}</th>
                                <th>{{ tr('comment') }}</th>
                            </thead>

                            <tbody>
                                @if(count($reviews)>0)
                             
                                    @foreach($reviews as $i => $review_details)

                                        <tr>
                                            <td>{{$i+1}}</td>
                                           
                                            <td>
                                                <a href="{{ route('admin.users.view', ['user_id' => $review_details->user_id] ) }}">
                                                    
                                                   {{$review_details->users ? $review_details->users->name : tr('user_not_avail')}}
                                                </a>
                                            </td>

                                            <td>
                                                <a href="{{route('admin.providers.view', ['provider_id' => $review_details->provider_id ?? '0' ])}}">
                                                    {{$review_details->providers ? $review_details->providers->name : tr('provider_not_avail')}}
                                                </a>
                                            </td>
                                            
                                            <td>{{ common_date($review_details->created_at) }}</td>

                                            <td>
                                                <div class="my-rating-{{$i}}"></div>
                                            </td> 
                                            
                                            <td>{{ substr($review_details->review, 0, 50) }}...</td>
              
                                        </tr>

                                    @endforeach
                                @else
                                    <tr><td>{{tr('no_reviews_found')}}</td></tr>
                                @endif                                     
                            </tbody>
                        
                        </table>

                        <div class="pull-right">{{ $reviews->links() }}</div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>


@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('admin-assets/js/jquery.star-rating-svg.min.js')}}"> </script>

    <script>
        <?php foreach ($reviews as $i => $review_details) { ?>
            $(".my-rating-{{$i}}").starRating({
                starSize: 25,
                initialRating: "{{$review_details->ratings}}",
                readOnly: true,
                // strokeWidth: 10,
                callback: function(currentRating, $el){
                    // make a server call here
                }
            });
        <?php } ?>
    </script>

@endsection

