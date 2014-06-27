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
			<li class="active">
				<a href="index.html">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li>
				<a href="pages/widgets.html">
					<i class="fa fa-th"></i> <span>เครื่องมือ</span> <small class="badge pull-right bg-green">new</small>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-bar-chart-o"></i>
					<span>รายงาน</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> การสอบ</a></li>
					<li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> คะแนนสอบ</a></li>
					<li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> ประวัติการใข้งาน</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-laptop"></i>
					<span>ข้อมูลพื้นฐาน</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> จัดการคณะ</a></li>
					<li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> จัดการผู้ใช้</a></li>
					<li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> จัดการวิชา</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-edit"></i> <span>จัดสอบ</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> วิชาที่เปิดสอบ</a></li>
					<li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> เปิดการสอบ</a></li>
					<li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> รีเซตการสอบ</a></li>                                
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
<!-- <div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li<?php echo $this->misc->listCActive("admin"); ?>><?php echo anchor('admin', '<span class="glyphicon glyphicon-dashboard"></span> ทั่วไป');?></li>
		<li<?php echo $this->misc->listCActive("examreport"); ?>><?php echo anchor('admin/examreport', '<span class="glyphicon glyphicon-dashboard"></span> รายงานการสอบ');?></li>
		<li<?php echo $this->misc->listCActive("scorereport"); ?>><?php echo anchor('admin/scorereport', '<span class="glyphicon glyphicon-book"></span> รายงานผลคะแนน');?></li>
		<li<?php echo $this->misc->listCActive("log"); ?>><?php echo anchor('admin/log', '<span class="glyphicon glyphicon-list-alt"></span> ประวัติการใช้งาน');?></li>
	</ul>
	<ul class="nav nav-sidebar">
		<li<?php echo $this->misc->listCActive("faculty"); ?>><?php echo anchor('admin/faculty', '<div class="glyphicon glyphicon-list-alt"></div> จัดการคณะ');?></li>
		<li<?php echo $this->misc->listCActive("users"); ?>><?php echo anchor('admin/users', '<span class="glyphicon glyphicon-user"></span> จัดการผู้ใช้');?></li>
		<li<?php echo $this->misc->listCActive("subjects"); ?>><?php echo anchor('admin/subjects', '<div class="glyphicon glyphicon-book"></div> จัดการวิชา');?></li>
		<li<?php echo $this->misc->listCActive("courses"); ?>><?php echo anchor('admin/courses', '<div class="glyphicon glyphicon-list-alt"></div> วิชาที่เปิด');?></li>
		<li<?php echo $this->misc->listCActive("examswitch"); ?>><?php echo anchor('admin/examswitch', '<div class="glyphicon glyphicon-list-alt"></div> เปิดการสอบ');?></li>
		<li<?php echo $this->misc->listCActive("examreset"); ?>><?php echo anchor('admin/examreset', '<div class="glyphicon glyphicon-list-alt"></div> รีเซตการสอบ');?></li>
	</ul>
</div> -->