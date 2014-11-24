<div class="fullpaper">
	<h2 class="page-header" data-paper="<?php echo $paperData['paper_id'];?>">
		<?php echo $paperData['title'];?>
	</h2>
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
