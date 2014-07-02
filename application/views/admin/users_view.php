<!-- Begin content -->
<script>
	$('body').on('mousedown', 'tr[href]', function(e){
		var click = e.which;
		var url = $(this).attr('href');
		if(url){
			if(click == 1){
				window.location.href = url;
			}
			else if(click == 2){
				window.open(url, '_blank');
				window.focus();
			}
			return true;
		}
	});
</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="glyphicon glyphicon-user"></span> จัดการผู้ใช้
			<small>User Management</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
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
		<script>
			$('body').on('mousedown', 'tr[href]', function(e){
				var click = e.which;
				var url = $(this).attr('href');
				if(url){
					if(click == 1){
						window.location.href = url;
					}
					else if(click == 2){
						window.open(url, '_blank');
						window.focus();
					}
					return true;
				}
			});

		</script>

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
				<div class="box box-primary nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li class="dropdown pull-right">
							<a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo anchor('admin/users/adduser/admin', 'เพิ่ม');?></li>
							</ul>
						</li>
						<li class="pull-left header">
							<i class="fa fa-th"></i> ผู้ดูแล
						</li>
					</ul>
					<div class="tab-content">
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
				</div>
				<?php } ?>

				<?php
				if (isset($teacherlist)) {
				?>
				<div class="box box-info nav-tabs-custom">
					<ul class="nav nav-tabs  pull-right">
						<li class="dropdown pull-right">
							<a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><?php echo anchor('admin/users/adduser/teacher', 'เพิ่ม');?></li>
							</ul>
						</li>
						<li class="pull-left header">
							<i class="fa fa-th"></i> ผู้สอน
						</li>
					</ul>
					<div class="tab-content">
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

							<div class="panel panel-primary">
								<div class="panel-heading">
									<span><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;นักเรียน</span>
									<div class="panel-btn btn-group pull-right">
										<?php echo anchor('admin/users/adduser/student', 'เพิ่ม', 'class="btn btn-sm btn-info"');?>
										<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li><?php echo anchor('importstudent', 'นำเข้า');?></li>
											<!-- <li><?php echo anchor('admin/users/edituser', 'แก้ไข');?></li>
											<li class="divider"></li> -->
											<!-- <li><?php echo anchor('admin/users/deluser', 'ลบ');?></li> -->
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
								<table class="table table-striped table-hover table-bordered rowclick">
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

