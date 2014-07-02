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
			<li<?php echo $this->misc->listCActive("admin");?>>
				<?php echo anchor('admin', '<i class="fa fa-dashboard"></i> <span>Dashboard</span>');?>
			</li>
			<li<?php echo $this->misc->listCActive("widgets");?>>
				<?php echo anchor('admin/widgets', '<i class="fa fa-th"></i> <span>เครื่องมือ</span> <small class="badge pull-right bg-green">new</small>');?>
			</li>
			<li class="treeview <?php echo $this->misc->listCActive("report",false,"end");?>">
				<a href="#">
					<i class="fa fa-bar-chart-o"></i>
					<span>รายงาน</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li<?php echo $this->misc->listCActive("examreport");?>><?php echo anchor('admin/examreport', '<i class="fa fa-angle-double-right"></i> การสอบ');?></li>
					<li<?php echo $this->misc->listCActive("scorereport");?>><?php echo anchor('admin/scorereport', '<i class="fa fa-angle-double-right"></i> คะแนนสอบ');?></li>
					<li<?php echo $this->misc->listCActive("logreport");?>><?php echo anchor('admin/logreport', '<i class="fa fa-angle-double-right"></i> ประวัติการใข้งาน');?></li>
				</ul>
			</li>
			<li class="treeview <?php echo $this->misc->listCActiveAry(array("faculty","users","subjects"),false);?>">
				<a href="#">
					<i class="fa fa-laptop"></i>
					<span>ข้อมูลพื้นฐาน</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li<?php echo $this->misc->listCActive("faculty");?>><?php echo anchor('admin/faculty', '<i class="fa fa-angle-double-right"></i> จัดการคณะ');?></li>
					<li<?php echo $this->misc->listCActive("users");?>><?php echo anchor('admin/users', '<i class="fa fa-angle-double-right"></i> จัดการผู้ใช้');?></li>
					<li<?php echo $this->misc->listCActive("subjects");?>><?php echo anchor('admin/subjects', '<i class="fa fa-angle-double-right"></i> จัดการวิชา');?></li>
				</ul>
			</li>
			<li class="treeview <?php echo $this->misc->listCActiveAry(array("examreport","scorereport","logreport"),false);?>">
				<a href="#">
					<i class="fa fa-edit"></i> <span>จัดสอบ</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li<?php echo $this->misc->listCActive("courses");?>><?php echo anchor('admin/courses', '<i class="fa fa-angle-double-right"></i> วิชาที่เปิดสอบ');?></li>
					<li<?php echo $this->misc->listCActive("examswitch");?>><?php echo anchor('admin/examswitch', '<i class="fa fa-angle-double-right"></i> เปิดการสอบ');?></li>
					<li<?php echo $this->misc->listCActive("examreset");?>><?php echo anchor('admin/examreset', '<i class="fa fa-angle-double-right"></i> รีเซตการสอบ');?></li>
			</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
