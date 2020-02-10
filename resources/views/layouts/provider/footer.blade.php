<!-- partial:partials/_footer.html -->
<footer class="footer">
    
    <div class="w-100 clearfix">
        
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">{{ tr('copyright') }} © {{ date("Y") }} <a href="http://cowork-lite.rentcubo.info" target="_blank">{{ setting()->get('site_name') }}.</a> {{ tr('all_rights_reserved') }}.</span>
        
        <div class='inline'><a class="social-inner" href="{{ route('provider.pages',['page_type' =>'privacy']) }}">{{ tr('privacy') }}</a></div>

      	<div class='inline'><a class="social-inner" href="{{ route('provider.pages', ['page_type' =>'cancellation']) }}">{{ tr('cancellation_policy') }}</a></div>

      	<div class='inline'><a class="social-inner" href="{{ route('provider.pages', ['page_type' =>'terms']) }}">{{ tr('terms') }}</a></div>
      	
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">{{  setting()->get('site_name') }} <i class="mdi mdi-heart-outline text-danger"></i></span>
    
    </div>
</footer>
<!-- partial -->