@extends('layouts.provider')

@section('content')
    
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                
                <div class="card">
                <div class="card-body">
                    @include('notifications.notification')
                    <h4 class="card-title">
                        {{ tr('spaces') }}
                        
                        <a href="{{ route('provider.spaces.create') }}"><button class="float-right btn btn-success">{{ tr('add_space') }}</button></a> 
                    </h4>
                    <div class="table-responsive">
                        <br>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ tr('sno') }}</th>
                                    <th>{{ tr('name') }}</th>
                                    <th>{{ tr('space_type') }}</th>
                                    <th>{{ tr('admin_status') }}</th>
                                    <th>{{ tr('status') }}</th>
                                    <th>{{ tr('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($spaces)>0)
                                    @foreach($spaces as $i => $space_details)
                                        <tr>
                                            <td class="py-1">
                                              {{ $i+1 }}
                                            </td>
                                            <td>
                                                <a href="{{ route('provider.spaces.view', ['space_details_id' => $space_details->id]) }}">{{ $space_details->name }}</a>
                                            </td>
                                            <td>
                                                {{ $space_details->space_type }}
                                            </td>
                                            
                                            <td>
                                                @if($space_details->admin_status == ADMIN_SPACE_APPROVED)
                                                    <div class="badge badge-success">{{ tr('admin_approved') }}</div>
                                                @else
                                                    <div class="badge badge-danger">{{ tr('admin_not_approved') }}</div>
                                                @endif
                                            </td>

                                            <td>
                                                @if($space_details->status == SPACE_OWNER_PUBLISHED)
                                                    <div class="badge badge-success">{{ tr('published') }}</div>
                                                @else
                                                    <div class="badge badge-danger">{{ tr('not_published') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                 <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">{{ tr('action')}}
                                                    <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{ route('provider.spaces.view', ['space_details_id' => $space_details->id]) }}" class="dropdown-item" >{{ tr('view') }}</a></li>
                                                        <li><a href="{{ route('provider.spaces.edit', ['space_details_id' => $space_details->id]) }}" class="dropdown-item">{{ tr('edit') }}</a></li>
                                                        <li><a href="{{ route('provider.spaces.delete', ['space_details_id' => $space_details->id]) }}" class="dropdown-item" onclick="return confirm(' {{ tr('space_delete_confirmation') . $space_details->name }}?')" >{{ tr('delete') }}</a></li>
                                                        <div class="dropdown-divider"></div>

                                                        <li>
                                                            @if($space_details->status == SPACE_OWNER_NOT_PUBLISHED)

                                                                <a href="{{ route('provider.spaces.status', ['space_details_id' => $space_details->id]) }}" class="dropdown-item"> {{ tr('publish') }}</a>
                                                
                                                            @else
                                                                <a href="{{ route('provider.spaces.status', ['space_details_id' => $space_details->id]) }}" class="dropdown-item" onclick="return confirm('{{ tr('space_unpublish_confirmation') . $space_details->name }} ?')"> {{ tr('unpublish') }}</a>

                                                            @endif
                                                        </li>
                                                              
                                                    </ul>
                                                </div> 
                                            </td>
                                        </tr>

                                    @endforeach    
                                @else

                                    <td colspan="8"><div><h4>{{ tr('no_space_found') }}</h4></div></td>
                                @endif

                            </tbody>
                        </table>

                        @if(count($spaces)>0)

                            <div class="pull-right">{{ $spaces->links() }}</div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->

@endsection