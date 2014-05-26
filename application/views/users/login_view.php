<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
</head>
<body>
<?php
	if ($this->session->flashdata('msg_error')) {
		echo "<p><font color=red>";
		echo $this->session->flashdata('msg_error');
		echo "</font></p>";
	}
	echo form_open('main/dologin').
		form_label('ผู้ใช้งาน: ', 'username').
		form_error('username', '<font color=red>', '</font>'.br()).
		form_input('username', set_value('username')).br().
		form_label('รหัสผ่าน: ', 'password').
		form_error('password', '<font color=red>', '</font>'.br()).
		form_password('password', set_value('password')).br().
		form_submit('submit', 'เข้าสู่ระบบ');
?>
</body>
</html>