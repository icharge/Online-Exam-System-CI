<?php
$attrLabel = array(
	'class' => 'col-sm-3 control-label'
	);

	?>
	<!-- Begin content -->
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', 'หน้าแรก');?></li>
			<li><?php echo anchor('admin/users', 'จัดการผู้ใช้');?></li>
			<li class="active">ข้อมูลผู้ใช้ <?php echo "$userData[name] $userData[lname] ($userData[role])";?></li>
		</ol>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main animate-fade-up">
		<div class="page-header">
			<h1>รายละเอียดผู้ใช้ <small></small></h1>
		</div>
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
			'class' => 'form-horizontal',
			'role' => 'form',
			'method' => 'post'
			);
		echo form_open('admin/users/adduser/admin', $attr);
		?>
		<div class="row row-centered">
			<div class="col-md-8 col-centered">
				
				<!-- Begin LoginInfo -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-th-list"></span>
							&nbsp;&nbsp;การเข้าใช้งาน
						</h3>
					</div>
					<div class="panel-body">
						<div class="form-group<?php if(form_error('username')) echo ' has-error';?>">
							<?php
							echo form_label('ชื่อผู้ใช้ <span class="text-danger">*</span>', 'username', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
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
						</div>
						<div class="form-group<?php if(form_error('password')) echo ' has-error';?>">
							<?php 
							echo form_label('รหัสผ่าน <span class="text-danger">*</span>', 'password', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
								echo form_input(array(
									'id'=>'password',
									'name'=>'password',
									'type'=>'password',
									'class'=>'form-control',
									'placeholder'=>'รหัสผ่าน'));
								echo form_error('password', '<span class="label label-danger">', '</span>');
								?>
							</div>
						</div>
						<div class="form-group<?php if(form_error('passwordconfirm')) echo ' has-error';?>">
							<?php 
							echo form_label('ยืนยัน <span class="text-danger">*</span>', 'passwordconfirm', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
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
			</div>
		</div>
		<!-- End LoginInfo -->

		<!-- Begin UserInfo -->
		<div class="row row-centered">
			<div class="col-md-8 col-centered">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-th-list"></span>
							&nbsp;&nbsp;ข้อมูลส่วนตัว
						</h3>
					</div>
					<div class="panel-body">
						<div class="form-group<?php if(form_error('fname')) echo ' has-error';?>">
							<?php 
							echo form_label('ชื่อ <span class="text-danger">*</span>', 'fname', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
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
						</div>
						<div class="form-group<?php if(form_error('surname')) echo ' has-error';?>">
							<?php 
							echo form_label('นามสกุล <span class="text-danger">*</span>', 'surname', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
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
						</div>
						<div class="form-group<?php if(form_error('email')) echo ' has-error';?>">
							<?php 
							echo form_label('อีเมล์', 'email', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
								echo form_input(array(
									'id'=>'email',
									'name'=>'email',
									'value'=>$userData['email'],
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
		</div>
		<div class="form-group">
			<div class="row row-centered">
				<div class="col-sm-12">
					<?php
					echo form_submit('submit', 'ปรับปรุง', 'class="btn btn-primary"');
					?>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
<!-- End content -->