@extends('layouts.admin') 

@section('title', tr('view_providers'))

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item-active"><i class="fa fa-users"></i><a href="{{route('admin.providers.index')}}">&nbsp{{tr('providers')}}</a>
    </li>     
@endsection 

@section('content')
<section class="content">

    @include('notification.notify')
    
    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">

            <div class="box box-primary">
                
                <div class="box-header bg-card-header ">

                    <h4 class="">{{tr('providers')}}
                        <button class="btn btn-secondary pull-right">
                            <a  href="{{route('admin.providers.create')}}">
                            <i class="fa fa-plus"></i> {{tr('add_provider')}}
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
                                        <th>{{tr('email')}}</th>
                                        <th>{{tr('status')}}</th>
                                        <th>{{tr('action')}}</th>
                                    </tr>
                               
                                </thead>
                              
                                <tbody>
                                    @if(count($providers)>0)

                                    @foreach($providers as $i => $provider_details)
                                      
                                        <tr>
                                            <td>{{$i+1}}</td>

                                            <td>
                                                <a href="{{route('admin.providers.view' , ['provider_id' => $provider_details->id])}}"> {{ $provider_details->name }}
                                                </a>
                                            </td>

                                            <td> {{ $provider_details->email }} </td>

                                            <td>

                                                @if($provider_details->status == PROVIDER_APPROVED)

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
                                                            <a class="dropdown-item" href="{{ route('admin.providers.view', ['provider_id' => $provider_details->id]) }}">
                                                            {{tr('view')}}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.providers.edit', ['provider_id' => $provider_details->id]) }}">
                                                                {{tr('edit')}}
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{route('admin.providers.delete', ['provider_id' => $provider_details->id])}}" 
                                                            onclick="return confirm(&quot;{{tr('provider_delete_confirmation' , $provider_details->name)}}&quot;);">
                                                                {{tr('delete')}}
                                                            </a>
                                                        </li>
                                                    
                                                        <li>
                                                            @if($provider_details->status == PROVIDER_APPROVED)

                                                                <a class="dropdown-item" href="{{ route('admin.providers.status', ['provider_id' => $provider_details->id]) }}" onclick="return confirm(&quot;{{$provider_details->first_name}} - {{tr('provider_decline_confirmation')}}&quot;);" >
                                                                {{ tr('decline') }} 
                                                                </a>

                                                            @else
                                                                
                                                                <a class="dropdown-item" href="{{ route('admin.providers.status', ['provider_id' => $provider_details->id]) }}">
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
                                
                            <div class="pull-right">{{$providers->links()}}</div>
                        </div>
                </div>

            </div>
        </div>

    </div>

</section>
   
@endsection