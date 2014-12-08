<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel"><?=$courseInfo['code']?> <?=$courseInfo['name']?></h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<?php echo <<<html
				<p class="summary text-center">
					
				</p>
html;
?>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>ชุดข้อสอบ</th>
						<th>คะแนนเฉลี่ย</th>
						<th>คะแนนที่ได้</th>
					</tr>
				</thead>
				<tbody>
				<?php
				//var_dump($reportRows);
					if ($reportRows) {
						foreach ($reportRows as $item) {
							echo <<<html
							<tr>
							<td>{$item['papername']}</td>
							<td>{$item['average']}</td>
							<td><b>{$item['Score']}</b></td>
							</tr>
html;
						}
					} else {
						echo "<tr class='warning'><td colspan='3' class='text-center'>ไม่พบข้อมูล</td></tr>";
					}

				?>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">ปิด</button>
		</div>
	</div>
</div>
