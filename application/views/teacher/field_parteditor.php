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

			</div>
		</div>
		<?php form_close(); ?>
		<div class="modal fade" id="modaladdpaper" data-backdrop="static">
			<?php
				$attr = array(
					'name' => 'addpaper',
					'role' => 'form',
					'method' => 'post'
				);
				echo form_open($formlinkaddpaper, $attr);
			?>
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> สร้างชุดข้อสอบ</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-danger alert-dismissable" style="display: none;">
								<i class="fa fa-ban"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<b>โปรด</b> ตรวจสอบความถูกต้อง
							</div>
							<div class="form-group">
								<?php
								echo form_label('ชื่อชุด <span class="text-danger">*</span>', 'title');
								echo form_input(array(
									'id'=>'title',
									'name'=>'title',
									'type'=>'text',
									'class'=>'form-control',
									'placeholder'=>''));
								?>
							</div>
							<div class="form-group">
								<?php
								echo form_label('คำอธิบาย', 'description');
								echo form_textarea('description', "", 'id="paperdesc" class="form-control vert" style="height: 90px"');
								?>
							</div>
							<div class="form-group">
								<?php
								echo form_label('กฎในการสอบ', 'rules');
								echo form_textarea('rules', "", 'id="paperrules" class="form-control vert" style="height: 90px"');
								?>
							</div>
							<div class="form-group" >
								<?php
								echo form_label('ช่วงวัน <span class="text-danger">*</span>', '');
								?>
								<div class="input-daterange input-group col-xs-12" id="datepicker">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="input-md form-control" name="startdate" value="<?php echo date('d/m/Y');?>" autocomplete="off">
									<span class="input-group-addon" style="border-left-width: 0;border-right-width: 0;">ถึง</span>
									<input type="text" class="input-md form-control" name="enddate" value="<?php echo date('d/m/Y');?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label>ช่วงเวลา <span class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
									<div class="bootstrap-timepicker">
										<input type="text" class="form-control timepicker" name="starttime" value="<?php echo date('H:i');?>" autocomplete="off">
									</div>
									<span class="input-group-addon" style="border-left-width: 0;border-right-width: 0;">ถึง</span>
									<div class="bootstrap-timepicker">
										<input type="text" class="form-control timepicker" name="endtime" value="<?php echo date('H:i');?>" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="reset" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> สร้าง</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			<?php echo form_close(); ?>
		</div><!-- /.modal -->

		<div class="modal fade" id="modaladdpart" data-backdrop="static">
			<?php
				$attr = array(
					'name' => 'addpart',
					'role' => 'form',
					'method' => 'post'
				);
				echo form_open($formlinkaddpart, $attr);
				echo form_hidden('paper_id', '-1');
			?>
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> เพิ่มตอน</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-danger alert-dismissable" style="display: none;">
								<i class="fa fa-ban"></i>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<b>โปรด</b> ตรวจสอบความถูกต้อง
							</div>
							<div class="form-group">
								<?php
								echo form_label('ลำดับ <span class="text-danger">*</span>', 'no');
								echo form_input(array(
									'id'=>'no',
									'name'=>'no',
									'type'=>'text',
									'class'=>'form-control',
									'placeholder'=>''));
								?>
							</div>
							<div class="form-group">
								<?php
								echo form_label('หัวข้อ <span class="text-danger">*</span>', 'title');
								echo form_input(array(
									'id'=>'title',
									'name'=>'title',
									'type'=>'text',
									'class'=>'form-control',
									'placeholder'=>''));
								?>
							</div>
							<div class="form-group">
								<?php
								echo form_label('คำอธิบาย', 'description');
								echo form_textarea('description', "", 'id="paperdesc" class="form-control vert" style="height: 90px"');
								?>
							</div>
							<div class="form-group">
								<label><?php
								echo form_checkbox('random', 'true', FALSE,'class="minimal-red"');
								?> สุ่มข้อสอบ</label>
							</div>
						</div>
						<div class="modal-footer">
							<button type="reset" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> เพิ่ม</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			<?php echo form_close(); ?>
		</div><!-- /.modal -->
<!-- End content -->