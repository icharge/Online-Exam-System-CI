<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			แผงควบคุม
			<small>Control panel</small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> หน้าแรก');?></li>
			<li class="active">แผงควบคุม</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>
							<?=$coursecount?> วิชา
						</h3>
						<p>
							วิชาที่เปิดทั้งหมด
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-bag"></i>
					</div>
					<?php echo anchor('admin/courses', 'เพิ่มเติม <i class="fa fa-arrow-circle-right"></i>', 'class="small-box-footer"');?>
				</div>
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3>
							<?=$qcount?> ข้อ
						</h3>
						<p>
							โจทย์ข้อสอบทั้งหมด
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<?php echo anchor('teacher/qwarehouse', 'เพิ่มเติม <i class="fa fa-arrow-circle-right"></i>', 'class="small-box-footer"');?>
				</div>
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>
							<?=$usercount?> คน
						</h3>
						<p>
							ผู้ใช้ทั้งหมด
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<?php echo anchor('admin/users', 'เพิ่มเติม <i class="fa fa-arrow-circle-right"></i>', 'class="small-box-footer"');?>
				</div>
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h3>
							<?=$testedcount?> ครั้ง
						</h3>
						<p>
							การสอบทั้งหมด
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
					<?php echo anchor('teacher/reports', 'เพิ่มเติม <i class="fa fa-arrow-circle-right"></i>', 'class="small-box-footer"');?>
				</div>
			</div><!-- ./col -->
		</div>
	</section><!-- /.content -->
</aside><!-- /.right-side -->

<!-- End content -->