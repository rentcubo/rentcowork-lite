@extends('layouts.admin') 

@section('title', tr('reviews'))

@section('breadcrumb')

    <li class="breadcrumb-item"><i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}">&nbsp{{tr('home')}}</a></li>

    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-cogs"></i>
        <span>&nbsp{{ tr('settings') }}</span>
    </li> 

@endsection 

@section('content')

<section class="content">

    @include('notification.notify')

    <div class="row">
        
        <div class="col-lg-12 grid-margin stretch-card">
        
            <div class="box box-primary">

                <div class="box-header bg-card-header ">
                
                    <h4 class="">{{ tr('settings') }}</h4>
            
                </div>

                <div class="box-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#setting">{{tr('site_settings')}}</a></li>
                        <li><a data-toggle="tab" href="#email_setting">{{tr('email_setting')}}</a></li>
                        <li><a data-toggle="tab" href="#revenue_setting">{{tr('revenue_settings')}}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="setting" class="tab-pane fade in active">
                            <form id="site_settings_save" action="{{ route('admin.settings.save') }}" method="POST" enctype="multipart/form-data" role="form">

                                @csrf

                                <div class="box-body">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <h3 class="settings-sub-header text-uppercase"><b>{{tr('site_settings')}}</b></h3>

                                            <hr>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="site_name">{{tr('site_name')}} *</label>
                                                <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Enter {{tr('site_name')}}" value="{{Setting::get('site_name')}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="site_logo">{{tr('site_logo')}} *</label>
                                                <p class="txt-warning">{{tr('png_image_note')}}</p>
                                                <input type="file" class="form-control" id="site_logo" name="site_logo" accept="image/png" placeholder="{{tr('site_logo')}}">
                                            </div>
                                            
                                            @if(Setting::get('site_logo'))

                                                <img class="img img-thumbnail m-b-20" style="width: 40%" src="{{Setting::get('site_logo')}}" alt="{{Setting::get('site_name')}}"> 

                                            @endif

                                        </div>

                                        <div class="col-lg-6">

                                            <div class="form-group">

                                                <label for="site_icon">{{tr('site_icon')}} *</label>

                                                <p class="txt-warning">{{tr('png_image_note')}}</p>

                                                <input type="file" class="form-control" id="site_icon" name="site_icon" accept="image/png" placeholder="{{tr('site_icon')}}">

                                            </div>

                                            @if(Setting::get('site_icon'))

                                                <img class="img img-thumbnail m-b-20" style="width: 20%" src="{{Setting::get('site_icon')}}" alt="{{Setting::get('site_name')}}"> 

                                            @endif

                                        </div>

                                    </div>

                                </div>

                                <!-- /.box-body -->

                                <div class="box-footer">

                                    <button type="reset" class="btn btn-warning">{{tr('reset')}}</button>

                                    @if(Setting::get('admin_delete_control') == 1)
                                        <button type="submit" class="btn btn-primary pull-right" disabled>{{tr('submit')}}</button>
                                    @else
                                        <button type="submit" class="btn btn-success pull-right">{{tr('submit')}}</button>
                                    @endif
                                </div>
                            
                            </form>
                        </div>
                        <div id="email_setting" class="tab-pane fade">
                            <form action="{{ route('admin.common-settings.save') }}" method="POST" enctype="multipart/form-data" role="form">
                                @csrf       
                                <div class="box-body">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <h3 class="settings-sub-header text-uppercase"><b>{{ tr('email_settings') }}</b></h3>
                                            <hr>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="MAIL_DRIVER">{{ tr('MAIL_DRIVER') }}</label>
                                                <input type="text" value="{{  $result['MAIL_DRIVER'] }}" class="form-control" name="MAIL_DRIVER" id="MAIL_DRIVER" placeholder="Enter {{ tr('MAIL_DRIVER') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="MAIL_HOST">{{ tr('MAIL_HOST') }}</label>
                                                <input type="text" class="form-control" value="{{ $result['MAIL_HOST'] }}" name="MAIL_HOST" id="MAIL_HOST" placeholder="{{ tr('MAIL_HOST') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="MAIL_PORT">{{ tr('MAIL_PORT') }}</label>
                                                <input type="text" class="form-control" value="{{ $result['MAIL_PORT'] }}" name="MAIL_PORT" id="MAIL_PORT" placeholder="{{ tr('MAIL_PORT') }}">
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="MAIL_USERNAME">{{ tr('MAIL_USERNAME') }}</label>
                                                <input type="text" class="form-control" value="{{ $result['MAIL_USERNAME']  }}" name="MAIL_USERNAME" id="MAIL_USERNAME" placeholder="{{ tr('MAIL_USERNAME') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="MAIL_PASSWORD">{{ tr('MAIL_PASSWORD') }}</label>
                                                <input type="password" class="form-control" name="MAIL_PASSWORD" id="MAIL_PASSWORD" placeholder="{{ tr('MAIL_PASSWORD') }}" value="{{ $result['MAIL_PASSWORD'] }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="MAIL_ENCRYPTION">{{ tr('MAIL_ENCRYPTION') }}</label>
                                                <input type="text" class="form-control" value="{{ $result['MAIL_ENCRYPTION']  }}" name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION" placeholder="{{ tr('MAIL_ENCRYPTION') }}">
                                            </div>

                                        </div>

                                        <div class="clearfix"></div>

                                        @if($result['MAIL_DRIVER'] == 'mailgun')

                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="MAILGUN_DOMAIN">{{ tr('MAILGUN_DOMAIN') }}</label>
                                                <input type="text" class="form-control" value="{{ $result['MAILGUN_DOMAIN']  }}" name="MAILGUN_DOMAIN" id="MAILGUN_DOMAIN" placeholder="{{ tr('MAILGUN_DOMAIN') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="MAILGUN_SECRET">{{ tr('MAILGUN_SECRET') }}</label>
                                                <input type="text" class="form-control" name="MAILGUN_SECRET" id="MAILGUN_SECRET" placeholder="{{ tr('MAILGUN_SECRET') }}" value="{{ $result['MAILGUN_SECRET'] }}">
                                            </div>

                                        </div>

                                        @endif

                                    </div>

                                </div>

                                 <div class="box-footer">
                                    
                                    <button type="reset" class="btn btn-warning">{{ tr('reset') }}</button>
                                    
                                    <button type="submit" class="btn btn-primary pull-right" @if(Setting::get('admin_delete_control') == YES ) disabled  @endif>{{ tr('submit') }}</button>                       
                                </div>

                            </form>
                        </div>
                        <div id="revenue_setting" class="tab-pane fade">
                            <form action="{{ (Setting::get('admin_delete_control') == YES ) ? '#' : route('admin.settings.save') }}" method="POST" enctype="multipart/form-data" role="form">
                                @csrf
                                <div class="box-body">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <h3 class="settings-sub-header text-uppercase"><b>{{ tr('revenue_settings') }}</b></h3>
                                            <hr>
                                        </div>
                                       

                                         <div class="col-md-6">
                                            <div class="form-group">

                                                <label for="admin_commission">{{ tr('admin_commission') }}</label>

                                                <input type="number" class="form-control" name="admin_commission" value="{{ Setting::get('admin_commission') }}" min="0" max="100" maxlength="100" pattern="[0-9]{0,}" id="admin_commission"  placeholder="{{ tr('admin_commission') }}">
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="provider_commission">{{ tr('provider_commission') }}</label>
                                                <input type="number" class="form-control" name="provider_commission" value="{{ Setting::get('provider_commission') }}" min="0" max="100" maxlength="100" pattern="[0-9]{0,}" id="provider_commission" placeholder="{{ tr('provider_commission') }}">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>
                                    
                                </div>

                             <div class="box-footer">

                                <button type="reset" class="btn btn-warning">{{ tr('reset') }}</button>

                                <button type="submit" class="btn btn-primary pull-right" @if(Setting::get('admin_delete_control') == YES ) disabled @endif>{{ tr('submit') }}</button>
                                
                            </div>
                        </form>
                        </div>  
                        <div id="others" class="tab-pane fade">
                            <h3 class="settings-sub-header text-uppercase"><b>{{ tr('others') }}</b></h3>
                            <hr>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>


@endsection

