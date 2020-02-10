@extends('layouts.provider')

@section('content')

    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!--Section_Content_Start-->
                        <section class="terms">
                            <div id="login">
                                <div class="container">
                                    <div id="login-row" class="row justify-content-center align-items-center">
                                        <div id="login-column" class="col-md-12">
                                            <div id="login-box" class="col-md-12">

                                                <h2>{{ $page->title ?? tr('title') }}</h2>

                                                <p>{{ $page->description ?? tr('description') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!--Section_end-->
@endsection