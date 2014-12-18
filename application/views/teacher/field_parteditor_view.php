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
			<li><?php echo anchor('teacher/courses/view/'.$courseInfo['course_id'], $courseInfo['code'].' '.$courseInfo['name']);?></li>
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
					<div class="col-sm-5"><h3><span class="label label-info">ข้อสอบที่มีให้</span></h3></div>
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
					<div class="wrapping-question col-lg-5 col-md-5 col-sm-5 ">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">เลือกบท</h3>
								<div class="box-tools pull-right">
									<?php 
									echo anchor('teacher/qwarehouse/viewq/'.$courseInfo['code'],
									'ไปคลังข้อสอบ <i class="fa fa-external-link"></i>');?>
								</div>
							</div>
							<div class="box-body"><?php
									$options = $this->parteditor->buildChapterOptions($courseInfo['subject_id']);
									echo form_dropdown('chapterselect', $options, 'default', 
										'id="chapterselect" class="form-control"');
								?>
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default active">
										<input type="radio" class="noicheck" name="questiontype" value="all" autocomplete="off" checked><i class="fa fa-asterisk"></i> ทุกแบบ
									</label>
									<label class="btn btn-default">
										<input type="radio" class="noicheck" name="questiontype" value="choice" autocomplete="off"><i class="fa fa-list-ul"></i> ปรนัย
									</label>
									<label class="btn btn-default">
										<input type="radio" class="noicheck" name="questiontype" value="boolean" autocomplete="off"><i class="fa fa-check"></i> ถูก / ผิด
									</label>
									<label class="btn btn-default">
										<input type="radio" class="noicheck" name="questiontype" value="numeric" autocomplete="off"><i class="fa fa-superscript"></i> ตอบตัวเลข
									</label>
								</div>
							</div>
						</div>
						<div id="availablequestions" class="questionSortable">
							<?php
								if (isset($questionDataWh))
								{
									foreach ($questionDataWh as $item) {
										$item['number'] = null;
										echo $this->load->view("teacher/question_item_view", $item, true);
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
		
<!-- End content -->