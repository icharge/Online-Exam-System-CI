<?php
	$attrLabel = array(
		'class' => 'col-sm-3 control-label'
	);

?>
<!-- Begin login -->
<div class="row row-centered">
	<div class="col-md-5 col-centered">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="
glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;Login</h3>
			</div>
			<div class="panel-body">
<?php
	if ($this->session->flashdata('msg_error')) {
		echo "<p><font color=red>";
		echo $this->session->flashdata('msg_error');
		echo "</font></p>";
	}

	$attr = array(
		'class' => 'form-horizontal',
		'role' => 'form',
		'method' => 'post'
	);
	echo form_open('auth/dologin', $attr);
?>
					<div class="form-group">
<?php 
	echo form_label('ชื่อผู้ใช้', 'username', $attrLabel);
?>
						<div class="col-sm-8">
<?php
	echo form_input(array(
		'id'=>'username',
		'name'=>'username',
		'value'=>set_value('username'),
		'type'=>'text',
		'class'=>'form-control',
		'placeholder'=>'ชื่อผู้ใช้'));
	echo form_error('username', '<span class="label label-danger">', '</span>');
?>
						</div>
					</div>
					<div class="form-group">
<?php 
	echo form_label('รหัสผ่าน', 'password', $attrLabel);
?>
						<div class="col-sm-8">
<?php
	echo form_input(array(
		'id'=>'password',
		'name'=>'password',
		'value'=>set_value('password'),
		'type'=>'password',
		'class'=>'form-control',
		'placeholder'=>'รหัสผ่าน'));
	echo form_error('password', '<span class="label label-danger">', '</span>');
?>
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
<?php
	echo form_submit('submit', 'เข้าสู่ระบบ', 'class="btn btn-primary"');
?>
							</div>
						</div>
					</div>
				</form>


<?php
/*
	echo form_open('auth/dologin').
		form_label('ผู้ใช้งาน: ', 'username').
		form_error('username', '<span class="label label-danger">', '</span>'.br()).
		form_input('username', set_value('username')).br().
		form_label('รหัสผ่าน: ', 'password').
		form_error('password', '<font color=red>', '</font>'.br()).
		form_password('password', set_value('password')).br().
		form_submit('submit', 'เข้าสู่ระบบ');
		*/
?>

			</div>
		</div>
	</div>
</div>





<!-- End login -->