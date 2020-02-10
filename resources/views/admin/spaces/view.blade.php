@extends('layouts.admin') 

@section('title', tr('view_space')) 


@section('breadcrumb')

    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{route('admin.dashboard')}}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item">
        <i class="fa fa-home"></i><a href="{{ route('admin.spaces.index') }}">&nbsp{{tr('spaces')}}</a>
    </li>
   
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fa fa-home"></i><span>&nbsp{{tr('view_spaces')}}</span>
    </li>

@endsection 

@section('content')

<section class="content">

    @include('notification.notify')

    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">
        
            <div class="box box-primary">

                <div class="box-header bg-card-header">
                    <h4>{{tr('space_details')}}</h4>
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

                                        <img class="image" src="{{$space_details->picture ?? asset('placeholder.png')}}">
                                        <a href="#!">
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>

                                    <div class="card-body">

                                        <hr>
                                         <a class="btn btn-primary button-width" href="{{ route('admin.spaces.edit', ['space_id' => $space_details->id])}}">{{tr('edit')}}</a>

                                        <a class="btn btn-danger button-width" href="{{route('admin.spaces.delete', ['space_id' => $space_details->id])}}" onclick="return confirm(&quot;{{tr('admin_space_delete_confirmation' , $space_details->name)}}&quot;);">{{tr('delete')}}</a> 
                                        @if($space_details->admin_status == SPACE_APPROVED)

                                            <a class="btn btn-danger button-width" href="{{ route('admin.spaces.status', ['space_id' => $space_details->id]) }}" onclick="return confirm(&quot;{{$space_details->name}} - {{tr('admin_space_decline_confirmation')}}&quot;);">
                                                {{ tr('decline') }} 
                                            </a> 
                                        @else

                                            <a class="btn btn-success" href="{{ route('admin.spaces.status', ['space_id' => $space_details->id]) }}">
                                                {{ tr('approve') }} 
                                            </a> 
                                        @endif

                                        <div class="row">
                                            @if($space_details->description)
                                            <h5 class="col-md-12">{{tr('description')}}</h5>

                                            <p class="col-md-12 text-muted">{{$space_details->description}}</p>
                                            @endif
                                        </div>

                                    </div>

                                </div>
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
                                                        <div>{{$space_details->name}}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('provider_name') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $space_details->provider ? $space_details->provider->name : "-" }}</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('tagline') }} </b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $space_details->tagline }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('per_hour') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{formatted_amount($space_details->per_hour)}}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('instructions') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $space_details->instructions }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('space_type') }} </b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $space_details->space_type }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"><b>{{ tr('full_address') }} </b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ $space_details->full_address }}</div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td class="pl-0"> <b>{{ tr('status') }}</b></td>

                                                    <td class="pr-0 text-right">

                                                        @if($space_details->admin_status == SPACE_PENDING)

                                                        <span class="card-text btn-sm btn-danger text-uppercase">{{tr('pending')}}</span> @elseif($space_details->admin_status == SPACE_APPROVED)

                                                            <span class="card-text  btn-sm btn-success text-uppercase">{{tr('approved')}}</span> 

                                                        @else

                                                            <span class="card-text btn-sm btn-danger text-uppercase">{{tr('declined')}}</span> 
                                                        @endif

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="pl-0"> <b>{{ tr('created_at') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ common_date($space_details->created_at) }}</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="pl-0"> <b>{{ tr('updated_at') }}</b></td>
                                                    <td class="pr-0 text-right">
                                                        <div>{{ common_date($space_details->updated_at) }}</div>
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