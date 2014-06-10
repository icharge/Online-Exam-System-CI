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
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<ol class="breadcrumb">
		<li><?php echo anchor('admin', 'หน้าแรก');?></li>
		<li class="active">จัดการวิชาในระบบ</li>
	</ol>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main <?php if(!$this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
	<div class="page-header">
		<h1><span class="glyphicon glyphicon-book"></span> จัดการวิชาในระบบ <small></small></h1>
		<div class="well well-sm">
			<span>ข้อมูลพื้นฐานของรายวิชาที่มีการเรียนการสอน และอาจมีการจัดสอบ เปรียบเสมือนคำอธิบายวิชาเรียนนั้น ๆ ซึ่งคุณสามารถใช้ข้อมูลดังกล่าว เปิดวิชาที่สอบได้</span>
		</div>
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
	<label for="faculty">เลือกดูจาก </label>
	<label><?php 
		$options = array(
			'all' => 'ทั้งหมด',
			'วิทยาศาสตร์และศิลปศาสตร์' => 
			array(
				'all' => 'วิทยาศาสตร์และศิลปศาสตร (ทั้งหมด)',
				'it' => 'เทคโนโลยีสารสนเทศ',
				'at' => 'เทคโนโลยีการเกษตร',
				'is' => 'ระบบสารสนเทศ',
				'ba' => 'บริหารธุรกิจ',
				'lbt' => 'การจัดการโลจิสติกส์และการค้าชายแดน'
			),
			'marine' => 'เทคโนโลยีทางทะเล',
			'อัญมณี' => 
			array(
				'all' => 'อัญมณี (ทั้งหมด)',
				'g1' => 'อัญมณีและเครื่องประดับ',
				'g2' => 'ธุรกิจอัญมณีและเครื่องประดับ',
				'g3' => 'ออกแบบเครื่องประดับ'
			)
		);
		echo form_dropdown('faculty', $options, 'default', 'id="faculty" class="form-control"');

	?></label>
</div>
<div class="row <?php if($this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
	<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<span><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;วิชาในระบบ</span>
					<div class="panel-btn btn-group pull-right">
						<?php echo anchor('admin/subjects/add', 'เพิ่ม', 'class="btn btn-sm btn-info"');?>
						<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><?php echo anchor('admin/subjects/edit/', 'แก้ไข');?></li>
						</ul>
					</div>
				</div>
				<div class="panel-body search">
					<div class="row">
						<?php
						$attr = array(
							'name' => 'searchsubject',
							'class' => 'form-inline searchform',
							'role' => 'search',
							'method' => 'get'
							);
						echo form_open('admin/subjects', $attr);
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
										'onchange="submitFrm(document.forms.searchsubject)"');
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
											'class'=>'form-control',
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
									<th style="width: 79px;">รหัสวิชา</th>
									<th style="width: 25%;">ชื่อ</th>
									<th style="width: 88px;">ชื่อย่อ</th>
									<th>คำอธิบาย</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if (($subjectlist)) {
										foreach ($subjectlist as $item) {
											echo "
											<tr href=\"".$this->misc->getHref('admin/subjects/view')."/$item[code]\">
											<td>$item[code]</td>
											<td>$item[name]</td>
											<td>$item[shortname]</td>
											<td>".$this->misc->getShortText($item['description'])."</td>
											</tr>
											";
										}
									} else {
										echo "<tr class='warning'><td colspan='4' class='text-center'>ไม่พบข้อมูล</td></tr>";
									}
									
								?>				
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<script>
		function submitFrm(frm) {
			frm.submit();
		}</script>
<!-- End content -->