<!-- plugins:js -->
<script src="{{ asset('user-assets/node_modules/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
 <script src="{{ asset('user-assets/node_modules/jquery-bar-rating/jquery.barrating.min.js') }}"></script>

<script src="{{ asset('user-assets/node_modules/moment/moment.min.js') }}"></script>

<script src="{{ asset('user-assets/node_modules/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('user-assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('user-assets/node_modules/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>

<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{ asset('user-assets/js/off-canvas.js') }}"></script>

<script src="{{ asset('user-assets/js/hoverable-collapse.js') }}"></script>

<script src="{{ asset('user-assets/js/template.js') }}"></script>

<script src="{{ asset('user-assets/js/settings.js') }}"></script>

<script src="{{ asset('user-assets/js/todolist.js') }}"></script>
<!-- endinject -->

<!-- Custom js for this page-->
<script src="{{ asset('user-assets/js/dashboard.js') }}"></script>

<script src="{{ asset('user-assets/js/chart.js') }}"></script>

<script src="{{ asset('user-assets/node_modules/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>

<script src="{{ asset('user-assets/js/formpickers.js') }}"></script>

<script src="{{ asset('user-assets/js/form-addons.js') }}"></script>

<script type="text/javascript" src="{{asset('user-assets/js/jquery.star-rating-svg.min.js')}}"> </script>

<!-- End custom js for this page-->

<script type="text/javascript">

    @if(isset($page)) 
        $("#{{$page}}").addClass("active");
    @endif
    
</script>

{{-- Preview the Image while update --}}
<script type="text/javascript">
		
  function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#preview')
	                .attr('src', e.target.result);
	        };

	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>
