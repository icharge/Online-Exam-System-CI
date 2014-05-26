<!-- Begin content -->
<div class="span12">
	<h2>Online Examination System </h2>
<?php
	echo "ยินดีต้อนรับเข้าสู่ระบบ, ".$this->session->userdata('fullname').
	br(). anchor('main/logout', 'ออกจากระบบ');
?>
</div>
<!-- End content -->