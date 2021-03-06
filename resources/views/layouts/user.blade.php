<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>{{ setting()->get('site_name') }}</title>

    <link rel="shortcut icon" href="{{ asset('provider-assets/images/favicon.png') }}" />

    @include('layouts.user.styles')

</head>

<body>
  
    <div class="container-scroller">
        <!-- partial:partials/_horizontal-navbar.html -->
        <div class="horizontal-menu">
            
            @include('layouts.user.header')

            @include('layouts.user.navbar')
            
        </div>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
          
            <div class="main-panel">
              
                @yield('content')

                @include('layouts.user.footer')

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ tr('ready_to_leave') }}</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                
                <div class="modal-body">{{ tr('logout_session') }}</div>
                
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ tr('cancel') }}</button>

                   <a class="btn btn-primary" href="{{ route('logout') }}"    onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                      {{ tr('logout') }}
                   </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>

                </div>
        
            </div>
       
        </div>
   
    </div>

    @include('layouts.user.scripts')

</body>
</html>
