<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="fa fa-plus-circle"></span> <?php echo $pagetitle;?>
			<small><?php echo $pagesubtitle;?></small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> หน้าแรก');?></li>
			<li><?php echo anchor('admin/subjects', 'จัดการวิชาในระบบ');?></li>
			<li class="active"><?php echo $pagetitle;?></li>
		</ol>
	</section>
	<section class="content">
		<h4 class="page-header">
			<small></small>
		</h4>

		<?php
		$attr = array(
			'role' => 'form',
			'method' => 'post'
			);
		echo form_open($formlink, $attr);
		?>
		<div class="row">
			<div class="col-md-5 col-lg-6 col-lg-offset-3">
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
	else
	{
		echo <<<EOL
<div class="alert alert-info hidden-xs" style="min-width: 343px">
	<i class="fa fa-info"></i>
	<b>คำแนะนำ :</b> <b>เครื่องหมาย</b> <span class="text-danger">*</span>
	จำเป็นต้องกรอกข้อมูล
</div>
<div class="alert alert-info visible-xs">
	<i class="fa fa-info"></i>
	<b>คำแนะนำ :</b> <b>เครื่องหมาย</b> <span class="text-danger">*</span>
	จำเป็นต้องกรอกข้อมูล
</div>
EOL;
	}
?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				
				<!-- Begin BasicInfo -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">
							ข้อมูลพื้นฐาน
						</h3>
					</div>
					<div class="box-body">
						<div class="form-group<?php if(form_error('code')) echo ' has-error';?>">
							<?php 
							echo form_label('รหัสวิชา <span class="text-danger">*</span>', 'code');
							echo form_input(array(
								'id'=>'code',
								'name'=>'code',
								'value'=>$subjectInfo['code'],
								'type'=>'text',
								'class'=>'form-control',
								'placeholder'=>'รหัสวิชา'));
							echo form_error('code', '<span class="label label-danger">', '</span>');
							?>
						</div>
						<div class="form-group<?php if(form_error('name')) echo ' has-error';?>">
							<?php 
							echo form_label('ชื่อวิชา <span class="text-danger">*</span>', 'name');
							echo form_input(array(
								'id'=>'name',
								'name'=>'name',
								'value'=>$subjectInfo['name'],
								'type'=>'text',
								'class'=>'form-control',
								'placeholder'=>'ชื่อวิชา'));
							echo form_error('name', '<span class="label label-danger">', '</span>');
							?>
						</div>
						<div class="form-group<?php if(form_error('shortname')) echo ' has-error';?>">
							<?php 
							echo form_label('ชื่อย่อวิชา <span class="text-danger">*</span>', 'ชื่อย่อวิชา');
							echo form_input(array(
								'id'=>'shortname',
								'name'=>'shortname',
								'value'=>$subjectInfo['shortname'],
								'type'=>'text',
								'class'=>'form-control',
								'placeholder'=>'ชื่อย่อวิชา'));
							echo form_error('shortname', '<span class="label label-danger">', '</span>');
							?>
						</div>
						<div class="form-group<?php if(form_error('description')) echo ' has-error';?>">
							<?php 
							echo form_label('คำอธิบายวิชา', 'ชื่อย่อวิชา');
							echo form_textarea('description', $subjectInfo['description'], 'id="editor" class="form-control"');
							// echo form_error('description', '<span class="label label-danger">', '</span>');
							define('useEditor', true);
							?>
						</div>
					</div>
				</div>
				<!-- End BasicInfo -->
			</div>
		</div>
		

		<div class="form-group">
			<div class="row row-centered">
				<div class="col-sm-12">
					<?php
					echo form_submit('submit', $this->subjects->btnSaveText(), 'class="btn btn-primary"');
					?>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
<!-- End content -->