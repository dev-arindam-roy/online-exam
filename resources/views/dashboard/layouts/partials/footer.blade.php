
<!-- jQuery 3 -->
<script src="{{ asset('public/assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('public/assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('public/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/assets/bower_components/fastclick/lib/fastclick.js') }}"></script>

<script src="{{ asset('public/assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('public/assets/jquery.blockUI.js')}}"></script>
<script src="{{ asset('public/assets/sweet_alert/sweetalert.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('public/assets/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!--script src="{{ asset('public/assets/dist/js/demo.js') }}"></script-->

<script type="text/javascript" src="{{ asset('public/assets/jquery_validator/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/jquery_validator/additional-methods.min.js') }}"></script>
<!--script type="text/javascript" src="{{ asset('public/assets/arindam_nav.js') }}"></script-->


<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();
    $('.select2').select2({
    	//width: '100%'
    });
    $('.ar-hide').fadeOut(6000);
    $('[data-toggle="tooltip"]').tooltip(); 
    $("body").on('keypress', '.onlyNumber', function(evt){
    	var charCode = (evt.which) ? evt.which : event.keyCode
    	if (charCode > 31 && (charCode < 48 || charCode > 57))
      		return false;
    	return true;
	});  
  });
</script>
@stack('page_js')
</body>
</html>
