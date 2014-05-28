<!-- Begin content -->
<div class="span12">
	<h2>Online Examination System </h2>
<?php
	echo "ยินดีต้อนรับเข้าสู่ระบบ, ".$this->session->userdata('fullname').
	br().
	"วันเกิด: ".$this->session->userdata('birth').br().
	"เพศ: ".$this->session->userdata('gender').br(3);

	echo anchor('auth/logout', 'ออกจากระบบ');
?>
</div>
<!-- End content -->