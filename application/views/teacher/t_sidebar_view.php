<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="img/avatar3.png" class="img-circle" alt="User Image" />
			</div>
			<div class="pull-left info">
				<p><?php echo $this->session->userdata('fullname');?></p>

				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<!-- search form -->
		<form action="" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search..."/>
				<span class="input-group-btn">
					<button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li<?php echo $this->misc->listCActive("teacher");?>>
				<?php echo anchor('teacher', '<i class="fa fa-dashboard"></i> <span>Dashboard</span>');?>
			</li>
			<li class="treeview <?php echo $this->misc->listCActiveAry(array("mycourses","courses","reqcourse"),false);?>">
				<a href="#">
					<i class="fa fa-laptop"></i>
					<span>การจัดการสอบ</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li<?php echo $this->misc->listCActive("mycourses");?>><?php echo anchor('teacher/mycourses', '<i class="fa fa-angle-double-right"></i> วิชาของฉัน');?></li>
					<li<?php echo $this->misc->listCActive("courses");?>><?php echo anchor('teacher/courses', '<i class="fa fa-angle-double-right"></i> วิชาที่เปิดสอบ');?></li>
					<li<?php echo $this->misc->listCActive("reqcourse");?>><?php echo anchor('teacher/reqcourse', '<i class="fa fa-angle-double-right"></i> ร้องขอวิชาใหม่');?></li>
				</ul>
			</li>
			<li class="treeview <?php echo $this->misc->listCActiveAry(array("examswitch","examreset"),false);?>">
				<a href="#">
					<i class="fa fa-edit"></i> <span>คลังข้อสอบ</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li<?php echo $this->misc->listCActive("courmmses");?>><?php echo anchor('teacher/courses', '<i class="fa fa-angle-double-right"></i> ---');?></li>
					<li<?php echo $this->misc->listCActive("examswitch");?>><?php echo anchor('teacher/examswitch', '<i class="fa fa-angle-double-right"></i> ---');?></li>
					<li<?php echo $this->misc->listCActive("examreset");?>><?php echo anchor('teacher/examreset', '<i class="fa fa-angle-double-right"></i> ---');?></li>
			</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
