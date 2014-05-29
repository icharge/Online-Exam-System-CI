<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li class="label label-default">ทั่วไป</li>
		<li class="active"><?php echo anchor('teacher', 'ทั่วไป');?></li>
		<li><?php echo anchor('teacher/scoreboard', 'รายงานผลคะแนน');?></li>
		<li><?php echo anchor('teacher/log', 'ประวัติการใช้งาน');?></li>
	</ul>
	<ul class="nav nav-sidebar">
		<li class="label label-default">จัดการเกี่ยวกับวิชา</li>
		<li><?php echo anchor('teacher/courses', 'วิชาที่สอน');?></li>
		<li><?php echo anchor('teacher/reqcourse', 'ร้องขอวิชาใหม่');?></li>
	</ul>
	<ul class="nav nav-sidebar">
		<li class="label label-default">คลังข้อสอบ</li>
		<li><a href="">Nav item again</a></li>
		<li><a href="">One more nav</a></li>
		<li><a href="">Another nav item</a></li>
	</ul>
</div>