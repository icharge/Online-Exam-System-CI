<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="fa fa-briefcase"></span> <?php echo $pagetitle;?>
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('teacher', '<i class="fa fa-dashboard"></i> หน้าแรก');?></li>
			<li><?php echo anchor('teacher/courses', 'วิชาที่เปิดสอบ');?></li>
			<li><?php echo anchor('teacher/courses/'.$courseInfo['course_id'], $courseInfo['code'].' '.$courseInfo['name']);?></li>
			<li class="active"><?php echo $partInfo['title'];?></li>
		</ol>
	</section>
	<section class="content">
		<h4 class="page-header">
			<small><?php echo $pagesubtitle;?></small>
		</h4>

		<?php
		$attr = array(
			'name' => 'course',
			'role' => 'form',
			'method' => 'post'
			);
		echo form_open($formlink, $attr);
		?>
		<div class="row">
			<div class="col-md-6 col-lg-6 col-md-offset-3">
<?php
if (isset($msg_error))
{
	echo <<<EOL
<div class="alert alert-danger hidden-xs alert-dismissable" style="min-width: 343px">
	<i class="fa fa-ban"></i>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<b>ผิดพลาด</b> : $msg_error
</div>
<div class="alert alert-danger visible-xs alert-dismissable">
	<i class="fa fa-ban"></i>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<b>ผิดพลาด</b> : $msg_error
</div>
EOL;
	}
?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<div class="col-sm-7"><h3><span class="label label-success">ข้อสอบ</span></h3></div>
					<div class="col-sm-5"><h3><span class="label label-info">ข้อสอบที่มีให้</span></h3> <?php echo anchor('teacher/qwarehouse/viewq/'.$courseInfo['code'],'คลังข้อสอบ <i class="fa fa-external-link"></i>');?></div>
				</div>
				<div class="row">
					<div id="selectedquestions" class="col-lg-7 col-md-7 col-sm-7 questionSortable">
						<?php
							$qno = 1;
							foreach ($questionData as $item) {
								$item['number'] = $qno;
								echo $this->load->view("teacher/question_item_view", $item, true);
								$qno++;
							}
						?>
					</div>
					<div id="availablequestions" class="col-lg-5 col-md-5 col-sm-5 questionSortable">
						<?php
							foreach ($questionDataWh as $item) {
								$item['number'] = null;
								echo $this->load->view("teacher/question_item_view", $item, true);
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
		
<!-- End content -->