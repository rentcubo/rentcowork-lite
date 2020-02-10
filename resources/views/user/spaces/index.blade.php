@extends('layouts.user')

@section('content')
    
    <div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row portfolio-grid">
                                
                                @if(count($spaces)>0)

                                    @foreach($spaces as $i => $space_details)
                                        
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                                            <div class="card">         
                                                <a href="{{ route('spaces.view', ['space_details_id' => $space_details->id]) }}">
                                                    <figure class="effect-text-in">
                                                        <img src="{{ $space_details->picture }}" alt="image"  onerror="this.onerror=null; this.src='{{ asset('space-placeholder.jpg') }}'" />
                                                        <figcaption>
                                                            <h4>{{ $space_details->name }}</h4>
                                                            <p>{{ tr('per_hour') .' - '. formatted_amount($space_details->per_hour) }}</p>
                                                        </figcaption>
                                                    </figure>
                                                </a>
                                                <div class="card-body">
                                                    <p class="card-text">{{ $space_details->full_address }}</p>
                                                </div>
                                            </div>
                                        </div>
                                     @endforeach    
                                @else

                                    <div><h4>{{ tr('no_space_found') }}</h4></div>

                                @endif
                            </div>
                        </div>

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