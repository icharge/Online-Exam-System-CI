<!-- Begin content -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h2>Online Examination System </h2>
<?php
	echo "ยินดีต้อนรับเข้าสู่ระบบ, ".$this->session->userdata('fullname').
	br().
	"คณะ: ".$this->session->userdata('faculty').br();


	echo anchor('main/logout', 'ออกจากระบบ');
?>
</div>
<!-- End content -->