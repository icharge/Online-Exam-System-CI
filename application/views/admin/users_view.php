<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="glyphicon glyphicon-user"></span> จัดการผู้ใช้
			<small>User Management</small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> หน้าแรก');?></li>
			<li class="active">จัดการผู้ใช้</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<h4 class="page-header">
			<small>คุณสามารถจัดการผู้ใช้ทุกกลุ่มได้ เช่น ผู้ดูแล ผู้สอน และนักเรียนนักศึกษา</small>
		</h4>

		<div class="col-md-12 <?php if(!$this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
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

		<div class="box">
			<div class="box-body">
				<p>เลือกดูจาก </p>
				<div class="btn-group">
					<?php
					echo anchor('admin/users/viewgroup/all', 'ทุกกลุ่ม', 'class="'.$this->misc->btnActive($group,'all').'"').
					anchor('admin/users/viewgroup/admin', 'ผู้ดูแล', 'class="'.$this->misc->btnActive($group,'admin').'"').
					anchor('admin/users/viewgroup/teacher', 'ผู้สอน', 'class="'.$this->misc->btnActive($group,'teacher').'"').
					anchor('admin/users/viewgroup/student', 'นักเรียน', 'class="'.$this->misc->btnActive($group,'student').'"');
					?>
				</div>
			</div>
		</div>
		<div class="row <?php if($this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
			<div class="col-md-12">
				<?php
				if (isset($adminlist)) {
				?>
				<div class="box box-danger nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li class="dropdown pull-right">
							<a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo anchor('admin/users/adduser/admin', 'เพิ่ม');?></li>
							</ul>
						</li>
						<li class="pull-left header">
							<i class="glyphicon glyphicon-th"></i> ผู้ดูแล
						</li>
					</ul>
					<div class="tab-content">
						<?php
							$attr = array(
							'name' => 'searchadmin',
							'class' => 'searchform',
							'role' => 'search',
							'method' => 'get'
							);
						echo form_open('admin/users/viewgroup/admin', $attr);
						?>
							<div class="col-xs-6 col-sm-5" style="z-index:500;"></div>
							<div class="col-sm-7 ">
								<div class="col-sm-6 col-md-6 text-right" style="padding-right: 0;">
									<label>รายการ/หน้า</label>
									<label>	
										<?php
										$attr_pp = array(
											'10' => '10',
											'25' => '25',
											'50' => '50',
											'100' => '100'
											);
										if ($this->input->get('perpage')) $perpage = $this->input->get('perpage');
										else $perpage = '25';
										echo form_dropdown('perpage', 
											$attr_pp, 
											$perpage, 
											'class="form-control input-sm" onchange="submitFrm(document.forms.searchadmin)"');
											?>
									</label>
								</div>
								<div class="input-group input-group-sm col-sm-6 col-lg-6 pull-right">
									<?php
									echo form_hidden('p', $this->input->get('p'));
									echo form_input(array(
										'id'=>'searchtxt',
										'name'=>'q',
										'type'=>'text',
										'class'=>'form-control input-sm',
										'value'=>$this->input->get('q'),
										'placeholder'=>'ค้นหา'
										));
									?>
									<span class="input-group-btn">
										<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
					<div class="box-body no-padding">
						<table class="table table-striped table-hover rowclick">
							<thead>
								<tr>
									<th style="width: 110px;">ชื่อผู้ใช้</th>
									<th style="width: 37%;">ชื่อ - สกุล</th>
									<th style="width: 37%;">อีเมล์</th>
									<th style="width: 110px;">สถานะ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($adminlist as $item) {
									echo "
									<tr href=\"".$this->misc->getHref('admin/users/view')."/$item[id]\">
									<td>$item[username]</td>
									<td>$item[name] $item[lname]</td>
									<td>$item[email]</td>
									<td>$item[status]</td>
									</tr>
									";
								}
								?>				
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<?php echo $this->pagination->create_links();?>
					</div>
				</div>
				<?php } ?>

				<?php
				if (isset($teacherlist)) {
				?>
				<div class="box box-primary nav-tabs-custom">
					<ul class="nav nav-tabs  pull-right">
						<li class="dropdown pull-right">
							<a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo anchor('admin/users/adduser/teacher', 'เพิ่ม');?></li>
							</ul>
						</li>
						<li class="pull-left header">
							<i class="glyphicon glyphicon-th"></i> ผู้สอน
						</li>
					</ul>
					<div class="tab-content">
					<?php
						$attr = array(
							'name' => 'searchteacher',
							'class' => 'searchform',
							'role' => 'search',
							'method' => 'get'
						);
					echo form_open('admin/users/viewgroup/teacher', $attr);
					?>
						<div class="col-xs-6 col-sm-5" style="z-index:500;"></div>
							<div class="col-sm-7 ">
								<div class="col-sm-6 col-md-6 text-right" style="padding-right: 0;">
									<label>รายการ/หน้า</label>
									<label>	
										<?php
										$attr_pp = array(
											'10' => '10',
											'25' => '25',
											'50' => '50',
											'100' => '100'
											);
										if ($this->input->get('perpage')) $perpage = $this->input->get('perpage');
										else $perpage = '25';
										echo form_dropdown('perpage', 
											$attr_pp, 
											$perpage, 
											'class="form-control input-sm" onchange="submitFrm(document.forms.searchteacher)"');
											?>
									</label>
								</div>
								<div class="input-group input-group-sm col-sm-6 col-lg-6 pull-right">
									<?php
									echo form_input(array(
										'id'=>'searchtxt',
										'name'=>'q',
										'type'=>'text',
										'class'=>'form-control input-sm',
										'value'=>$this->input->get('q'),
										'placeholder'=>'ค้นหา'
										));
									?>
									<span class="input-group-btn">
										<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
					<div class="box-body no-padding">
						<table class="table table-striped table-hover rowclick">
							<thead>
								<tr>
									<th>ชื่อผู้ใช้</th>
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
									<tr href=\"".$this->misc->getHref('admin/users/view')."/$item[id]\">
									<td>$item[username]</td>
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
				</div>
				<?php } ?>

				<?php
				if (isset($studentlist)) {
					?>
					<div class="box box-info nav-tabs-custom">
						<ul class="nav nav-tabs  pull-right">
							<li class="dropdown pull-right">
								<a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
								<ul class="dropdown-menu" role="menu">
									<li><?php echo anchor('admin/users/adduser/student', 'เพิ่ม');?></li>
									<li><?php echo anchor('admin/users/importstudent', 'นำเข้า');?></li>
								</ul>
							</li>
							<li class="pull-left header">
								<i class="glyphicon glyphicon-th"></i> นักเรียน
							</li>
						</ul>
						<div class="tab-content">
					<?php
						$attr = array(
							'name' => 'searchstudent',
							'class' => 'searchform',
							'role' => 'search',
							'method' => 'get'
						);
					echo form_open('admin/users/viewgroup/student', $attr);
					?>
						<div class="col-xs-6 col-sm-5" style="z-index:500;"></div>
							<div class="col-sm-7 ">
								<div class="col-sm-6 col-md-6 text-right" style="padding-right: 0;">
									<label>รายการ/หน้า</label>
									<label>	
										<?php
										$attr_pp = array(
											'10' => '10',
											'25' => '25',
											'50' => '50',
											'100' => '100'
											);
										if ($this->input->get('perpage')) $perpage = $this->input->get('perpage');
										else $perpage = '25';
										echo form_dropdown('perpage', 
											$attr_pp, 
											$perpage, 
											'class="form-control input-sm" onchange="submitFrm(document.forms.searchstudent)"');
											?>
									</label>
								</div>
								<div class="input-group input-group-sm col-sm-6 col-lg-6 pull-right">
									<?php
									echo form_input(array(
										'id'=>'searchtxt',
										'name'=>'q',
										'type'=>'text',
										'class'=>'form-control input-sm',
										'value'=>$this->input->get('q'),
										'placeholder'=>'ค้นหา'
										));
									?>
									<span class="input-group-btn">
										<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
					<div class="box-body no-padding">
						<table class="table table-striped table-hover rowclick">
							<thead>
								<tr>
									<th>ชื่อผู้ใช้</th>
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
									<tr href=\"".$this->misc->getHref('admin/users/view')."/$item[id]\">
									<td>$item[username]</td>
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
						<div class="box-footer clearfix">
							<?php //echo $this->pagination->create_links();?>
						</div>
					</div>
					<?php } ?>

				</div>
			</div>
		</div>
				<script>
				function submitFrm(frm) {
					frm.submit();
				}</script>

	</section><!-- /.content -->
</aside><!-- /.right-side -->

<!-- End content -->

