<!-- Begin content -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="page-header">
		<h1>จัดการผู้ใช้ <small></small></h1>
		<p>คุณสามารถจัดการผู้ใช้ทุกกลุ่มได้ เช่น ผู้ดูแล ผู้สอน และนักเรียนนักศึกษา</p>
	</div>
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
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">ผู้ดูแล</div>
				<table class="table table-striped table-hover table-condensed">
					<thead>
						<tr>
							<th>ชื่อผู้ใช้</th>
							<th>รหัสผ่าน</th>
							<th>สถานะ</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>admin</td>
							<td>*******</td>
							<td>ใช้งานได้</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
<!-- End content -->