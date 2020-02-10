<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">

            <li class="nav-item" id="spaces">
                <a href="{{ route('spaces.index') }}" class="nav-link">
                    <i class="mdi mdi-map-marker menu-icon"></i>
                    <span class="menu-title">{{ tr('spaces') }}</span>
                </a>
            </li>

            <li class="nav-item" id="bookings">
                <a href="{{ route('bookings.index') }}" class="nav-link">
                    <i class="mdi mdi-book-open menu-icon"></i>
                    <span class="menu-title">{{ tr('bookings') }}</span>
                </a>
            </li>

             <li class="nav-item" id="profile">
                <a href="{{ route('profile.view') }}" class="nav-link">
                    <i class="mdi mdi-face-profile  menu-icon"></i>
                    <span class="menu-title">{{ tr('profile') }}</span>
                </a>
            </li>
        </ul>
    </div>
</nav>