<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="fa fa-plus-circle"></span> <?php echo $pagetitle;?>
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> หน้าแรก');?></li>
			<li><?php echo anchor('admin/subjects', 'จัดการวิชาในระบบ');?></li>
			<li class="active"><?php echo $pagetitle;?></li>
		</ol>
	</section>
	<section class="content">
		<h4 class="page-header">
			<small><?php echo $pagesubtitle;?></small>
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
							รายละเอียดการเปิดสอบวิชา
						</h3>
					</div>
					<div class="box-body">
						<div class="form-group<?php if(form_error('subject_id')) echo ' has-error';?>">
							<?php 
							echo form_label('วิชา <span class="text-danger">*</span>', 'subject_id');
							$options = $this->courses->buildCourseOptions();
							echo form_dropdown('subjectid', $options, $courseInfo['subject_id'], 'id="subjectid" class="form-control"');
							?>
						</div>
						<div class="form-group<?php if(form_error('description')) echo ' has-error';?>">
							<b>คำอธิบายวิชา</b>
							<p id="courseDesc" class="text-justify"><?php echo $courseInfo['description'];?></p>
						</div>
						<div class="form-group<?php if(form_error('year')) echo ' has-error';?>">
							<?php 
							echo form_label('ปีการศึกษา <span class="text-danger">*</span>', 'year');
							$options = $this->misc->buildYearOptions();
							echo form_dropdown('year', $options, $courseInfo['year'], 'class="form-control"');
							?>
						</div>
						<div class="form-group<?php if(form_error('password')) echo ' has-error';?>">
							<?php 
							echo form_label('รหัสผ่าน', 'password');
							if ($this->courses->isEditPage()) $pwdinfo = "รหัสผ่าน กรอกเพื่อเปลี่ยน ปล่อยว่างจะใช้รหัสผ่านเดิม";
							else $pwdinfo = "่";
							echo form_input(array(
								'id'=>'password',
								'name'=>'password',
								'type'=>'password',
								'class'=>'form-control '.($this->courses->isEditPage()?'jtooltip':''),
								'title'=>$pwdinfo));
							if ($this->courses->isEditPage())
							{
								echo '<label id="removepwdlbl" class="jtooltip" title="การกระทำนี้จะมีผลเมื่อแก้ไขข้อมูล">';
								echo form_checkbox('removepass', '1', FALSE,'id="removepass" class="minimal-red"');
								echo " ลบรหัสผ่าน</label>";
							}
							
							?>
						</div>
						<div class="form-group<?php if(form_error('startdate')) echo ' has-error';?>">
							<?php 
							echo form_label('วันที่เปิด <span class="text-danger">*</span>', 'startdate');
							?>
							<div class="input-group">
								<div class="input-group-addon add-on" style="cursor: pointer">
									<i class="fa fa-calendar"></i>
								</div>
								<div id="dp1p"></div>
								<?php
								echo form_input(array(
									'id'=>'startdate',
									'name'=>'startdate',
									'value'=>$this->misc->chrsDateToBudDate($courseInfo['startdate'],"-","/"),
									'type'=>'text',
									'class'=>'form-control date',
									'placeholder'=>'วันที่เปิด',
									//'data-date-format'=>'dd/mm/yyyy',
									'readonly'=>'readonly'));
								echo form_error('startdate', '<span class="label label-danger">', '</span>');
								?>
							</div>
						</div>
						<div class="form-group<?php if(form_error('visible')) echo ' has-error';?>">
							<?php echo form_label('ตัวเลือกเพิ่มเติม'); ?><br>
							<label>
								<?php
								echo form_checkbox('visible', 'visible', ($courseInfo['visible']=='1'?FALSE:TRUE),'class="minimal-red"');
								?>
								ซ่อนวิชา
							</label>
						</div>
						<div class="form-group<?php if(form_error('status')) echo ' has-error';?>">
							<?php 
							echo form_label('สถานะ', 'status');
							?>
								<div>
									<label class="radio-inline">
										<?php echo form_radio('status', 'active', ($courseInfo['status']=="active"?true:false),'class="minimal-red"')." เปิดใช้งาน";?>
									</label>
									<label class="radio-inline">
										<?php echo form_radio('status', 'inactive', ($courseInfo['status']=="inactive"?true:false),'class="minimal-red"')." ปิดใช้งาน";?>
									</label>
								</div>
								<?php echo form_error('status', '<span class="label label-danger">', '</span>'); ?>
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
					echo form_submit('submit', $this->courses->btnSaveText(), 'class="btn btn-primary"');
					?>
				</div>
			</div>
		</div>
		<?php form_close(); ?>
<!-- End content -->