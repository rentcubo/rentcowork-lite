@extends('layouts.admin') 

@section('title', tr('view_static_page'))

@section('breadcrumb')
     <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}"&nbsp>{{tr('home')}}</a></li>
    
    <li class="breadcrumb-item"><i class="fa fa-book"></i>
        <a href="{{ route('admin.static_pages.index') }}">&nbsp{{tr('static_pages')}}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        <i class="fa fa-plus"></i><span>&nbsp{{tr('view_static_pages')}}</span>
    </li>
           
@endsection  

@section('content')
<section class="content">

    @include('notification.notify')

    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">

            <div class="col-md-12">

                <!-- Card group -->
                <div class="card-group">

                    <!-- Card -->
                    <div class="box box-primary">
                        
                        <div class="box-header bg-card-header ">

                            <h4 class="">{{tr('static_pages')}}
                                
                            </h4>

                        </div>
                        <!-- Card content -->
                        <div class="box-body">

                            <table class="table mb-0">

                                <tbody>

                                    <tr>
                                        <td class="pl-0"><b>{{ tr('description') }}</b></td>
                                        <td class="pr-0 text-right">
                                            <div>{{ $static_page_details->description}}</div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="pl-0"><b>{{ tr('title') }}</b></td>
                                        <td class="pr-0 text-right">
                                            <div>{{$static_page_details->title}}</div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="pl-0"><b>{{ tr('status') }}</b></td>
                                        <td class="pr-0 text-right">
                                            @if($static_page_details->status == APPROVED)

                                                <span class="btn-sm btn-success text-uppercase">{{tr('approved')}}</span>

                                            @else 

                                                <span class="btn-sm btn-danger text-uppercase">{{tr('pending')}}</span>

                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="pl-0"> <b>{{ tr('created_at') }}</b></td>
                                        <td class="pr-0 text-right">
                                            <div>{{ common_date($static_page_details->created_at) }}</div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="pl-0"> <b>{{ tr('updated_at') }}</b></td>
                                        <td class="pr-0 text-right">
                                            <div>{{ common_date($static_page_details->updated_at) }}</div>
                                        </td>
                                    </tr>
                                    
                                </tbody>

                            </table>

                            <div class="custom-card">
                                <div class="row">
                                    
                                
                                @if(Setting::get('is_demo_control_enabled') == NO)
                                    <div class="col-md-4 col-lg-4">

                                        <a href="{{ route('admin.static_pages.edit', ['static_page_id'=> $static_page_details->id] ) }}" class="btn btn-primary btn-block">{{tr('edit')}}</a>
                                        
                                    </div>                              

                                    <div class="col-md-4 col-lg-4">
                                        <a onclick="return confirm(&quot;{{tr('static_page_delete_confirmation' , $static_page_details->title)}}&quot;);" href="{{ route('admin.static_pages.delete', ['static_page_id'=> $static_page_details->id] ) }}" class="btn btn-danger btn-block">
                                            {{ tr('delete') }}
                                        </a>

                                    </div>
                                    

                                @else
                                    <div class="col-md-4 col-lg-4">
                                        
                                        <button class="btn btn-primary btn-block" disabled>{{ tr('edit') }}</button>

                                    </div>
                                    
                                    <div class="col-md-4 col-lg-4">
                                        
                                        <button class="btn btn-warning btn-block" disabled>{{ tr('delete') }}</button>
                                    </div>
                                    

                                @endif

                                @if($static_page_details->status == APPROVED)

                                    <div class="col-md-4 col-lg-4">
                                        
                                        <a class="btn btn-warning btn-block" href="{{ route('admin.static_pages.status', ['static_page_id'=> $static_page_details->id] ) }}" onclick="return confirm(&quot;{{ $static_page_details->title }}-{{tr('static_page_decline_confirmation' , $static_page_details->title)}}&quot;);">

                                            {{tr('decline')}}
                                        </a>
                                    </div>

                                @else

                                    <div class="col-md-4 col-lg-4">
                                         <a class="btn btn-success btn-block" href="{{ route('admin.static_pages.status', ['static_page_id'=> $static_page_details->id] ) }}">
                                            {{tr('approve')}}
                                        </a>
                                    </div>
                                       
                                @endif

                                </div>

                            </div>

                        </div>
                        <!-- Card content -->

                    </div>

                    <!-- Card -->

                </div>

                <!-- Card group -->

            </div>
        </div>

    </div>
</section>

@endsection