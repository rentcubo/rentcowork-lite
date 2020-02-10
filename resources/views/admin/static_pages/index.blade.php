@extends('layouts.admin') 

@section('title', tr('view_static_page'))

@section('breadcrumb')
     <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}"&nbsp>{{tr('home')}}</a></li>
    
    <li class="breadcrumb-item"><i class="fa fa-book"></i>
        <a href="{{ route('admin.static_pages.index') }}">&nbsp{{tr('static_pages')}}</a>
    </li>
              
@endsection 

@section('content')
<section class="content">

    @include('notification.notify')

    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">
                
            <div class="box box-primary">

                <div class="box-header bg-card-header">

                    <h4 class="">{{tr('static_pages')}}
                        <button class="btn btn-secondary pull-right"><a  href="{{route('admin.static_pages.create')}}">
                            <i class="fa fa-plus"></i> {{tr('add_static_page')}}
                        </a></button>
                        

                    </h4>

                </div>

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>{{tr('s_no')}}</th>
                                    <th>{{tr('title')}}</th>
                                    <th>{{tr('static_page_type')}}</th>
                                    <th>{{tr('status')}}</th>
                                    <th>{{tr('action')}}</th>
                                </tr>
                            </thead>

                            <tbody>


                                @foreach($static_pages as $i => $static_page_details)

                                    <tr>
                                        <td>{{$i+1}}</td>

                                        <td>
                                            <a href="{{route('admin.static_pages.view' , ['static_page_id'=> $static_page_details->id] )}}"> {{$static_page_details->title}}</a>
                                        </td>

                                        <td class="text-capitalize">{{$static_page_details->type}}</td>

                                        <td>
                                            @if($static_page_details->status == APPROVED)

                                              <span class="btn-xs btn-success">{{tr('approved')}}</span> 

                                            @else

                                              <span class="btn-xs btn-warning">{{tr('pending')}}</span> 
                                            @endif
                                        </td>

                                        <td>  

                                        <div class="dropdown">

                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{tr('action')}}
                                                <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.static_pages.view', ['static_page_id' => $static_page_details->id] ) }}">
                                                    {{tr('view')}}
                                                </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.static_pages.edit', ['static_page_id' => $static_page_details->id] ) }}">
                                                        {{tr('edit')}}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a class="dropdown-item" 
                                                    onclick="return confirm(&quot;{{tr('static_page_delete_confirmation' , $static_page_details->title)}}&quot;);" href="{{ route('admin.static_pages.delete', ['static_page_id' => $static_page_details->id] ) }}" >
                                                        {{ tr('delete') }}
                                                    </a>
                                                </li>
                                            
                                                <li>
                                                    @if($static_page_details->status == APPROVED)

                                                    <a class="dropdown-item" href="{{ route('admin.static_pages.status', ['static_page_id' =>  $static_page_details->id] ) }}" 
                                                    onclick="return confirm(&quot;{{$static_page_details->title}} - {{tr('static_page_decline_confirmation')}}&quot;);"> 
                                                        {{tr('decline')}}
                                                    </a>

                                                @else

                                                    <a class="dropdown-item" href="{{ route('admin.static_pages.status', ['static_page_id' =>  $static_page_details->id] ) }}">
                                                        {{tr('approve')}}
                                                    </a>
                                                       
                                                @endif
                                                </li>
                                            </ul>
                                        </div> 
                                            
                                        </td>
                                    
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>
            
            </div>

        </div>

    </div>
</section>
@endsection