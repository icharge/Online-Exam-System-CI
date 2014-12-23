<!-- Begin login -->
<div class="row animate-fade-up" style="margin-top: 30px">
	<div class="col-sm-4 col-sm-offset-4">
		<div class="panel panel-<?php if(!isset($msg_error)) echo "primary"; else echo "danger";?>">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="
glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;การสอบ</h3>
			</div>
			<div class="panel-body">
<?php
	if (isset($msg_error)) {
		echo "
		<script>
		Messenger.options = {
			extraClasses: 'messenger-fixed messenger-on-top',
			theme: 'bootstrap'
		}
		Messenger().post({
			message: '".$msg_error."',
			type: 'danger',
			hideAfter: 7,
			showCloseButton: true
		});
		</script>";
	}

?>
				<div class="form-group">
					<div class="col-sm-12" style="text-align: center;">
						ส่งข้อสอบเรียบร้อย คุณทำได้ <?php echo $score; ?> / <?php echo $qcount; ?> ข้อ<br>
<?php
echo anchor('', 'เสร็จสิ้น', 'class="btn btn-primary"');
?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





<!-- End login -->