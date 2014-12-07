<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="fa fa-bar-chart-o"></span> รายงาน
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('teacher', '<i class="fa fa-dashboard"></i> หน้าแรก');?></li>
			<li class="active">รายงาน</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<h4 class="page-header">
			<!-- <small>รายการวิชาที่เปิดสอบในขณะนี้</small> -->
		</h4>

	<?php
	if ($this->session->flashdata('msg_info')) {
		// echo '
		// <div class="alert alert-success alert-dismissable">
		// <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		// <strong>เรียบร้อย!</strong> '.$this->session->flashdata('msg_info').'</div>';
		echo "
		<script>
		Messenger.options = {
			extraClasses: 'messenger-fixed messenger-on-top',
			theme: 'bootstrap'
		}
		Messenger().post({
			message: '".$this->session->flashdata('msg_info')."',
			type: 'info',
			hideAfter: 7,
			showCloseButton: true
		});
</script>";

}
if ($this->session->flashdata('msg_error')) {
	echo '
	<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>ผิดพลาด!</strong> '.$this->session->flashdata('msg_error').'</div>';
	echo "
	<script>
	Messenger.options = {
		extraClasses: 'messenger-fixed messenger-on-top',
		theme: 'bootstrap'
	}
	Messenger().post({
		message: '".$this->session->flashdata('msg_error')."',
		type: 'danger',
		hideAfter: 7,
		showCloseButton: true
	});
</script>";
}

?>
<div class="row <?php if($this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
	<div class="col-md-12">
		<div class="box box-info nav-tabs-custom">
			<ul class="nav nav-tabs  pull-right">
				<!-- <li class="dropdown pull-right">
					<a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li><?php echo anchor('teacher/reqcourse', 'ร้องขอวิชา');?></li>
					</ul>
				</li> -->
				<li class="pull-left header">
					<i class="glyphicon glyphicon-th"></i> <?=$pagetitle?>
				</li>
			</ul>
			<div class="tab-content">
				<!-- Search Box -->
				<div class="box-body">
					<div class="row">
						<?php
						$attr = array(
							'name' => 'mycourses',
							'class' => 'form-inline searchform',
							'role' => 'search',
							'method' => 'get'
							);
						echo form_open('teacher/reports', $attr); ?>
							<div class="col-sm-6" style="z-index:500;">
								<label for="faculty" class="hidden-xs visible-md-inline-block visible-lg-inline-block">เลือกดูจาก </label>
								<label><?php
									$options = array(
										'all' => 'ทั้งหมด',
										'วิทยาศาสตร์และศิลปศาสตร์' =>
										array(
											'all' => 'วิทยาศาสตร์และศิลปศาสตร์ (ทั้งหมด)',
											'it' => 'เทคโนโลยีสารสนเทศ',
											'at' => 'เทคโนโลยีการเกษตร',
											'is' => 'ระบบสารสนเทศ',
											'ba' => 'บริหารธุรกิจ',
											'lbt' => 'การจัดการโลจิสติกส์และการค้าชายแดน'
										),
										'marine' => 'เทคโนโลยีทางทะเล',
										'อัญมณี' =>
										array(
											'all' => 'อัญมณี (ทั้งหมด)',
											'g1' => 'อัญมณีและเครื่องประดับ',
											'g2' => 'ธุรกิจอัญมณีและเครื่องประดับ',
											'g3' => 'ออกแบบเครื่องประดับ'
										)
									);
									echo form_dropdown('faculty', $options, 'default', 'id="faculty" class="form-control input-sm"');
							?></label>
								<label>
									<?php
									$attr_year = array(
										'2014' => '2557',
										'2013' => '2556',
										'2012' => '2555',
										'2011' => '2554'
										);
									echo form_dropdown('year',
										$attr_year,
										($this->input->get('year')!=''?$this->input->get('year'):'default'),
										'class="form-control input-sm" onchange="submitFrm(document.forms.mycourses)"');
										?>
								</label>
							</div>
							<div class="col-sm-6">
								<div class="col-xs-6 col-sm-6 col-md-6 text-right" style="padding-right: 0;">
									<label>รายการ/หน้า</label>
									<label>
										<?php
										$attr_pp = array(
											'10' => '10',
											'25' => '25',
											'50' => '50',
											'100' => '100'
											);
										if ($this->input->get('perpage')) $perpage = $this->input->get('perpage');
										//else $perpage = '25';
										echo form_dropdown('perpage',
											$attr_pp,
											$perpage,
											'class="form-control input-sm" onchange="submitFrm(document.forms.mycourses)"');
											?>
									</label>
								</div>
								<div class="input-group input-group-sm col-xs-6 col-sm-6 col-lg-6 pull-right">
									<?php
									echo form_input(array(
										'id'=>'searchtxt',
										'name'=>'q',
										'type'=>'text',
										'class'=>'form-control input-sm',
										'value'=>$this->input->get('q'),
										'placeholder'=>'ค้นหา'
										));
									?>
									<span class="input-group-btn">
										<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						<?php echo form_close();?>
					</div>
				</div>
				<!-- /Search box -->
				<div class="box-body no-padding">
					<table class="table table-striped table-hover textvertmid rowclick">
						<thead>
							<tr>
								<th style="width: 55px;">รายงาน</th>
								<th style="width: 60px;">ปีการศึกษา</th>
								<th style="width: 70px;">รหัสวิชา</th>
								<th style="width: 40%;">ชื่อ</th>
								<th style="width: 88px;">ชื่อย่อ</th>
								<th style="width: 80px;" class="">เปิดสอบ (จำนวน)</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if ($courseslist) {
								foreach ($courseslist as $item) {
									$year = $item['year']+543;
									echo <<<html
									<tr>
									<td class="status">
										<div class="btn-group">
											<a href="{$this->misc->getHref('teacher/reports/bypaper')}/{$item['course_id']}" class="btn btn-sm btn-default btn-flat">ชุดข้อสอบ</a>
											<button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="{$this->misc->getHref('teacher/reports/bystudent')}/{$item['course_id']}">บุคคล</a></li>
											</ul>
										</div>
									</td>
									<td>{$year}</td>
									<td>$item[code]</td>
									<td>$item[name]</td>
									<td>$item[shortname]</td>
									<td>$item[examcount]</td>
									</tr>
html;
								}
							} else {
								echo "<tr class='warning'><td colspan='7' class='text-center'>ไม่พบข้อมูล</td></tr>";
							}

						?>
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix">
					<?php echo $pagin;?>
				</div>
			</div>
		</div>
	</div>
	<script>
	function submitFrm(frm) {
		frm.submit();
	}</script>
<!-- End content -->