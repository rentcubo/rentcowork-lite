<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            <li class="nav-item" id="dashboard">
                <a class="nav-link" href="{{ route('provider.dashboard') }}">
                    <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
                    <span class="menu-title">{{ tr('dashboard') }}</span>
                </a>
            </li>
    
            <li class="nav-item" id="spaces">
                <a href="#" class="nav-link">
                    <i class="mdi mdi-map-marker menu-icon"></i>
                    <span class="menu-title">{{ tr('spaces') }}</span>
                    <i class="menu-arrow"></i>
                </a>
                
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link" href="{{ route('provider.spaces.index') }}">{{ tr('view_spaces') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('provider.spaces.create') }}">{{  tr('add_space') }}</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item" id="bookings">
                <a href="{{ route('provider.bookings.index') }}" class="nav-link">
                    <i class="mdi mdi-book-open menu-icon"></i>
                    <span class="menu-title">{{ tr('bookings') }}</span>
                </a>
            </li>

             <li class="nav-item" id="profile">
                <a href="{{ route('provider.profile.view') }}" class="nav-link">
                    <i class="mdi mdi-face-profile  menu-icon"></i>
                    <span class="menu-title">{{ tr('profile') }}</span>
                </a>
            </li>
        </ul>
    </div>
</nav>