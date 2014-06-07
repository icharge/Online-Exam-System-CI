<!-- Begin content -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<ol class="breadcrumb">
		<li><?php echo anchor('admin', 'หน้าแรก');?></li>
		<li class="active">จัดการผู้ใช้</li>
	</ol>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main <?php if(!$this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
	<div class="page-header">
		<h1><span class="glyphicon glyphicon-user"></span> จัดการผู้ใช้ <small></small></h1>
		<p>คุณสามารถจัดการผู้ใช้ทุกกลุ่มได้ เช่น ผู้ดูแล ผู้สอน และนักเรียนนักศึกษา</p>
	</div>
	<?php
	if ($this->session->flashdata('msg_info')) {
		// echo '
		// <div class="alert alert-success alert-dismissable">
		// <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		// <strong>เรียบร้อย!</strong> '.$this->session->flashdata('msg_info').'</div>';
		echo "
		<script>
		Messenger.options = {
			extraClasses: 'messenger-fixed messenger-on-top',
			theme: 'bootstrap'
		}
		Messenger().post({
			message: '".$this->session->flashdata('msg_info')."',
			type: 'info',
			hideAfter: 7,
			showCloseButton: true
		});
</script>";

}
if ($this->session->flashdata('msg_error')) {
	echo '
	<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>ผิดพลาด!</strong> '.$this->session->flashdata('msg_error').'</div>';
	echo "
	<script>
	Messenger.options = {
		extraClasses: 'messenger-fixed messenger-on-top',
		theme: 'bootstrap'
	}
	Messenger().post({
		message: '".$this->session->flashdata('msg_error')."',
		type: 'danger',
		hideAfter: 7,
		showCloseButton: true
	});
</script>";
}

?>
<div class="well well-sm">
	<label>เลือกดูจาก </label>
	<div class="btn-group">
		<?php
		echo anchor('admin/users/viewgroup/all', 'ทุกกลุ่ม', 'class="'.$this->misc->btnActive($group,'all').'"').
		anchor('admin/users/viewgroup/admin', 'ผู้ดูแล', 'class="'.$this->misc->btnActive($group,'admin').'"').
		anchor('admin/users/viewgroup/teacher', 'ผู้สอน', 'class="'.$this->misc->btnActive($group,'teacher').'"').
		anchor('admin/users/viewgroup/student', 'นักเรียน', 'class="'.$this->misc->btnActive($group,'student').'"');
		?>
	</div>
</div>
<div class="row <?php if($this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
	<div class="col-md-12">
		<?php
		if (isset($adminlist)) {
			?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<span>ผู้ดูแล</span>
					<div class="panel-btn btn-group pull-right">
						<?php echo anchor('admin/users/adduser/admin', 'เพิ่ม', 'class="btn btn-sm btn-info"');?>
						<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><?php echo anchor('admin/users/edituser', 'แก้ไข');?></li>
							<li class="divider"></li>
							<li><?php echo anchor('admin/users/deluser', 'ลบ');?></li>
						</ul>
					</div>
				</div>
				<div class="panel-body search">
					<div class="row">
			<?php
				$attr = array(
				'name' => 'searchadmin',
				'class' => '',
				'role' => 'search',
				'method' => 'get'
				);
			echo form_open('admin/users/viewgroup/admin', $attr);
			?>
						<div class="col-xs-6">
							<div class="recperpage">
								<label>แสดงรายการ
							<?php
								$attr_pp = array(
									'10' => '10',
									'25' => '25',
									'50' => '50',
									'100' => '100'
								);
								if ($this->input->get('perpage')) $perpage = $this->input->get('perpage');
								else $perpage = '25';
								//echo $perpage;
								echo form_dropdown('perpage', 
									$attr_pp, 
									$perpage, 
									'onchange="submitFrm(document.forms.searchadmin)"');

							?> ต่อหน้า

								</label>
							</div>
						</div>
						<div class="col-xs-6 text-right">
							<div class="dataTables_filter" id="example1_filter">
								<label>ค้นหา: 
									<!-- <input type="text" name="q"> -->
						<?php
							echo form_input(array(
								'id'=>'searchtxt',
								'name'=>'q',
								'type'=>'text',
								'class'=>'',
								'value'=>$this->input->get('q'),
								'placeholder'=>''
							));
						?>
								</label>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>ชื่อผู้ใช้</th>
							<th>รหัสผ่าน</th>
							<th>สถานะ</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($adminlist as $item) {
							echo "
							<tr>
							<td>$item[username]</td>
							<td><span class=\"label label-default\">**************</span></td>
							<td>$item[status]</td>
							</tr>
							";
						}
						?>				
					</tbody>
				</table>
			</div>
			<?php } ?>

			<?php
			if (isset($teacherlist)) {
				?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<span>ผู้สอน</span>
						<div class="panel-btn btn-group pull-right">
							<?php echo anchor('admin/users/adduser/teacher', 'เพิ่ม', 'class="btn btn-sm btn-info"');?>
							<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo anchor('admin/users/edituser', 'แก้ไข');?></li>
								<li class="divider"></li>
								<li><?php echo anchor('admin/users/deluser', 'ลบ');?></li>
							</ul>
						</div>
					</div>
					<div class="panel-body search">
					<div class="row">
			<?php
				$attr = array(
					'name' => 'searchteacher',
					'class' => '',
					'role' => 'search',
					'method' => 'get'
				);
			echo form_open('admin/users/viewgroup/teacher', $attr);
			?>
						<div class="col-xs-6">
							<div class="recperpage">
								<label>แสดงรายการ
							<?php
								$attr_pp = array(
									'10' => '10',
									'25' => '25',
									'50' => '50',
									'100' => '100'
								);
								if ($this->input->get('perpage')) $perpage = $this->input->get('perpage');
								else $perpage = '25';
								//echo $perpage;
									echo form_dropdown('perpage', 
									$attr_pp, 
									$perpage, 
									'onchange="submitFrm(document.forms.searchteacher)"');
							?> ต่อหน้า

								</label>
							</div>
						</div>
						<div class="col-xs-6 text-right">
							<div class="dataTables_filter" id="example1_filter">
								<label>ค้นหา: 
									<!-- <input type="text" name="q"> -->
						<?php
							echo form_input(array(
								'id'=>'searchtxt',
								'name'=>'q',
								'type'=>'text',
								'class'=>'',
								'value'=>$this->input->get('q'),
								'placeholder'=>''
							));
						?>
								</label>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th>ชื่อผู้ใช้</th>
								<th>รหัสผ่าน</th>
								<th>ชื่อ</th>
								<th>นามสกุล</th>
								<th>คณะ</th>
								<th>สถานะ</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($teacherlist as $item) {
								echo "
								<tr>
								<td>$item[username]</td>
								<td><span class=\"label label-default\">*********</span></td>
								<td>$item[name]</td>
								<td>$item[lname]</td>
								<td>$item[fac_id]</td>
								<td>$item[status]</td>
								</tr>
								";
							}
							?>				
						</tbody>
					</table>
				</div>
				<?php } ?>

				<?php
				if (isset($studentlist)) {
					?>

					<div class="panel panel-primary">
						<div class="panel-heading">
							<span>นักเรียน</span>
							<div class="panel-btn btn-group pull-right">
								<?php echo anchor('admin/users/adduser/student', 'เพิ่ม', 'class="btn btn-sm btn-info"');?>
								<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><?php echo anchor('admin/importstudent', 'นำเข้า');?></li>
									<li><?php echo anchor('admin/users/edituser', 'แก้ไข');?></li>
									<li class="divider"></li>
									<li><?php echo anchor('admin/users/deluser', 'ลบ');?></li>
								</ul>
							</div>
						</div>
						<div class="panel-body search">
					<div class="row">
			<?php
				$attr = array(
					'name' => 'searchstudent',
					'class' => '',
					'role' => 'search',
					'method' => 'get'
				);
			echo form_open('admin/users/viewgroup/student', $attr);
			?>
						<div class="col-xs-6">
							<div class="recperpage">
								<label>แสดงรายการ
							<?php
								$attr_pp = array(
									'10' => '10',
									'25' => '25',
									'50' => '50',
									'100' => '100'
								);
								if ($this->input->get('perpage')) $perpage = $this->input->get('perpage');
								else $perpage = '25';
								//echo $perpage;
								echo form_dropdown('perpage', 
									$attr_pp, 
									$perpage, 
									'onchange="submitFrm(document.forms.searchstudent)"');
							?> ต่อหน้า

								</label>
							</div>
						</div>
						<div class="col-xs-6 text-right">
							<div class="dataTables_filter" id="example1_filter">
								<label>ค้นหา: 
									<!-- <input type="text" name="q"> -->
						<?php
							echo form_input(array(
								'id'=>'searchtxt',
								'name'=>'q',
								'type'=>'text',
								'class'=>'',
								'value'=>$this->input->get('q'),
								'placeholder'=>''
							));
						?>
								</label>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
						<table class="table table-striped table-hover table-bordered">
							<thead>
								<tr>
									<th>ชื่อผู้ใช้</th>
									<th>รหัสผ่าน</th>
									<th>ชื่อ - สกุล</th>
									<th>เพศ</th>
									<th>คณะ</th>
									<th>สาขา</th>
									<th>ปีการศึกษา</th>
									<th>สถานะ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($studentlist as $item) {
									echo "
									<tr>
									<td>$item[username]</td>
									<td><span class=\"label label-default\">*********</span></td>
									<td>$item[name]&nbsp;&nbsp;$item[lname]</td>
									<td>";
									echo ($item['gender']=="male")?"ชาย":"หญิง";
									echo "</td>
									<td>$item[fac_id]</td>
									<td>$item[branch_id]</td>
									<td>$item[year]</td>
									<td>$item[status]</td>
									</tr>
									";
								}
								?>				
							</tbody>
						</table>
					</div>
					<?php } ?>

				</div>
			</div>
		</div>
		<script>
		function submitFrm(frm) {
			frm.submit();
		}</script>
<!-- End content -->