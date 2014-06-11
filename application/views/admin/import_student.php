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
			<li class="active">นำเข้านักเรียน</li>
		</ol>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main animate-fade-up">
		<div class="page-header">
			<h1>นำเข้านักเรียน <small>จากไฟล์</small></h1>
		</div>
		<!-- <div class="row row-centered">
			<div class="col-md-6 col-centered alert alert-info">
				* จำเป็นต้องกรอก
			</div>
		</div> -->
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
		//echo form_open('importstudent'.$subjectInfo['code'], $attr);
		?>
	<form method="post" enctype="multipart/form-data">
		<div class="row row-centered">
			<div class="col-md-8 col-centered">
				
				<!-- Begin BasicInfo -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-send"></span>
							&nbsp;&nbsp;การอัปโหลด
						</h3>
					</div>
					<div class="panel-body">
						<!-- <div class="form-group">
							<?php 
							echo form_label('ID', 'subject_id', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
								echo form_input(array(
									'id'=>'subject_id',
									'name'=>'subject_id',
									'type'=>'text',
									'class'=>'form-control',
									'placeholder'=>'ID',
									'readonly'=>'readonly'));
								echo form_error('subject_id', '<span class="label label-danger">', '</span>');
								?>
							</div>
						</div> -->
						<div class="form-group<?php if(form_error('file')) echo ' has-error';?>">
							<?php 
							echo form_label('ไฟล์ Excel (.xlsx) <span class="text-danger">*</span>', 'file', $attrLabel);
							?>
							<div class="col-sm-8">
								<input type="file" name="file">
								<?php
								echo form_error('code', '<span class="label label-danger">', '</span>');
								?>
							</div>
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
					echo form_submit('submit', 'นำเข้า', 'class="btn btn-primary"');
					?>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
		<?php if ($result !="") {?>
		<div class="alert alert-success">
			<?php echo $result; ?>
		</div>
		<?php } ?>
<!-- End content -->