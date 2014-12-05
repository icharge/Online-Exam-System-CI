	<!-- footer begin -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="inner">
						&copy; Copyiright 2014 - Ecourse by Aveothemes
					</div>
				</div>
				<div class="col-md-6">
					<div class="inner">
						<nav>
							<ul>
								<li><a href="index.html">หน้าแรก</a></li>
								<li><a href="#">วิชา</a>	</li>
								<li><a href="#">ข่าวสาร</a></li>
								<li><a href="contact.html">ติดต่อ</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>

	</footer>
	<!-- footer close -->

	<!-- LOAD JS FILES -->
	<script src="assets-student/js/jquery.min.js"></script>
	<script src="assets-student/js/bootstrap.min.js"></script>
	<script src="assets-student/js/jquery.isotope.min.js"></script>
	<script src="assets-student/js/jquery.prettyPhoto.js"></script>
	<script src="assets-student/js/easing.js"></script>
	<script src="assets-student/js/jquery.lazyload.js"></script>
	<script src="assets-student/js/jquery.ui.totop.js"></script>
	<script src="assets-student/js/selectnav.js"></script>
	<script src="assets-student/js/ender.js"></script>
	<script src="assets-student/js/custom.js"></script>
	<script src="assets-student/js/responsiveslides.min.js"></script>
	<!-- iCheck -->
	<script src="vendor/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<script>
		$(function() {
			//Red color scheme for iCheck
			$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
					checkboxClass: 'icheckbox_minimal-red',
					radioClass: 'iradio_minimal-red'
			});

			<?php echo $this->load->view('exampaper/script_view', null, true); ?>

			// Course-item link
			$('.course-list').delegate('.course-item', 'mouseup', function(e) {
				var click = e.which;
				var url = $(this).attr('data-href');
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
		});
	</script>
</body>
</html>
