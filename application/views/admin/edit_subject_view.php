<?php
	$attrLabel = array(
		'class' => 'col-sm-3 control-label'
	);

?>
	<!-- Begin content -->
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', 'หน้าแรก');?></li>
			<li><?php echo anchor('admin/subjects', 'จัดการวิชาในระบบ');?></li>
			<li class="active">รายละเอียดวิชา <?=$subjectInfo['code'].' '.$subjectInfo['name'];?></li>
		</ol>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main animate-fade-up">
		<div class="page-header">
			<h1>วิชา <?php echo $subjectInfo['code']; ?> <small><?php echo $subjectInfo['name'];?></small></h1>
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
		echo form_open('admin/subjects/view/'.$subjectInfo['code'], $attr);
		?>
		<div class="row row-centered">
			<div class="col-md-8 col-centered">
				
				<!-- Begin BasicInfo -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-th-list"></span>
							&nbsp;&nbsp;ข้อมูลพื้นฐาน
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
									'value'=>$subjectInfo['subject_id'],
									'type'=>'text',
									'class'=>'form-control',
									'placeholder'=>'ID',
									'readonly'=>'readonly'));
								echo form_error('subject_id', '<span class="label label-danger">', '</span>');
								?>
							</div>
						</div> -->
						<div class="form-group<?php if(form_error('code')) echo ' has-error';?>">
							<?php 
							echo form_label('รหัสวิชา <span class="text-danger">*</span>', 'code', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
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
						</div>
						<div class="form-group<?php if(form_error('name')) echo ' has-error';?>">
							<?php 
							echo form_label('ชื่อวิชา <span class="text-danger">*</span>', 'name', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
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
						</div>
						<div class="form-group<?php if(form_error('shortname')) echo ' has-error';?>">
							<?php 
							echo form_label('ชื่อย่อวิชา <span class="text-danger">*</span>', 'ชื่อย่อวิชา', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
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
						</div>
						<div class="form-group<?php if(form_error('description')) echo ' has-error';?>">
							<?php 
							echo form_label('คำอธิบายวิชา', 'ชื่อย่อวิชา', $attrLabel);
							?>
							<div class="col-sm-8">
								<?php
								echo form_textarea('description', $subjectInfo['description'], 'class="form-control"');
								// echo form_error('description', '<span class="label label-danger">', '</span>');
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
					echo form_submit('submit', $this->subjects->btnUserfield(), 'class="btn btn-primary"');
					?>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
<!-- End content -->