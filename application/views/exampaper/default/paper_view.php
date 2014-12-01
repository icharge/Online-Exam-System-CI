<div class="fullpaper">
	<p>
	การสอบออนไลน์ของวิชา <?php echo "$courseData[code] $courseData[name]"; ?><br>
	ชุด <?php echo "$paperData[title]<br>$paperData[description]<br><b>คำชี้แจง / กฎการสอบ</b><br>$paperData[rules]"; ?>
	</p>
	<h3 class="page-header" data-paper="<?php echo $paperData['paper_id'];?>">
		<?php echo $paperData['title'];?>
	</h3>
<?php
	$count = 1;
	foreach ($partData as $partItem) {
		echo <<<html
	<h3 class="chapter">{$partItem['title']}</h3>
html;
		$questData = $lib->_loadQuestion($partItem['part_id']);
		
		foreach ($questData as $questItem) {
			$questItem['number'] = $count++;
			$questItem['lib'] = $lib;
			$questItem['showAns'] = $showAns;
			$questItem['enabled'] = $enabled;
			echo $this->load->view('exampaper/'.$lib->templateName().'/question_view', $questItem);
		}
	}
?>
</div>
