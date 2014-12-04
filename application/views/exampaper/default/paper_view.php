<div class="fullpaper">
	<p>
	การสอบออนไลน์ของวิชา <?php echo "$courseData[code] $courseData[name]"; ?><br>
	ชุด <?php echo "$paperData[title]<br>$paperData[description]<br><b>คำชี้แจง / กฎการสอบ</b><br>$paperData[rules]"; ?>
	</p>
	<h3 class="page-header" data-paper="<?php echo $paperData['paper_id'];?>">
		<?php echo $paperData['title'];?>
	</h3>

<?php
	$attr = array(
		'name' => 'examfrm',
		'role' => 'form',
		'method' => 'post'
		);
	echo form_open($formlink, $attr);
?>
	<div class="panel-group exampapergroup" id="accordion" role="tablist" aria-multiselectable="true">
<?php
	$count = 1;
	foreach ($partData as $partItem) {
		$firstchild = ($count == 1 ? ' in' : '');
		echo <<<html
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading{$partItem['no']}">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse{$partItem['no']}" aria-expanded="true" aria-controls="collapse{$partItem['no']}">
						{$partItem['title']}
					</a>
				</h4>
			</div>
			<div id="collapse{$partItem['no']}" class="panel-collapse collapse{$firstchild}" role="tabpanel" aria-labelledby="heading{$partItem['no']}">
				<div class="panel-body">
html;
		$questData = $lib->_loadQuestion($partItem['part_id']);
		
		foreach ($questData as $questItem) {
			$questItem['number'] = $count++;
			$questItem['lib'] = $lib;
			$questItem['showAns'] = $showAns;
			$questItem['enabled'] = $enabled;
			echo $this->load->view('exampaper/'.$lib->templateName().'/question_view', $questItem);
		}
		echo '				</div>
			</div>
		</div>';
	}
?>
	</div>


<?php 
	echo form_submit('submit', 'ส่งข้อสอบ', 'class="btn btn-primary"');
	echo form_close();
?>
</div>
