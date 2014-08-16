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
					</ul>
					<!-- Tab Content 1 -->
					<div class="tab-content">
						<div class="box-body tab-pane" id="basic">
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
								<div class="col-sm-5">
									<div class="panel panel-primary">
										<div class="panel-heading listview">
											<a href="#" class="list-group-item active">
												อาจารย์ทั้งหมด
												<div class="pull-right all">
													<input title="toggle all" type="checkbox" class="all pull-right">
												</div>
											</a>
										</div>
										<div class="list-group" id="list1">

											<?php
												foreach ($teacherListAvaliable as $item) {
													echo '<a href="#" class="list-group-item">'.
												$item['name'].' '.$item['lname'].
												'<div class="pull-right">
													<input name="" value="'.$item['tea_id'].'" type="checkbox" class="pull-right">
												</div>
											</a>';
												}
											?>
										</div>
									</div>
								</div>
								<div class="col-md-2 btn-group-wrapper">
									<div class="middle">
										<div class="inner">
											<button type="button" title="Send to list 2" class="btn btn-default center-block add">
												<i class="glyphicon glyphicon-chevron-right"></i>
											</button>
											<button type="button" title="Send to list 1" class="btn btn-default center-block remove">
												<i class="glyphicon glyphicon-chevron-left"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="col-sm-5">
									<div class="panel panel-primary">
										<div class="panel-heading listview">
											<a href="#" class="list-group-item active">
												อาจารย์ที่เลือก
												<div class="pull-right all">
													<input title="toggle all" type="checkbox" class="all pull-right">
												</div>
											</a>
										</div>
										<div class="list-group" id="list2">
											<?php
												foreach ($teacherListinCourse as $item) {
													echo
													'<a href="#" class="list-group-item">'.
													$item['name'].' '.$item['lname'].
													'<div class="pull-right">
														<input name="teaselected[]" value="'.$item['tea_id'].'" type="checkbox" class="pull-right">
														</div>
													</a>';
												}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Students tab -->
						<div class="box-body tab-pane active" id="students">
							<div class="row">
								<div class="col-md-12 text-center">
									<h3 class="" contenteditable="false">นักเรียนลงทะเบียนเข้าสอบ</h3>
								</div>
								<div class="col-sm-5">
									<div class="panel panel-primary">
										<div class="panel-heading listview">
											<a href="#" class="list-group-item active">
												นักเรียนทั้งหมด
												<div class="pull-right all">
													<input title="toggle all" type="checkbox" class="all pull-right">
												</div>
											</a>
										</div>
										<div class="list-group" id="list1">

											<?php
												foreach ($studentListAvaliable as $item) {
													echo '<a href="#" class="list-group-item">'.
												$item['name'].' '.$item['lname'].
												'<div class="pull-right">
													<input name="" value="'.$item['stu_id'].'" type="checkbox" class="pull-right">
												</div>
											</a>';
												}
											?>
										</div>
									</div>
								</div>
								<div class="col-md-2 btn-group-wrapper">
									<div class="middle">
										<div class="inner">
											<button type="button" title="Send to list 2" class="btn btn-default center-block add">
												<i class="glyphicon glyphicon-chevron-right"></i>
											</button>
											<button type="button" title="Send to list 1" class="btn btn-default center-block remove">
												<i class="glyphicon glyphicon-chevron-left"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="col-sm-5">
									<div class="panel panel-primary">
										<div class="panel-heading listview">
											<a href="#" class="list-group-item active">
												นักเรียนในวิชา
												<div class="pull-right all">
													<input title="toggle all" type="checkbox" class="all pull-right">
												</div>
											</a>
										</div>
										<div class="list-group" id="list2">
											<?php
												foreach ($studentListinCourse as $item) {
													echo
													'<a href="#" class="list-group-item">'.
													$item['name'].' '.$item['lname'].
													'<div class="pull-right">
														<input name="stuselected[]" value="'.$item['stu_id'].'" type="checkbox" class="pull-right">
														</div>
													</a>';
												}
											?>
										</div>
									</div>
								</div>
							</div>

							<input id="textbox" type="text" />
							<select id="cid" size="10" style="width:200px;height:300px">
								<optgroup label="EWR">
									<option value="1159500">Christopher Guadalupe - 1159500</option>
									<option value="1100092">Ira Robinson - 1100092</option>
									<option value="1165834">David Oliveira - 1165834</option>
									<option value="1234214">William Lese - 1234214</option>
									<option value="1184142">Merik Nanish - 1184142</option>
									<option value="1184140">Michael Tarr - 1184140</option>
									<option value="1215108">Aidan Sandri - 1215108</option>
									<option value="1167394">Keoni Jamison - 1167394</option>
									<option value="1089128">Ryan Donahue - 1089128</option>
									<option value="1275262">Jonathan Bubloski - 1275262</option>
									<option value="954070">Sam Hudis - 954070</option>
									<option value="1262085">Dante Nikolovski - 1262085</option>
									<option value="1170200">Tommy Fortunato - 1170200</option>
									<option value="1204373">Mohamed Salah - 1204373</option>
									<option value="1020845">Nicola Felini - 1020845</option>
									<option value="1183112">Cody Cochran - 1183112</option>
									<option value="1127216">Austin Claus - 1127216</option>
									<option value="1281553">Jake Weinberg - 1281553</option>
									<option value="1281517">Cody Severide - 1281517</option>
									<option value="858984">Steve Moerdyk - 858984</option>
									<option value="989429">Chris Mauro - 989429</option>
									<option value="1034699">Dante Fabrizio - 1034699</option>
									<option value="1288619">Frank Massa - 1288619</option>
									<option value="1231877">Robert Joyce - 1231877</option>
									<option value="1294837">Junior Silva - 1294837</option>
									<option value="1017951">Andrew Morkunas - 1017951</option>
									<option value="1295294">Justin Cummings - 1295294</option>
									<option value="1282966">Jakub Dlouhy - 1282966</option>
									<option value="1296230">Andrew Treulich - 1296230</option>
									<option value="1026637">Gavin Bernard - 1026637</option>
									<option value="1272203">Daniel Sanchez (VC) - 1272203</option>
									<option value="812804">Karl Kleiber - 812804</option>
									<option value="881422">Matthew Kreilein - 881422</option>
									<option value="908962">Karl Moberg - 908962</option>
									<option value="1049046">Michael Iserman - 1049046</option>
									<option value="1056593">Brian Reed - 1056593</option>
									<option value="1111132">Preston Foss - 1111132</option>
									<option value="1113758">Zack Slavutsky - 1113758</option>
									<option value="1134195">Gary Tekulsky - 1134195</option>
									<option value="1137188">Karim Elsammak - 1137188</option>
									<option value="1148014">Jason Liu - 1148014</option>
								</optgroup>
								<optgroup label="JFK">
									<option value="1154386">Valia Tsagkalidou - 1154386</option>
									<option value="1175896">John Wiesenfeld - 1175896</option>
									<option value="1192604">Lukasz Wasiak - 1192604</option>
									<option value="1015443">Nelson Collado - 1015443</option>
									<option value="1208294">Christian Schmidt - 1208294</option>
									<option value="1142767">Vincent Games - 1142767</option>
									<option value="1123317">Ryan Hakim - 1123317</option>
									<option value="1228765">Marcus Johnson - 1228765</option>
									<option value="1217691">Malcolm Dickinson - 1217691</option>
									<option value="1038942">Michael Mund-Hoym - 1038942</option>
									<option value="997868">Michael Bertolini - 997868</option>
									<option value="1221525">Tevin DaSilva - 1221525</option>
									<option value="880199">Anthony Santanastaso - 880199</option>
									<option value="1129821">Harold Taylor - 1129821</option>
									<option value="1250078">Tom Pallini - 1250078</option>
									<option value="824430">Peter Goutmann - 824430</option>
									<option value="1146087">Stephen Ryan - 1146087</option>
									<option value="1219279">Pascal Doppmann - 1219279</option>
									<option value="936528">Michael Brown - 936528</option>
									<option value="996337">Bobby Mattox - 996337</option>
									<option value="811731">Curley Bryant - 811731</option>
									<option value="946633">Mark Celestine - 946633</option>
									<option value="1199058">Jimmy DiCio - 1199058</option>
									<option value="1271881">Malick Mercier - 1271881</option>
									<option value="927188">Michael Roche - 927188</option>
									<option value="1017295">Adrien Maffre - 1017295</option>
									<option value="1296785">Jack Slattery - 1296785</option>
									<option value="1188654">Jonathan Lin - 1188654</option>
									<option value="1266532">Michael Hiller - 1266532</option>
									<option value="1278231">DeVere Walcott - 1278231</option>
									<option value="811728">Yuri Soares - 811728</option>
									<option value="919227">Sergio Guerjik - 919227</option>
									<option value="936402">Pan Lalas - 936402</option>
									<option value="960263">Tom Seeley - 960263</option>
									<option value="1286604">Muhammed Sheriff - 1286604</option>
									<option value="1036435">Sam Vaughan - 1036435</option>
									<option value="1028051">Antoine Saccone - 1028051</option>
									<option value="1063331">Derek Vento - 1063331</option>
									<option value="1088010">Kyle Perry - 1088010</option>
									<option value="1019870">Felipe Vicini - 1019870</option>
									<option value="1098738">Josh Leimbach - 1098738</option>
									<option value="1138786">Mike Cinnante - 1138786</option>
									<option value="1289785">Eddy Salvador - 1289785</option>
								</optgroup>
								<optgroup label="LGA">
									<option value="1158920">Steven Guadalupe - 1158920</option>
									<option value="1203291">Jeff Szczesniak - 1203291</option>
									<option value="1162375">Mark Plover - 1162375</option>
									<option value="1236079">Emanuel Furman - 1236079</option>
									<option value="1053857">Sebastien Bartosz - 1053857</option>
									<option value="1238260">Sammy Jiang - 1238260</option>
									<option value="1000868">Michael Pogorzelski - 1000868</option>
									<option value="1075569">David Gates - 1075569</option>
									<option value="1283864">Benjamin Weiss - 1283864</option>
									<option value="1246357">Chris Mathiessen - 1246357</option>
									<option value="1243221">Kevin Wiegard - 1243221</option>
									<option value="971630">Brad Lee - 971630</option>
									<option value="1197282">Alexander Schmack - 1197282</option>
									<option value="1230746">Dorian Pope - 1230746</option>
									<option value="1162982">Scott Pritts - 1162982</option>
									<option value="1278529">Jan Brentjens - 1278529</option>
									<option value="1240094">Sebastian Rekdal - 1240094</option>
									<option value="1275345">Alexander Nakopoulos (VC) - 1275345</option>
									<option value="1200876">Chris Sutton - 1200876</option>
									<option value="1276571">Chase Kelly - 1276571</option>
									<option value="1202237">Justin Gray - 1202237</option>
									<option value="1137691">Ivan Weiss - 1137691</option>
									<option value="1293284">Sean Mack - 1293284</option>
									<option value="1200306">Tony Koskinen - 1200306</option>
									<option value="1285717">Grant Ballew - 1285717</option>
									<option value="1249946">Thomas Ray - 1249946</option>
									<option value="1292086">Abhaya Pattanaik - 1292086</option>
									<option value="811725">Kevin Kan - 811725</option>
									<option value="812093">Wayne Dibert - 812093</option>
									<option value="976213">Alex Evins - 976213</option>
									<option value="1040963">Jesse Watkins - 1040963</option>
									<option value="1084329">Nicholas Cavacini - 1084329</option>
									<option value="1090136">Dean Fawley - 1090136</option>
									<option value="1004659">Ben Jones - 1004659</option>
									<option value="1100894">Mark Bott - 1100894</option>
									<option value="1288237">Sarvesh Patel - 1288237</option>
								</optgroup>
								<optgroup label="PHL">
									<option value="1153968">Dan Roistacher - 1153968</option>
									<option value="1161267">Dimitri Trofimuk - 1161267</option>
									<option value="810253">Andrew Heath - 810253</option>
									<option value="1234649">Mike Story - 1234649</option>
									<option value="1159578">Michael Siniakin - 1159578</option>
									<option value="1208486">Richard Lawrence - 1208486</option>
									<option value="1015125">Ryan Reed - 1015125</option>
									<option value="876729">Richard Price - 876729</option>
									<option value="1239711">Stephen Delash - 1239711</option>
									<option value="1289328">Alan Aquino - 1289328</option>
									<option value="1141091">Timothy Roy - 1141091</option>
									<option value="812021">Ed Callan - 812021</option>
									<option value="1232421">Christopher Pratt - 1232421</option>
									<option value="1062506">Daniel Allon - 1062506</option>
									<option value="934724">Michael Smith - 934724</option>
									<option value="1281052">Umar Ashraf - 1281052</option>
									<option value="1190016">Sean-Michael Kemp - 1190016</option>
									<option value="1263073">Taurean Copeland - 1263073</option>
									<option value="1176893">Zachary Woock - 1176893</option>
									<option value="815471">Garry Foster - 815471</option>
									<option value="1159514">Juan Sebastian - 1159514</option>
									<option value="1278215">Alex Sheynin - 1278215</option>
									<option value="980291">Barry Theodore - 980291</option>
									<option value="1052897">Joseph Pisciotto - 1052897</option>
									<option value="1102905">Matthew Ulmer - 1102905</option>
									<option value="1202744">Timothy Barker - 1202744</option>
									<option value="1271907">Cole Harrington - 1271907</option>
									<option value="1215076">Daniel Costa - 1215076</option>
									<option value="1292639">Trevor King - 1292639</option>
									<option value="1234123">Testing User - 1234123</option>
									<option value="1294657">Nathan Watkins - 1294657</option>
									<option value="1086640">Dylan Dworsky - 1086640</option>
									<option value="1253169">Cody Hendrickson - 1253169</option>
									<option value="1280652">Aaron Hewitt - 1280652</option>
									<option value="1190774">Tyler Keplinger - 1190774</option>
									<option value="948541">Robert Coulter - 948541</option>
									<option value="1004951">Kim Vanvik - 1004951</option>
									<option value="1037621">Adrian Barnett - 1037621</option>
									<option value="1053592">Justin Friedland - 1053592</option>
									<option value="1086658">Derricko Augustus - 1086658</option>
									<option value="1087539">David Malinowski - 1087539</option>
									<option value="1093752">Michael Corcoran - 1093752</option>
									<option value="1121529">Tom Hahne - 1121529</option>
									<option value="1296828">Andrew Rossi - 1296828</option>
									<option value="1138190">Daniel Nowicki - 1138190</option>
									<option value="1142721">Michael Freudeman - 1142721</option>
								</optgroup>
							</select>



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