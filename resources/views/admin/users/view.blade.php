@extends('layouts.admin') 

@section('title', tr('view_user')) 


@section('breadcrumb')
<li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>
    
<li class="breadcrumb-item"><i class="fa fa-user"></i><a href="{{ route('admin.users.index')}}">&nbsp{{tr('users')}}</a></li>

<li class="breadcrumb-item active" aria-current="page"><i class="fa fa-user-plus"></i><span>&nbsp{{ tr('view_users') }}</span></li> 

@endsection 

@section('content')

<section class="content">

    @include('notification.notify')

    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">
        
            <div class="box box-primary">

                <div class="box-header bg-card-header">
                    <h4>{{tr('user_details')}}</h4>
                </div>

                <div class="box-body">

                    <div class="row">

                        <div class="col-md-6">

                            <!-- Card group -->
                            <div class="card-group">

                                <!-- Card -->
                                <div class="card mb-4">

                                    <!-- Card image -->
                                    <div class="view overlay">

                                        <img class="image" src="{{$user_details->picture ?? asset('placeholder.jpg')}}">
                                        <a href="#!">
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>

                                    <div class="card-body">

                                        <hr>
                                        <a class="btn btn-primary button-width" href="{{ route('admin.users.edit', ['user_id' => $user_details->id])}}">{{tr('edit')}}</a>

                                                        <a class="btn btn-danger button-width" href="{{route('admin.users.delete', ['user_id' => $user_details->id])}}" onclick="return confirm(&quot;{{tr('user_delete_confirmation' , $user_details->name)}}&quot;);">{{tr('delete')}}</a> 
                                                        @if($user_details->status == USER_APPROVED)

                                                            <a class="btn btn-danger button-width" href="{{ route('admin.users.status', ['user_id' => $user_details->id]) }}" onclick="return confirm(&quot;{{$user_details->first_name}} - {{tr('user_decline_confirmation')}}&quot;);">
                                                                {{ tr('decline') }} 
                                                            </a> 
                                                        @else

                                                            <a class="btn btn-success button-width" href="{{ route('admin.users.status', ['user_id' => $user_details->id]) }}">
                                                                {{ tr('approve') }} 
                                                            </a> 
                                                        @endif
                                        <div class="row">
                                            @if($user_details->description)
                                            <h5 class="col-md-12">{{tr('description')}}</h5>

                                            <p class="col-md-12 text-muted">{{$user_details->description}}</p>
                                            @endif
                                        </div>

                                    </div>

                                </div>
                                <!-- Card -->

                                <!-- Card -->

                                <!-- Card -->

                                <!-- Card -->

                            </div>
                            <!-- Card group -->

                        </div>
                        <div class="col-md-6">
                            <!-- Card -->
                            <div class="card mb-8">

                                <!-- Card content -->
                                <div class="card-body">

                                    <div class="template-demo">

                                        <table class="table mb-0">

                                            <thead>

                                            </thead>

                                            <tbody>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('name') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{$user_details->name}}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('email') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{$user_details->email}}</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('mobile') }} </b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $user_details->mobile }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('login_by') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $user_details->login_by }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('register_type') }} </b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $user_details->register_type }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('payment_mode') }} </b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{$user_details->payment_mode}}</div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td class="pl-0"> <b>{{ tr('status') }}</b></td>

                                                    <td class="pr-0 text-right">

                                                        @if($user_details->status == USER_PENDING)

                                                        <span class="card-text btn-sm btn-danger text-uppercase">{{tr('pending')}}</span> @elseif($user_details->status == USER_APPROVED)

                                                        <span class="card-text  btn-sm btn-success text-uppercase">{{tr('approved')}}</span> @else

                                                        <span class="card-text btn-sm btn-danger text-uppercase">{{tr('declined')}}</span> @endif

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="pl-0"> <b>{{ tr('created_at') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ common_date($user_details->created_at) }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"> <b>{{ tr('updated_at') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ common_date($user_details->updated_at) }}</div>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>

                                        </table>

                                    </div>
                                    <!-- </div> -->

                                </div>
                                <!-- Card content -->

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>
@endsection