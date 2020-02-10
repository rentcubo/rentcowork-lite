@extends('layouts.provider') 

@section('content')

    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    @include('notifications.notification')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <img src="{{ $space_details->picture }}" class="picture-size">
                            </div>

                            <div class="col-lg-8">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>{{ $space_details->name }}</h3>
                                    </div>

                                    <a href="{{ route('provider.spaces.index') }}"><button class="btn btn-primary">{{ tr('view_spaces') }}</button></a>
                                </div>

                                <div class="mt-4 py-2 border-top border-bottom">
                                    <ul class="nav profile-navbar">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">
                                                <i class="mdi mdi-account-outline"></i> {{ tr('info') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="profile-feed">
                                    <div class="py-4">

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('space_type') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->space_type }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('tagline') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->tagline ?? '-'}}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('description') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->description ?? '-' }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('full_address') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->full_address ?? '-'}}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('instructions') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ $space_details->instructions ?? '-' }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('per_hour') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ formatted_amount($space_details->per_hour) }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                               {{ tr('admin_status') }}
                                            </span>
                                            
                                            @if($space_details->admin_status == ADMIN_SPACE_APPROVED)
                                                    
                                                <span class="float-right badge badge-success">{{ tr('admin_approved') }}</span>
                                            @else
                                                <span class="float-right badge badge-danger">{{ tr('admin_not_approved')  }}</span>
                                            
                                            @endif

                                        </p>

                                         <p class="clearfix">
                                            <span class="float-left">
                                               {{ tr('status') }}
                                            </span>
                                            
                                            @if($space_details->status == SPACE_OWNER_PUBLISHED)
                                                    
                                                <span class="float-right badge badge-success">{{ tr('published') }}</span>
                                            @else
                                                <span class="float-right badge badge-danger">{{ tr('not_published')  }}</span>
                                            
                                            @endif

                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('created_at') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($space_details->created_at) }}
                                            </span>
                                        </p>

                                        <p class="clearfix">
                                            <span class="float-left">
                                                {{ tr('updated_at') }}
                                            </span>

                                            <span class="float-right text-muted">
                                                {{ common_date($space_details->updated_at) }}
                                            </span>
                                        </p>
                                        <br>
                                         <div class="d-flex justify-content-between float-right">
                                            <a href="{{ route('provider.spaces.edit', ['space_details_id' => $space_details->id]) }}">
                                                <button class="btn btn-primary mr-1">{{ tr('edit') }}</button>
                                            </a>

                                            @if($space_details->status == SPACE_OWNER_NOT_PUBLISHED)

                                                <a href="{{ route('provider.spaces.status', ['space_details_id' => $space_details->id]) }}"> <button class="btn btn-info mr-1"> {{ tr('publish') }}</button></a>
                                
                                            @else
                                                <a href="{{ route('provider.spaces.status', ['space_details_id' => $space_details->id]) }}" onclick="return confirm('{{ tr('space_unpublish_confirmation') . $space_details->name }} ?')"> <button class="btn btn-danger mr-1"> {{ tr('unpublish') }} </button></a>

                                            @endif
                                            
                                            <a href="{{ route('provider.spaces.delete', ['space_details_id' => $space_details->id]) }}"  onclick="return confirm(' {{ tr('space_delete_confirmation') . $space_details->name }}?')">
                                                <button class="btn btn-danger mr-1">{{ tr('delete') }}</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
@endsection