@extends('layouts.admin') 

@section('title', tr('view_sapces'))

@section('breadcrumb')

    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{route('admin.dashboard')}}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item-active">
        <i class="fa fa-home"></i><a href="{{ route('admin.spaces.index') }}">&nbsp{{tr('spaces')}}</a>
    </li>
           
@endsection 

@section('content')
<section class="content">
    @include('notification.notify')
    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">

            <div class="box box-primary">
                
                <div class="box-header bg-card-header ">

                    <h4 class="">{{tr('spaces')}}
                        <button class="btn btn-secondary pull-right">
                            <a  href="{{route('admin.spaces.create')}}">
                            <i class="fa fa-plus"></i> {{tr('add_space')}}
                            </a>
                        </button>
                    </h4>

                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        
                            <table id="order-listing" class="table">
                               
                                <thead>
                               
                                    <tr>
                                        <th>{{tr('s_no')}}</th>
                                        <th>{{tr('name')}}</th>
                                        <th>{{tr('provider')}}</th>
                                        <th>{{tr('per_hour')}}</th>
                                        <th>{{tr('status')}}</th>
                                        <th>{{tr('action')}}</th>
                                    </tr>
                               
                                </thead>
                              
                                <tbody>
                                    @if(count($spaces)>0)

                                    @foreach($spaces as $i => $space_details)
                                      
                                        <tr>
                                            <td>{{$i+1}}</td>

                                            <td>
                                                <a href="{{route('admin.spaces.view' , ['space_id' => $space_details->id])}}"> {{ $space_details->name }}
                                                </a>
                                            </td>

                                            <td> <a href="{{route('admin.providers.view' , ['provider_id' => $space_details->provider_id])}}">{{ $space_details->provider ?$space_details->provider->name : tr('provider_not_avail') }}</a> </td>

                                            <td> {{ formatted_amount($space_details->per_hour) }} </td>

                                            <td>

                                                @if($space_details->admin_status == SPACE_APPROVED)

                                                    <span class="btn-xs btn-success">{{ tr('approved') }} </span>

                                                @else

                                                    <span class="btn-xs btn-danger">{{ tr('declined') }} </span>

                                                @endif

                                            </td>

                                            <td>     
                                                <div class="dropdown">

                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{tr('action')}}
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.spaces.view', ['space_id' => $space_details->id]) }}">
                                                            {{tr('view')}}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.spaces.edit', ['space_id' => $space_details->id]) }}">
                                                                {{tr('edit')}}
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{route('admin.spaces.delete', ['space_id' => $space_details->id])}}" 
                                                            onclick="return confirm(&quot;{{tr('admin_space_delete_confirmation' , $space_details->name)}}&quot;);">
                                                                {{tr('delete')}}
                                                            </a>
                                                        </li>
                                                    
                                                        <li>
                                                            @if($space_details->admin_status == SPACE_APPROVED)

                                                                <a class="dropdown-item" href="{{ route('admin.spaces.status', ['space_id' => $space_details->id]) }}" onclick="return confirm(&quot;{{$space_details->name .'-'. tr('admin_space_decline_confirmation')}}&quot;);" >
                                                                {{ tr('decline') }} 
                                                                </a>

                                                            @else
                                                                
                                                                <a class="dropdown-item" href="{{ route('admin.spaces.status', ['space_id' => $space_details->id]) }}">
                                                                    {{ tr('approve') }} 
                                                                </a>
                                                                   
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            
                                            </td>

                                        </tr>

                                    @endforeach

                                    @else
                                        <tr><td>{{tr('no_results_found')}}</td></tr>
                                    @endif
                                                                         
                                </tbody>
                                
                            </table>
                            <div class="pull-right">{{$spaces->links()}}</div> 
                        </div>
                </div>

            </div>
        </div>

    </div>

</section>
   
@endsection