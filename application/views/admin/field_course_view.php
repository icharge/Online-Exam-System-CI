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
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> หน้าแรก');?></li>
			<li><?php echo anchor('admin/courses', 'จัดการวิชาที่เปิดสอบ');?></li>
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
				<div class="box nav-tabs-custom" style="border: none;">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#basic" data-toggle="tab">พื้นฐาน</a></li>
						<li><a href="#teachers" data-toggle="tab">ผู้สอน</a></li>
						<li><a href="#students" data-toggle="tab">นักเรียน</a></li>
						<li><a href="#papers" data-toggle="tab">ชุดข้อสอบ</a></li>
					</ul>
					<!-- Tab Content 1 -->
					<div class="tab-content">
						<div class="box-body tab-pane active" id="basic">
							<div class="form-group<?php if(form_error('subjectid')) echo ' has-error';?>">
								<?php
								echo form_label('วิชา <span class="text-danger">*</span>', 'subjectid');
								$options = $this->courses->buildCourseOptions();
								echo form_dropdown('subjectid', $options, (isset($courseInfo['subject_id'])?$courseInfo['subject_id']:'default'), 'id="subjectid" class="form-control"');
								?>
							</div>
							<div class="form-group<?php if(form_error('description')) echo ' has-error';?>">
								<label>คำอธิบายวิชา</label>
								<div id="courseDesc" class="text-justify">
									<?php echo (isset($courseInfo['description'])?$courseInfo['description']:'');?>
								</div>
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
							<!--
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
										'value'=>($courseInfo['startdate']!=""?$this->misc->chrsDateToBudDate($courseInfo['startdate'],"-","/"):$this->misc->chrsDateToBudDate(date("Y-m-d"),"-","/")),
										'type'=>'text',
										'class'=>'form-control date',
										'placeholder'=>'วันที่เปิด',
										//'data-date-format'=>'dd/mm/yyyy',
										'readonly'=>'readonly'));
									?>
								</div>
								<?php echo form_error('startdate', '<span class="label label-danger">', '</span>');?>
							</div>
							-->
							<div class="form-group<?php if(form_error('visible')) echo ' has-error';?>">
								<?php echo form_label('ตัวเลือกเพิ่มเติม'); ?><br>
								<label>
									<?php
									echo form_checkbox('visible', 'hidden', (isset($courseInfo['visible'])?$courseInfo['visible']=='1'?FALSE:TRUE:FALSE),'class="minimal-red"');
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
											<?php echo form_radio('status', 'active', (isset($courseInfo['status'])?$courseInfo['status']=="active"?true:false:true),'class="minimal-red"')." เปิดใช้งาน";?>
										</label>
										<label class="radio-inline">
											<?php echo form_radio('status', 'inactive', (isset($courseInfo['status'])?$courseInfo['status']=="inactive"?true:false:false),'class="minimal-red"')." ปิดใช้งาน";?>
										</label>
									</div>
									<?php echo form_error('status', '<span class="label label-danger">', '</span>'); ?>
							</div>
						</div>
						<!-- Teacher tab -->
						<div class="box-body tab-pane" id="teachers">
							<div class="row">
								<div class="col-md-12 text-center">
									<h3 class="" contenteditable="false">เลือกอาจารย์ประจำวิชา</h3>
								</div>
								<select name="teaselected[]" id="teacherList" class="def" size="10" multiple style="width:200px;height:300px">
									<?php
										foreach ($teacherListAvaliable as $item) {
											echo
											'<option value="'.$item['tea_id'].'">'.$item['name'].' '.$item['lname'].
											'</option>';
										}
										foreach ($teacherListinCourse as $item) {
											echo
											'<option value="'.$item['tea_id'].'" selected="selected">'.$item['name'].' '.$item['lname'].
											'</option>';
										}

									?>
								</select>

							</div>
						</div>
						<!-- Students tab -->
						<div class="box-body tab-pane" id="students">
							<div class="row">
								<div class="col-md-12 text-center">
									<h3 class="" contenteditable="false">ผู้ที่ลงเรียน <?php 
									if (isset($courseInfo['code']) && isset($courseInfo['name']))
									echo $courseInfo['code'] . ' ' . $courseInfo['name']; 

									?></h3>
								</div>
								<select name="stdselected[]" id="studentList" class="def" size="10" multiple style="width:200px;height:300px">
									<?php
										foreach ($studentListAvaliable as $item) {
											echo
											'<option value="'.$item['stu_id'].'">'.$item['name'].' '.$item['lname'].
											'</option>';
										}
										foreach ($studentListinCourse as $item) {
											echo
											'<option value="'.$item['stu_id'].'" selected="selected">'.$item['name'].' '.$item['lname'].
											'</option>';
										}

									?>
								</select>
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