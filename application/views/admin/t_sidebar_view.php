<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li<?php echo $this->misc->listActive("index"); ?>><?php echo anchor('admin', 'ทั่วไป');?></li>
		<li<?php echo $this->misc->listActive("examreport"); ?>><?php echo anchor('admin/examreport', 'รายงานการสอบ');?></li>
		<li<?php echo $this->misc->listActive("scorereport"); ?>><?php echo anchor('admin/scorereport', 'รายงานผลคะแนน');?></li>
		<li<?php echo $this->misc->listActive("log"); ?>><?php echo anchor('admin/log', 'ประวัติการใช้งาน');?></li>
	</ul>
	<ul class="nav nav-sidebar">
		<li<?php echo $this->misc->listActive("courses"); ?>><?php echo anchor('admin/courses', 'จัดการวิชา');?></li>
		<li<?php echo $this->misc->listActive("users"); ?>><?php echo anchor('admin/users', 'จัดการผู้ใช้');?></li>
		<li<?php echo $this->misc->listActive("examswitch"); ?>><?php echo anchor('admin/examswitch', 'เปิดการสอบ');?></li>
		<li<?php echo $this->misc->listActive("examreset"); ?>><?php echo anchor('admin/examreset', 'รีเซตการสอบ');?></li>
	</ul>
</div>