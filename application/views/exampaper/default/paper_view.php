<div class="content">
	<h2 class="page-header" data-paper="<?php echo $paperData['paper_id'];?>">
		<?php echo $paperData['title'];?>
	</h2>
<?php
	foreach ($partData as $partItem) {
		echo <<<html
	<h3 class="chapter">{$partItem['title']}</h3>
html;
		$questData = $lib->_loadQuestion($partItem['part_id']);
		$count = 1;
		foreach ($questData as $questItem) {
			$questItem['number'] = $count++;
			$questItem['lib'] = $lib;
			echo $this->load->view('exampaper/'.$lib->templateName().'/question_view', $questItem);
		}
	}
?>
</div>
