<?php
$attrLabel = array(
	'class' => 'col-sm-3 control-label'
);?>
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
			<li><?php echo anchor('admin/users', 'จัดการผู้ใช้');?></li>
			<li class="active"><?php echo $pagetitle;?></li>
		</ol>
	</section>
	<section class="content">
		<h4 class="page-header">
			<small></small>
		</h4>

		<?php
		if (isset($msg_error)) {
			// echo '
			// <div class="alert alert-danger alert-dismissable">
			// <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			// <strong>ผิดพลาด!</strong> '.$msg_error.'</div>';
			echo "
			<script>
			Messenger.options = {
				extraClasses: 'messenger-fixed messenger-on-top',
				theme: 'bootstrap'
			}
			Messenger().post({
				message: '".$msg_error."',
				type: 'danger',
				hideAfter: 7,
				showCloseButton: true
			});
			</script>";
		}
		$attr = array(
			'role' => 'form',
			'method' => 'post'
			);
		echo form_open($formlink, $attr);
		?>
		<div class="row">
			<div class="col-md-5 col-lg-6 col-lg-offset-3">
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
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-md-6 col-lg-4 col-lg-offset-2">
				<!-- Begin LoginInfo -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">
							การระบุตัวตน
						</h3>
					</div>
					<div class="box-body">
						<div class="form-group<?php if(form_error('username')) echo ' has-error';?>">
							<?php
							echo form_label('ชื่อผู้ใช้ <span class="text-danger">*</span>', 'username');
							echo form_input(array(
								'id'=>'username',
								'name'=>'username',
								'value'=>$userData['username'],
								'type'=>'text',
								'class'=>'form-control',
								'placeholder'=>'ชื่อผู้ใช้'));
							echo form_error('username', '<span class="label label-danger">', '</span>');
							?>
						</div>
						<div class="form-group<?php if(form_error('password')) echo ' has-error';?>">
							<?php 
							echo form_label('รหัสผ่าน <span class="text-danger">*</span>', 'password');
							echo form_input(array(
								'id'=>'password',
								'name'=>'password',
								'type'=>'password',
								'class'=>'form-control',
								'placeholder'=>'รหัสผ่าน'));
							echo form_error('password', '<span class="label label-danger">', '</span>');
							?>
						</div>
						<div class="form-group<?php if(form_error('passwordconfirm')) echo ' has-error';?>">
							<?php 
							echo form_label('ยืนยัน <span class="text-danger">*</span>', 'passwordconfirm');
							echo form_input(array(
								'id'=>'passwordconfirm',
								'name'=>'passwordconfirm',
								'type'=>'password',
								'class'=>'form-control',
								'placeholder'=>'รหัสผ่านอีกครั้ง'));
							echo form_error('passwordconfirm', '<span class="label label-danger">', '</span>');
							?>
						</div>
					</div>
				</div>
			</div>
		<!-- End LoginInfo -->

		<!-- Begin UserInfo -->
			<div class="col-sm-6 col-md-6 col-lg-4">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">
							ข้อมูลส่วนตัว
						</h3>
					</div>
					<div class="box-body">
						<div class="form-group<?php if(form_error('fname')) echo ' has-error';?>">
							<?php 
							echo form_label('ชื่อ <span class="text-danger">*</span>', 'fname');
							echo form_input(array(
								'id'=>'fname',
								'name'=>'fname',
								'value'=>$userData['name'],
								'type'=>'text',
								'class'=>'form-control',
								'placeholder'=>'ชื่อ'));
							echo form_error('fname', '<span class="label label-danger">', '</span>');
							?>
						</div>
						<div class="form-group<?php if(form_error('surname')) echo ' has-error';?>">
							<?php 
							echo form_label('นามสกุล <span class="text-danger">*</span>', 'surname');
							echo form_input(array(
								'id'=>'surname',
								'name'=>'surname',
								'value'=>$userData['lname'],
								'type'=>'text',
								'class'=>'form-control',
								'placeholder'=>'นามสกุล'));
							echo form_error('surname', '<span class="label label-danger">', '</span>');
							?>
						</div>
						<div class="form-group<?php if(form_error('email')) echo ' has-error';?>">
							<?php 
							echo form_label('อีเมล์', 'email');
							echo form_input(array(
								'id'=>'email',
								'name'=>'email',
								'value'=>(isset($userData['email'])?$userData['email']:''),
								'type'=>'text',
								'class'=>'form-control',
								'placeholder'=>'อีเมล์'));
							echo form_error('email', '<span class="label label-danger">', '</span>');
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row row-centered">
				<div class="col-sm-12">
					<?php
					echo form_submit('submit', 'เพิ่มผู้ใช้', 'class="btn btn-primary"');
					?>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
<!-- End content -->