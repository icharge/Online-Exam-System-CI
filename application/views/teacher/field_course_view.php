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
			<li class="active"><?php echo $pagesubtitle;?></li>
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
			<div class="col-md-10 col-md-offset-1">

				<!-- Begin BasicInfo -->
				<div class="box nav-tabs-custom" style="border: none;">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#basic" data-toggle="tab">พื้นฐาน</a></li>
						<li><a href="#teachers" data-toggle="tab">ผู้สอน</a></li>
						<li><a href="#students" data-toggle="tab">ผู้สอบ</a></li>
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
									<h3 class="" contenteditable="false">ผู้ที่ลงสอบ <?php echo $courseInfo['code'] . ' ' . $courseInfo['name']; ?></h3>
								</div>
								<div class="col-md-12">
									<a href="#addstdgroup" class="btn btn-app">
										<i class="fa fa-plus"></i> เพิ่มกลุ่ม
									</a>

									<div class="sectorListGroup">
										<h4>กลุ่มผู้ลงสอบในวิชา</h4>
										<ul id="sectorListq" class="list-group">
											<?php
												foreach ($studentListGroups as $item) {
													echo "<a href=\"#group/".$item['group_id']."\" class=\"list-group-item\" data-group-id=\"$item[group_id]\">
													<span class=\"badge\">".$this->courses->countStudentInGroup($item['group_id'], $item['course_id'])."</span>
													<h4 class=\"list-group-item-heading\">$item[name]</h4>
													<div class=\"item-group-item-text\">$item[description]</div>
													</a>";
												}
											?>
										</ul>
									</div>
								</div>

								<!-- Group Dialog -->
								<div class="modal fade" id="stugroup">
									<div class="modal-dialog" style="width: 750px;">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h4 class="modal-title">กลุ่มนักเรียน</h4>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
														<h4 id="stdgroupname"></h4>
														<div id="stdgroupdesc" style="padding-bottom: 20px"></div>
													</div>
													<div class="col-md-12">
														<div class="questionLoading" style="display: none;">
															<span><i class="fa fa-spinner fa-spin"></i> กำลังโหลด...</span>
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
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal" id="stdListDel"><i class="fa fa-trash-o"></i> ลบกลุ่ม</button>
												<button type="button" class="btn btn-primary" id="stdListSave"><i class="fa fa-save"></i> บันทึก</button>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div><!-- /.modal -->

								<!-- add Group Dialog -->
								<div class="modal fade" id="addstugroup">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h4 class="modal-title">เพิ่มกลุ่มนักเรียน</h4>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
														<div class="alert alert-danger alert-dismissable" style="display: none;">
															<i class="fa fa-ban"></i>
															<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
															<b>โปรด</b> ตรวจสอบความถูกต้อง
														</div>
													</div>
													<div class="col-md-12">
														<form id="addstugroupfrm" action="" class="form-inline">
															<div class="form-group">
																<?php
																echo form_label('ชื่อกลุ่ม <span class="text-danger">*</span>', 'name');
																echo form_input(array(
																	'id'=>'stdgname',
																	'name'=>'stdgname',
																	'type'=>'text',
																	'class'=>'form-control',
																	'placeholder'=>''));
																?>
															</div>
															<div class="form-group">
																<?php
																echo form_label('คำอธิบายกลุ่ม', 'stdgdescription');
																echo form_textarea('stdgdescription', "", 'id="stdgdescription" class="form-control vert" style="height: 90px"');
																?>
															</div>
														</form>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
												<button type="button" class="btn btn-primary" id="stdListAdd"><i class="fa fa-plus"></i> เพิ่ม</button>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div><!-- /.modal -->

								<div class="modal fade" id="delstdgask" data-backdrop="static">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> คุณแน่ใจ ?</h4>
											</div>
											<div class="modal-body">
												<p>ต้องการนำสมาชิกออก และลบ <b><span id="askstdgname"></span></b> หรือไม่ ?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
												<button type="button" class="btn btn-danger" id="askstdgdelsure">ลบกลุ่ม</button>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div><!-- /.modal -->

							</div>
						</div>
						<div class="box-body tab-pane" id="papers">
							<h3>ชุดข้อสอบ</h3>
							<div class="row">
								<div class="col-md-12">
									<button type="button" class="btn btn-app" id="addPaper"><i class="fa fa-plus"></i> เพิ่มชุดข้อสอบ</button>
								</div>
								<div class="col-md-12">
									<ul class="list-group paper-list">
									<?php
										if(isset($examPapersList))
										{
											foreach ($examPapersList as $item) {
												list($startdate, $starttime) = explode(' ', $item['starttime']);
												list($enddate, $endtime) = explode(' ', $item['endtime']);
												$datetooltip = $this->misc->getFullDateTH($startdate)." ".$starttime.
												' ถึง '.$this->misc->getFullDateTH($enddate)." ".$endtime;
												$datediff = $this->misc->dateDifference($item['starttime'], $item['endtime']);
												/*
												echo <<<HTML
										<li>
											<span class="handle">
												<i class="fa fa-ellipsis-v"></i>
												<i class="fa fa-ellipsis-v"></i>
											</span>
											<span class="text"><b>{$item['title']}</b> <small>{$item['description']}</small></span>
											<span class="label label-info jtooltip" title="{$datetooltip}"><i class="fa fa-clock-o"></i> {$datediff}</span>
											<div class="tools">
												<i class="fa fa-edit"></i>
												<i class="fa fa-trash-o"></i>
											</div>
										</li>
HTML;
*/

												$paperparts = "";

												$paperPartsList = $this->courses->getExamPaperParts($item['paper_id']);
												foreach ($paperPartsList as $itemPart) {
													$paperparts .= <<<HTML
													<li data-partid="{$itemPart['part_id']}" id="part_{$itemPart['part_id']}">
														<span class="handle">
															<i class="fa fa-ellipsis-v"></i>
															<i class="fa fa-ellipsis-v"></i>
														</span>
														<span class="text"><b>{$itemPart['title']}</b> <small>{$itemPart['description']}</small></span>
														<div class="tools">
															<a href="{$this->misc->getHref('teacher/courses/editpart/')}/{$itemPart['part_id']}"><i class="fa fa-edit"></i></a>
															<i class="fa fa-trash-o"></i>
														</div>
													</li>
HTML;
												}
												$fullpagelink = anchor('teacher/courses/exampaper/'.$item['paper_id'], '<i class="fa fa-file-text-o"></i>');
												echo <<<HTML
												<li class="list-group-item" data-paperid="{$item['paper_id']}">
													<span class="badge"><i class="fa fa-clock-o"></i> {$datediff}</span>
													<div class="optionlinks">
														<span class="badge jtooltip" title="{$datetooltip}"><i class="fa fa-clock-o"></i> {$datediff}</span>
														<a href="#add" class="add">
															<i class="fa fa-plus"></i>
														</a>
														<a href="#edit">
															<i class="fa fa-edit"></i>
														</a>
														{$fullpagelink}
														<a href="#remove" class="text-danger">
															<i class="fa fa-trash-o"></i>
														</a>
													</div>
													<div class="content-toggle-click">
														<h4 class="list-group-item-heading">{$item['title']}</h4>
														<div class="item-group-item-text">{$item['description']}</div>
													</div>
													<div class="content-toggle" style="display: none;">
														<ul class="todo-list part-list">
														{$paperparts}
														</ul>
													</div>
												</li>
HTML;
											}
										}
									?>
									</ul>
								</div>
							</div>
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