@extends('layouts.provider') 

@section('content')

@include('notifications.notification')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin d-flex flex-column">
            <div class="row">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="text-primary mb-4">
                                <i class="mdi mdi-map-marker mdi-36px"></i>
                                <p class="font-weight-medium mt-2">{{ tr('total_spaces') }}</p>
                            </div>
                            <h1 class="font-weight-light">{{ $total_spaces }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="text-danger mb-4">
                                <i class="mdi mdi-book-open mdi-36px"></i>
                                <p class="font-weight-medium mt-2">{{ tr('total_bookings') }}</p>
                            </div>
                            <h1 class="font-weight-light">{{ $total_bookings }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="text-info mb-4">
                                <i class="mdi mdi-cash mdi-36px"></i>
                                <p class="font-weight-medium mt-2">{{ tr('total_earnings') }}</p>
                            </div>
                            <h1 class="font-weight-light">{{ formatted_amount($total_earnings) }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="text-info mb-4">
                                <i class="mdi mdi-cash mdi-36px"></i>
                                <p class="font-weight-medium mt-2">{{ tr('today_earnings') }}</p>
                            </div>
                            <h1 class="font-weight-light">{{ formatted_amount($today_earnings) }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row flex-grow-1">
                <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ tr('spaces_approved') }}</h4>
                            @if( $data->spaces_approved == 0 && $data->spaces_not_approved == 0)
                                <div>{{ tr('no_spaces_found') }}</div>
                            @else
                                <canvas id="spaces_approved"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ tr('spaces_published') }}</h4>

                            @if( $data->spaces_published == 0 && $data->spaces_not_published == 0)
                                <div>{{ tr('no_spaces_found') }}</div>
                            @else
                                <canvas id="spaces_published"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- content-wrapper ends -->


<script type="text/javascript">

    var ctx = document.getElementById("spaces_approved").getContext('2d');

    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["{{ tr('spaces_approved') }}",  "{{ tr('spaces_not_approved') }}" ],
        datasets: [{
          backgroundColor: [
            "#2ecc71",
            "#e74c3c",
          ],
          data: [{{ $data->spaces_approved }}, {{ $data->spaces_not_approved }}]
        }]
      }
    });

    var ctx1 = document.getElementById("spaces_published").getContext('2d');

    var myChart = new Chart(ctx1, {
      type: 'doughnut',
      data: {
        labels: ["{{ tr('spaces_published') }}",  "{{ tr('spaces_not_published') }}" ],
        datasets: [{
          backgroundColor: [
            "#3498db",
            "#95a5a6",
          ],
          data: [{{ $data->spaces_published }}, {{ $data->spaces_not_published }}]
        }]
      }
    });
</script>
@endsection