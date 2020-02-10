@extends('layouts.admin') 

@section('title', tr('view_users'))

@section('breadcrumb')
    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>
    
    <li class="breadcrumb-item"><i class="fa fa-user"></i><a href="{{ route('admin.users.index')}}">&nbsp{{tr('users')}}</a></li>
           
@endsection 

@section('content')
<section class="content">

    @include('notification.notify')
    
    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="box box-primary">
                
                <div class="box-header bg-card-header ">

                    <h4 class="">{{tr('users')}}
                        <button class="btn btn-secondary pull-right">
                            <a  href="{{route('admin.users.create')}}">
                            <i class="fa fa-plus"></i> {{tr('add_user')}}
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
                                        <th>{{tr('created_at')}}</th>
                                        <th>{{tr('action')}}</th>
                                    </tr>
                               
                                </thead>
                              
                                <tbody>
                                    @if(count($users)>0)

                                    @foreach($users as $i => $user_details)
                                      
                                        <tr>
                                            <td>{{$i+1}}</td>

                                            <td>
                                                <a href="{{route('admin.users.view' , ['user_id' => $user_details->id])}}"> {{ $user_details->name }}
                                                </a>
                                            </td>

                                            <td> {{ $user_details->email }} </td>

                                            <td>

                                                @if($user_details->status == USER_APPROVED)

                                                    <span class="btn-xs btn-success">{{ tr('approved') }} </span>

                                                @else

                                                    <span class="btn-xs btn-danger">{{ tr('declined') }} </span>

                                                @endif

                                            </td>

                                            <td>{{common_date($user_details->created_at,'','d M Y')}}</td>

                                            <td>     
                                                <div class="dropdown">

                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{tr('action')}}
                                                    <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.users.view', ['user_id' => $user_details->id]) }}">
                                                            {{tr('view')}}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.users.edit', ['user_id' => $user_details->id]) }}">
                                                                {{tr('edit')}}
                                                            </a>
                                                        </li>
                                                        <li class="divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{route('admin.bookings.index',['user_id' => $user_details->id])}}">
                                                                {{tr('bookings')}}
                                                            </a>
                                                        </li>
                                                        <li class="divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{route('admin.users.delete', ['user_id' => $user_details->id])}}" 
                                                            onclick="return confirm(&quot;{{tr('user_delete_confirmation' , $user_details->name)}}&quot;);">
                                                                {{tr('delete')}}
                                                            </a>
                                                        </li>
                                                    
                                                        <li>
                                                            @if($user_details->status == USER_APPROVED)

                                                                <a class="dropdown-item" href="{{ route('admin.users.status', ['user_id' => $user_details->id]) }}" onclick="return confirm(&quot;{{$user_details->first_name}} - {{tr('user_decline_confirmation')}}&quot;);" >
                                                                {{ tr('decline') }} 
                                                                </a>

                                                            @else
                                                                
                                                                <a class="dropdown-item" href="{{ route('admin.users.status', ['user_id' => $user_details->id]) }}">
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
                                        <tr><td>{{tr('user_not_found')}}</td></tr>
                                    @endif
                                                                         
                                </tbody>
                                
                            </table>
                               <div class="pull-right">{{$users->links()}}</div> 
                        </div>
                </div>

            </div>
        </div>

    </div>

</section>
   
@endsection