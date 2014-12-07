<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel"><?=$paperInfo['title']?></h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<?php echo <<<html
				<p class="summary text-center">
					ลงสอบ <span class="badge bg-blue">{$paperCalc['enrollcount']}</span> - เข้าสอบ <span class="badge bg-aqua">{$paperCalc['testedcount']}</span> - AVG <span class="badge bg-yellow">{$paperCalc['average']}</span> - MIN <span class="badge bg-red">{$paperCalc['minimum']}</span> - MAX <span class="badge bg-green">{$paperCalc['maximum']}</span>
				</p>
html;
?>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>รหัส</th>
						<th>ชื่อ - สกุล</th>
						<th>คะแนน</th>
					</tr>
				</thead>
				<tbody>
				<?php
				//var_dump($reportRows);
					if ($reportRows) {
						foreach ($reportRows as $item) {
							echo <<<html
							<tr>
							<td>{$item['stu_id']}</td>
							<td>{$item['title']}{$item['name']} {$item['lname']}</td>
							<td>{$item['Score']}</td>
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
