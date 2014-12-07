<table class="table table-striped table-hover rowclick">
	<thead>
		<tr>
			<th>รหัส</th>
			<th>ชื่อ - สกุล</th>
			<th>คะแนน</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if ($reportRows) {
			foreach ($reportRows as $item) {
				echo <<<html
				<tr>
				<td>{$item['stu_id']}</td>
				<td>...</td>
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