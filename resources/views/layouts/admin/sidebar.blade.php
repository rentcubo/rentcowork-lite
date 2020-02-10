<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{Auth::guard('admin')->user()->picture  ?? asset('placeholder.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::guard('admin')->user()->name}}</p>
            </div>
        </div>
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li id="dashboard">
                <a href="{{route('admin.dashboard')}}">
                    <i class="fa fa-dashboard"></i> <span>{{ tr('dashboard') }}</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>

            <li class="header menu-title text-uppercase">{{ tr('account_management')}}</li>

            <li class="treeview" id="users">
                <a href="#">
                    <i class="fa fa-user"></i> <span>{{tr('users')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li id="users-create"><a href="{{route('admin.users.create')}}"><i class="fa fa-circle-o"></i>{{tr('add_user')}}</a></li>
                    <li id="users-view"><a href="{{route('admin.users.index')}}"><i class="fa fa-circle-o"></i>{{tr('view_users')}}</a></li>
                </ul>    
            
            </li>

            <li class="treeview" id="providers">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{{tr('providers')}}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="providers-create"><a href="{{route('admin.providers.create')}}"><i class="fa fa-circle-o"></i>{{tr('add_provider')}}</a></li>
                    <li id="providers-view"><a href="{{route('admin.providers.index')}}"><i class="fa fa-circle-o"></i>{{tr('view_providers')}}</a></li>
                </ul>
            </li>

            
            <li class="header menu-title text-uppercase">{{ tr('booking_manangement')}}</li>

            <li class="treeview" id="spaces">
                <a href="#">
                    <i class="fa fa-home"></i> <span>{{tr('spaces')}}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="spaces-create"><a href="{{route('admin.spaces.create')}}"><i class="fa fa-circle-o"></i>{{tr('add_space')}}</a></li>
                    <li id="spaces-view"><a href="{{route('admin.spaces.index')}}"><i class="fa fa-circle-o"></i>{{tr('view_spaces')}}</a></li>
                </ul>
            </li>

             <li id="bookings">
                <a href="{{route('admin.bookings.index')}}">
                    <i class="fa fa-share"></i> <span>{{ tr('bookings') }}</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>

            <li class="treeview" id="reviews">
                <a href="#">
                    <i class="fa fa-smile-o"></i> <span>{{ tr('reviews') }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="users-review"><a href="{{route('admin.users.review')}}"><i class="fa fa-circle-o"></i>{{ tr('user_reviews') }}</a></li>
                    <li id="providers-review"><a href="{{route('admin.providers.review')}}"><i class="fa fa-circle-o"></i>{{ tr('provider_reviews') }}</a></li>
                </ul>
            </li>

            <li id="revenue">
                <a href="{{route('admin.bookings.payment')}}">
                    <i class="fa fa-money"></i> <span>{{ tr('booking_revenues') }}</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>

            <li class="header menu-title text-uppercase">{{tr('setting_management')}}</li>

            <li class="treeview" id="static_pages">
                <a href="#">
                    <i class="fa fa-book"></i> <span>{{tr('static_pages')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li id="static_pages_create"><a href="{{route('admin.static_pages.create')}}"><i class="fa fa-circle-o"></i>{{tr('add_static_page')}}</a></li>
                    <li id="static_pages_view"><a href="{{route('admin.static_pages.index')}}"><i class="fa fa-circle-o"></i>{{tr('view_static_pages')}}</a></li>
                </ul>    
            
            </li>
            
            <li id="settings"><a href="{{route('admin.settings')}}"><i class="fa fa-cogs"></i> <span>{{tr('settings')}}</span></a></li>

            <li id="profile"><a href="{{route('admin.profile')}}"><i class="fa fa-user-plus"></i> <span>{{tr('admin_profile')}}</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>