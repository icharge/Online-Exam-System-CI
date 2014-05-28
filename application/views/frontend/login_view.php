<!-- Begin login -->
<div class="row row-centered">
	<div class="col-md-5 col-centered">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Login</h3>
			</div>
			<div class="panel-body">
<?php
	$attr = array(
		'class' => 'form-horizontal',
		'role' => 'form',
		'method' => 'post'
	);
	echo form_open('auth/dologin', $attr);
?>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="inputUsers" class="col-sm-3 control-label">ชื่อผู้ใช้</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="inputUsers" placeholder="ชื่อผู้ใช้">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">รหัสผ่าน</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" id="inputPassword3" placeholder="รหัสผ่าน">
						</div>
					</div>
					<!-- <div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<div class="checkbox">
								<label>
									<input type="checkbox"> จดจำรหัสผ่าน
								</label>
							</div>
						</div>
					</div> -->
					<div class="form-group">
						<div class="row row-centered">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-default">เข้าสู่ระบบ</button>
							</div>
						</div>
					</div>
				</form>


<?php
	if ($this->session->flashdata('msg_error')) {
		echo "<p><font color=red>";
		echo $this->session->flashdata('msg_error');
		echo "</font></p>";
	}

	echo form_open('auth/dologin').
		form_label('ผู้ใช้งาน: ', 'username').
		form_error('username', '<font color=red>', '</font>'.br()).
		form_input('username', set_value('username')).br().
		form_label('รหัสผ่าน: ', 'password').
		form_error('password', '<font color=red>', '</font>'.br()).
		form_password('password', set_value('password')).br().
		form_submit('submit', 'เข้าสู่ระบบ');
?>

			</div>
		</div>
	</div>
</div>





<!-- End login -->