<nav class="navbar top-navbar col-lg-12 col-12 p-0">

    <div class="container">

        <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
            <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">
                <li class="nav-item nav-search d-none d-lg-flex">

                </li>
            </ul>

            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                
                <a class="navbar-brand brand-logo" href="{{ route('provider.dashboard') }}"><img src="{{ setting()->get('site_logo') }}" alt="logo" /></a>

            </div>

            <ul class="navbar-nav navbar-nav-right">

                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="{{ Auth('provider')->user()->picture }}" alt="profile"/>
                        <span class="nav-profile-name">{{ Auth('provider')->user()->name }}</span>
                     </a>

                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="{{ route('provider.profile.view') }}">
                            <i class="mdi mdi-face-profile text-primary"></i> {{ tr('profile') }}
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="mdi mdi-logout text-primary"></i> {{ tr('logout') }}
                        </a>

                    </div>
                </li>
                
                <li class="nav-item nav-toggler-item-right d-lg-none">
                    <button class="navbar-toggler align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>