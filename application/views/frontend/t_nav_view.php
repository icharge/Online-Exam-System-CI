	<!-- Begin navbar -->
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
	echo anchor('main', 'Online Examination', 'class="navbar-brand"');
?>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					
					
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><?php echo anchor('main', 'หน้าแรก');?></li>
					<li><?php echo anchor('auth/login', 'เข้าสู่ระบบ');?></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- End navbar -->