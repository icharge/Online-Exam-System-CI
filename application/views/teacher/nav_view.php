	<!-- Begin navbar -->
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Teacher Mode</a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="#">แผงควบคุม</a></li>
					<li><a href="#">ช่วยเหลือ</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php 
						echo $this->session->userdata('fname'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><?php echo anchor('auth/logout', 'ออกจากระบบ'); ?></li>
						</ul>
					</li>
				</ul>				
				<form class="navbar-form navbar-right">
					<input type="text" class="form-control col-lg-8" placeholder="Search">
				</form>
			</div>
		</div>
	</div>
	<!-- End navbar -->