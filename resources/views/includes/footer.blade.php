<div class="container">
	<div class="row">
		<div class="col-md-12" style="text-align: right;">
			<span class="bfoot">Copyright - Web World Tech </span>
		</div>
	</div>
</div>
<!-- Select2 -->
<script src="{{ asset('public/assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/jquery_validator/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/jquery_validator/additional-methods.min.js') }}"></script>
<script src="{{ asset('public/assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('public/assets/jquery.blockUI.js')}}"></script>
<script src="{{ asset('public/assets/sweet_alert/sweetalert.js') }}"></script>

<script type="text/javascript">
$( function() {
	$('.ardata_table').DataTable();
} );
</script>
@stack('page_js')
</body>
</html>
