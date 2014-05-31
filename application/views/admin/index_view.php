<!-- Begin content -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<ol class="breadcrumb">
		<li class="active">หน้าแรก</li>
	</ol>
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