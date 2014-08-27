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
			<li><?php echo anchor('teacher/qwarehouse', 'คลังข้อสอบ');?></li>
			<li class="active"><?php echo $pagetitle;?></li>
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
			<div class="col-md-8 col-md-offset-2">

				<!-- Begin box -->
				<div class="box nav-tabs-custom" style="border: none;">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#basic" data-toggle="tab">พื้นฐาน</a></li>
						<li><a href="#chapter" data-toggle="tab">Chapter</a></li>
						<li><a href="#questions" data-toggle="tab">โจทย์คำถาม</a></li>
					</ul>
					<!-- Tab Basic -->
					<div class="tab-content">
						<div class="box-body tab-pane active" id="basic">
							<div class="form-group<?php if(form_error('subjectid')) echo ' has-error';?>">
								<?php
								echo form_label('วิชา', 'subjectid');
								echo "<div id=\"subjectcodename\">$subjectInfo[code] - $subjectInfo[name]</div>";
								?>
							</div>
							<div class="form-group<?php if(form_error('subjectid')) echo ' has-error';?>">
								<?php
								echo form_label('ชื่อย่อวิชา', 'ชื่อย่อวิชา');
								echo "<div id=\"subjectshortname\">$subjectInfo[shortname]</div>";
								?>
							</div>
							<div class="form-group<?php if(form_error('description')) echo ' has-error';?>">
								<label>คำอธิบายวิชา</label>
								<div id="subjectDesc" class="text-justify">
									<?php echo (isset($subjectInfo['description'])?$subjectInfo['description']:'');?>
								</div>
							</div>
						</div>
						<!-- Tab Chapter -->
						<div class="box-body tab-pane" id="chapter">
							<div class="row">
								<div class="col-md-12 text-center">
									<h3 class="">บท/ตอน (Chapter)</h3>
								</div>
								<ul>
									<?php
										foreach ($chapterList as $item) {
											echo "<li>$item[name]</li>";
										}
									?>
								</ul>

							</div>
						</div>
						<!-- Students tab -->
						<div class="box-body tab-pane" id="questions">
							<div class="row">
								<div class="col-md-12 text-center">
									<h3 class="">โจทย์คำถาม</h3>
								</div>


							</div>
						</div>
						<div class="box-body tab-pane" id="papers">
							<h3>ชุดข้อสอบ</h3>
						</div>


					</div>
					<div class="box-footer text-right">
					<?php
					echo form_submit('submit', $this->courses->btnSaveText(), 'class="btn btn-primary"');
					?>
					</div>
				</div>
				<!-- End BasicInfo -->
			</div>
		</div>
		<?php form_close(); ?>
<!-- End content -->