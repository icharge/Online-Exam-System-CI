		</div><!-- ./wrapper -->
	<!-- End body -->

	<!-- Begin Footer -->

	<!-- jQuery 2.0.2 -->
	<script src="vendor/js/jquery.min.js"></script>
	<!-- jQuery UI 1.1 -->
	<script src="vendor/js/jquery-ui.min.js" type="text/javascript"></script>
	<!-- jQuery ScrollTo -->
	<script src="vendor/js/jquery.scrollto.min.js" type="text/javascript"></script>
	<!-- ScrollToFixed -->
	<script src="vendor/js/scrolltofixed.min.js" type="text/javascript"></script>
	<!-- Bootstrap -->
	<script src="vendor/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- Bootstrap select -->
	<script src="vendor/js/bootstrap-select.min.js" type="text/javascript"></script>
	<!-- Bootstrap editable -->
	<script src="vendor/js/bootstrap-editable.min.js" type="text/javascript"></script>
	<!-- Bootstrap Datepicker -->
	<script src="vendor/js/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="vendor/js/bootstrap-datepicker.th.js" type="text/javascript"></script>
	<!-- Bootstrap Timepicker -->
	<script src="vendor/js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
	<!-- InputMask -->
	<script src="vendor/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
	<script src="vendor/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
	<script src="vendor/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
	<!-- Morris.js charts -->
	<script src="vendor/js/raphael-min.js"></script>
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
<!-- <script src="vendor/js/bootstrap-datepicker.js"></script>
	<script src="vendor/js/bootstrap-datepicker-thai.js"></script>
	<script src="vendor/js/bootstrap-datepicker.th.js"></script> -->
	<!-- daterangepicker -->
	<script src="vendor/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="vendor/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
	<!-- iCheck -->
	<script src="vendor/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<!-- jBox -->
	<script src="vendor/js/jBox.js"></script>
	<!-- AdminLTE App -->
	<script src="vendor/js/AdminLTE/app.js" type="text/javascript"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<?php echo ($this->misc->getClassName()=="admin"?'<script src="vendor/js/AdminLTE/dashboard.js" type="text/javascript"></script>':'');?>
	<!-- AdminLTE for demo purposes -->
	<!-- <script src="vendor/js/AdminLTE/demo.js" type="text/javascript"></script> -->

	<!-- PickList -->
	<!-- <script src="vendor/js/jquery.ui.widget.js" type="text/javascript"></script> -->
	<script src="vendor/js/jquery-picklist.js" type="text/javascript"></script>


	<?php
		if (defined('useEditor')) echo '
	<!-- CK Editor -->
	<script src="vendor/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>';
	?>
	<!-- TR Href -->
	<script>
	$(function() {
		var doAnim = function(elem, x) {
			$(elem).removeClass(x + ' animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
				$(elem).removeClass(x + ' animated');
			});
		};
		
		$('body').delegate('tr[href]', 'mouseup', function(e){
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

		var hashwithtabs = function() {
			if(window.location.hash) {
				var hash = window.location.hash; //window.location.hash.substring(1); //Puts hash in variable, and removes the # character
				$('[href="'+hash+'"][data-toggle="tab"]').trigger('click');
			}
		};
		hashwithtabs();

		$(window).on('hashchange', function() {
			hashwithtabs();
		});

		$('select.input-sm').selectpicker({
			style: 'btn-default btn-sm'
		});

		$('select.input-lg').selectpicker({
			style: 'btn-default btn-lg'
		});

		$('select:not(.def)').selectpicker();

		//$('#datepicker').datepicker();

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

		$('.jtooltip').jBox('Tooltip', {theme: 'TooltipDark'});

		<?php
			if(isset($additionScript))
			{
				echo "// Addition Scripts.\n";
				foreach ($additionScript as $item) {
					echo $item."\n";
				}
			}
		?>
	});
	</script>
	<!-- End Footer -->
</body>
</html>