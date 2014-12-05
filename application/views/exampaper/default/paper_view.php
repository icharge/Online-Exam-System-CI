<div class="fullpaper">
	<div class="row">
		<div class="col-md-6"><?php echo <<<html
			<h4 style="display: inline-block;">การสอบออนไลน์ของวิชา</h4> $courseData[code] $courseData[name]<br>
			<p style="padding-left: 10px">
				<b><u>คำอธิบาย</u></b><br>
				$paperData[description]<br>
				<b><u>คำชี้แจง / กฎการสอบ</u></b>
				<br> $paperData[rules]
			</p>
html;
?>		</div>
		<div class="col-md-6" style="text-align: right;">
			<?=$this->misc->getFullDateTH( date('Y-m-d') );?><br>
			เวลา <?=$paperData['starttime'];?> - <?=$paperData['endtime'];?><br><br>
			<b><u>ผู้สอน</u></b><br>
			<ul style="float: right;list-style: none;">
			<?php
				$teachers = $this->courses->getTeacherlist($courseData['course_id']);
				$i=0;
				foreach ($teachers as $teac) {
					if ($i < 3) echo "<li>$teac[name] $teac[lname]</li>";
					else {
						echo "...";
						break;
					}
					$i++;
				}
			?>
			</ul>
		</div>
	</div>
	
	<h3 class="page-header" data-paper="<?php echo $paperData['paper_id'];?>">
		<?php echo $paperData['title'];?>
	</h3>

<?php
	if ($useForm)
	{
		$attr = array(
			'name' => 'examfrm',
			'role' => 'form',
			'method' => 'post'
		);
		echo form_open($formlink, $attr);
		echo form_hidden('course', $courseData['course_id']);
		echo form_hidden('paper', $paperid);
	}
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
		$israndom = ($partItem['israndom']=='1'?true:false);
		$questData = $lib->_loadQuestion($partItem['part_id'], $israndom);
		
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
	if ($useForm)
	{
		echo form_submit('submit', 'ส่งข้อสอบ', 'class="btn btn-primary"');
		echo form_close();
	}
?>
</div>
