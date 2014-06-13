<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li<?php echo $this->misc->listCActive("admin"); ?>><?php echo anchor('admin', '<span class="glyphicon glyphicon-dashboard"></span> ทั่วไป');?></li>
		<li<?php echo $this->misc->listCActive("examreport"); ?>><?php echo anchor('admin/examreport', '<span class="glyphicon glyphicon-dashboard"></span> รายงานการสอบ');?></li>
		<li<?php echo $this->misc->listCActive("scorereport"); ?>><?php echo anchor('admin/scorereport', '<span class="glyphicon glyphicon-book"></span> รายงานผลคะแนน');?></li>
		<li<?php echo $this->misc->listCActive("log"); ?>><?php echo anchor('admin/log', '<span class="glyphicon glyphicon-list-alt"></span> ประวัติการใช้งาน');?></li>
	</ul>
	<ul class="nav nav-sidebar">
		<li<?php echo $this->misc->listCActive("faculty"); ?>><?php echo anchor('admin/faculty', '<div class="glyphicon glyphicon-list-alt"></div> จัดการคณะ');?></li>
		<li<?php echo $this->misc->listCActive("users"); ?>><?php echo anchor('admin/users', '<span class="glyphicon glyphicon-user"></span> จัดการผู้ใช้');?></li>
		<li<?php echo $this->misc->listCActive("subjects"); ?>><?php echo anchor('admin/subjects', '<div class="glyphicon glyphicon-book"></div> จัดการวิชา');?></li>
		<li<?php echo $this->misc->listCActive("courses"); ?>><?php echo anchor('admin/courses', '<div class="glyphicon glyphicon-list-alt"></div> วิชาที่เปิด');?></li>
		<li<?php echo $this->misc->listCActive("examswitch"); ?>><?php echo anchor('admin/examswitch', '<div class="glyphicon glyphicon-list-alt"></div> เปิดการสอบ');?></li>
		<li<?php echo $this->misc->listCActive("examreset"); ?>><?php echo anchor('admin/examreset', '<div class="glyphicon glyphicon-list-alt"></div> รีเซตการสอบ');?></li>
	</ul>
</div>