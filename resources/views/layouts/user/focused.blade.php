<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ setting()->get('site_name')}}</title>
    <!-- plugins:css -->
    @include('layouts.user.styles')
</head>

<body>
    <div class="container-scroller">


        <div class="horizontal-menu">
            
            <nav class="bottom-navbar">
                <div class="container">

                    <div class="pull-right">
                        <ul class="nav page-navigation">

                            <li class="nav-item" id="spaces">
                                <a href="{{ route('provider.login') }}" class="nav-link">
                                    <i class="mdi mdi-map-marker menu-icon"></i>
                                    <span class="menu-title">{{ tr('become_provider') }}</span>
                                </a>
                            </li>

                            <li class="nav-item" id="bookings">
                                <a href="{{ route('login') }}" class="nav-link">
                                    <i class="mdi mdi-login menu-icon"></i>
                                    <span class="menu-title">{{ tr('login') }}</span>
                                </a>
                            </li>

                             <li class="nav-item" id="profile">
                                <a href="{{ route('register') }}" class="nav-link">
                                    <i class="mdi mdi-plus-circle  menu-icon"></i>
                                    <span class="menu-title">{{ tr('sign_up') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
        </div>

        <div class="container-fluid page-body-wrapper full-page-wrapper">
        
            @yield('content');
        
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
  
    @include('layouts.user.scripts')
</body>

</html>

</html>