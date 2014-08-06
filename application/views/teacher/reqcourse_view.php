<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="glyphicon glyphicon-send"></span> <?php echo $pagetitle;?>
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
		//echo form_open($formlink, $attr);
		echo '<form method="post" enctype="multipart/form-data">';
		?>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
				<?php if (isset($msg_info)) { ?>
				<div class="alert alert-success" style="min-width: 343px">
					<i class="fa fa-check"></i>
					<?=$msg_info?>
				</div>
				<?php } ?>
				<?php if (isset($msg_err)) { ?>
				<div class="alert alert-danger" style="min-width: 343px">
					<i class="fa fa-ban"></i>
					<?=$msg_err?>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<!-- Begin request box -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">
							แบบฟอร์ม
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
					</div>
					<div class="box-footer text-right">
					<?php
					echo form_submit('submit', 'นำเข้าข้อมูล', 'class="btn btn-primary"');
					?>
					</div>
				</div>
			</div>
		<!-- End Upload form -->
		</div>
	
		<?php form_close(); ?>
<!-- End content -->