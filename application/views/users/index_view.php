<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>หน้าหลัก</title>
</head>
<body>
	<?php
		echo "ยินดีต้อนรับเข้าสู่ระบบ, ".$this->session->userdata('username').
		br(). anchor('main/logout', 'ออกจากระบบ');
	?>
</body>
</html>