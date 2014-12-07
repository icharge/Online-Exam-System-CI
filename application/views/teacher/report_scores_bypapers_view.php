<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="fa fa-bar-chart-o"></span> รายงาน <?php echo "$courseInfo[code] $courseInfo[name]";?><small></small>
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
					<table class="table table-striped table-hover rowclick">
						<thead>
							<tr>
								<th>ชุดข้อสอบ</th>
								<th>ลงสอบ</th>
								<th>เข้าสอบ</th>
								<th>ค่าเฉลี่ย</th>
								<th>ต่ำสุด</th>
								<th>สูงสุด</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if (($reportRows)) {
								foreach ($reportRows as $item) {
									$year = $item['year']+543;
									list($startdate, $starttime) = explode(' ', $item['starttime']);
									$item['startdate'] = date('d/m/Y',strtotime($startdate));
									$item['starttime'] = date('h:i',strtotime($starttime));

									list($enddate, $endtime) = explode(' ', $item['endtime']);
									$item['enddate'] = date('d/m/Y',strtotime($enddate));
									$item['endtime'] = date('h:i',strtotime($endtime));

									$daterange = $this->misc->getFullDateTH($item['startdate'])." $item[starttime] - ".($item['startdate']!=$item['enddate']?$this->misc->getFullDateTH($item['enddate']):'').
									" $item[endtime]";
									echo <<<html
									<tr href="{$this->misc->getHref('teacher/reports/bypaper')}/{$item['paper_id']}">
									<td>{$item['papername']}<br>{$daterange}</td>
									<td>{$item['enrollcount']}</td>
									<td>{$item['testedcount']}</td>
									<td>{$item['average']}</td>
									<td>{$item['minimum']}</td>
									<td>{$item['maximum']}</td>
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
					<?php //echo $pagin;?>
				</div>
			</div>
		</div>
	</div>
	<script>
	function submitFrm(frm) {
		frm.submit();
	}</script>
<!-- End content -->