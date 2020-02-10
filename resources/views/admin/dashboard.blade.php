@extends('layouts.admin') 

@section('content') 

@section('breadcrumb')

<li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

@endsection

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$data->users}}</h3>

                    <p>{{tr('total_users')}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('admin.users.index')}}" class="small-box-footer">{{tr('more_info')}}<i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$data->providers}}</h3>

                    <p>{{tr('total_providers')}}</p>
                </div>
                <div class="icon">
                    <i class="icon ion-ios-home"></i>
                </div>
                <a href="{{route('admin.providers.index')}}" class="small-box-footer">{{tr('more_info')}}<i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$data->bookings}}</h3>

                    <p>{{tr('total_bookings')}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{route('admin.bookings.index')}}" class="small-box-footer">{{tr('more_info')}} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$data->revenue}}</h3>

                    <p>{{tr('total_revenue')}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{route('admin.bookings.payment')}}" class="small-box-footer">{{tr('more_info')}}<i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <div class="row">

        <div class="col-md-6">
            <!-- USERS LIST -->
            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase">{{ tr('recent_users') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="users-list clearfix">
                        @if(count($recent_users) > 0) 

                            @foreach($recent_users as $user_details)

                                <li>
                                    <img style="width:60px;height:60px" src="@if($user_details->picture) {{ $user_details->picture }} @else {{ asset('placeholder.jpg') }} @endif" alt="User Image">
                                    <a class="users-list-name" href="{{ route('admin.users.view' , ['user_id' => $user_details->id] ) }}" target="_blank">{{ $user_details->name }}</a>
                                    <span class="users-list-date">
                                                {{ $user_details->created_at->diffForHumans() }}</span>
                                </li>

                            @endforeach
                            </ul>
                            <div class="box-footer text-center">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-info uppercase">{{ tr('view_all') }}</a>
                            </div>  
                        @else
                            <p>{{tr('user_not_found')}}</p>
                        @endif

                    
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->

                <!-- /.box-footer -->
            </div>

            <!--/.box -->
        </div>

        <div class="col-md-6">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title text-uppercase">{{ tr('recent_providers') }}</h3>

                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>

                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    @if(count($recent_providers) > 0)
                    <ul class="products-list product-list-in-box">
                        @foreach($recent_providers as $v => $provider_details) 
                            @if($v< 5) 
                                <li class="item">
                                    <div class="product-img">
                                        <img src="{{ $provider_details->picture ?: asset('placeholder.jpg') }}" alt="Product Image">
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('admin.providers.view' , ['provider_id' => $provider_details->id] ) }}" class="product-title">{{ substr($provider_details->title, 0,50) }}
                                        <span class="label label-primary ">{{ $provider_details->name }}</span>
                                                    </a>
                                        <span class="product-description">
                                        {{ substr($provider_details->description , 0 ,30) }}...</span>
                                        <span class="users-list-date pull-right">
                                        {{ $provider_details->created_at->diffForHumans() }}</span>
                                    </div>
                                </li>

                            @endif 

                        @endforeach
                            <!-- /.item -->
                    </ul>
                        <div class="box-footer text-center">
                            <a href="{{ route('admin.providers.index') }}" class="btn btn-info uppercase">{{ tr('view_all') }}</a>
                        </div>
                    @else
                    <p>{{tr('provider_not_found')}}</p>
                    @endif
                </div>

            </div>
        </div>

    </div>

</section>

@endsection