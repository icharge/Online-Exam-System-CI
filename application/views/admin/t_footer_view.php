		</div><!-- ./wrapper -->
	<!-- End body -->

	<!-- Begin Footer -->

	<!-- jQuery 2.0.2 -->
	<script src="vendor/js/jquery.min.js"></script>
	<!-- jQuery UI 1.10.3 -->
	<script src="vendor/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
	<!-- Bootstrap -->
	<script src="vendor/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- Morris.js charts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="vendor/js/plugins/morris/morris.min.js" type="text/javascript"></script>
	<!-- Sparkline -->
	<script src="vendor/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
	<!-- jvectormap -->
	<script src="vendor/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
	<script src="vendor/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
	<!-- fullCalendar -->
	<script src="vendor/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
	<!-- jQuery Knob Chart -->
	<script src="vendor/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
	<!-- date-picker -->
	<script src="vendor/js/bootstrap-datepicker.js"></script>
	<!-- daterangepicker -->
	<script src="vendor/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="vendor/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
	<!-- iCheck -->
	<script src="vendor/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<!-- AdminLTE App -->
	<script src="vendor/js/AdminLTE/app.js" type="text/javascript"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<?php echo ($this->misc->getClassName()=="admin"?'<script src="vendor/js/AdminLTE/dashboard.js" type="text/javascript"></script>':'');?>
	<!-- AdminLTE for demo purposes -->
	<!-- <script src="vendor/js/AdminLTE/demo.js" type="text/javascript"></script> -->
	<?php
		if (defined('useEditor')) echo '
	<!-- CK Editor -->
	<script src="vendor/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>';
	?>
	<!-- TR Href -->
	<script>
	$(function() {
		$('body').on('mousedown', 'tr[href]', function(e){
			var click = e.which;
			var url = $(this).attr('href');
			if(url){
				if(click == 1){
					window.location.href = url;
				}
				else if(click == 2){
					window.open(url, '_blank');
					window.focus();
				}
				return true;
			}
		});

		$('#datepicker').datepicker();

		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
				checkboxClass: 'icheckbox_minimal',
				radioClass: 'iradio_minimal'
		});
		//Red color scheme for iCheck
		$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
				checkboxClass: 'icheckbox_minimal-red',
				radioClass: 'iradio_minimal-red'
		});
		//Flat red color scheme for iCheck
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
				checkboxClass: 'icheckbox_flat-red',
				radioClass: 'iradio_flat-red'
		});
		<?php if(defined('useEditor')) echo "CKEDITOR.replace('editor');";?>
	});
	</script>
	<!-- End Footer -->
</body>
</html>