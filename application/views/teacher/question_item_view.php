<div id="question-<?php echo $question_id;?>" class="box nav-tabs-custom question-item">
	<ul class="nav nav-tabs">
		<li class="pull-left header">
			<i class="fa fa-file-o"></i> <?php echo "#$question_id <span class=\"text-muted\" style=\"font-size: 12px\">$chapter_name</span>";?>
		</li>
		<li class="pull-right">
			<a href="#" class="text-muted"><i class="fa fa-gear"></i></a>
		</li>
	</ul>
	<div class="box-body">
		<b>โจทย์คำถาม:</b>
		<div class="question-label"><?php echo $question;?></div>
		<b>รูปแบบ:</b>
		<p class="question-type-label"><?php
			switch ($type) {
				case 'choice':
					echo "ปรนัย";
					break;
				case 'numeric':
					echo "เติมคำตอบด้วยตัวเลข";
					break;
				case 'boolean':
					echo "ถูก / ผิด";
					break;
				case 'matching':
					echo "จับคู่";
					break;
			}
		?></p>
		<?php if ($type == "choice") { ?>
		<b>ตัวเลือก:</b>
		<div class="question-choices-label">
			<ul>
				<?php
					echo ((isset($choice1) && $choice1 != "") ? "<li>".$choice1."</li>" : "").
					((isset($choice2) && $choice2 != "") ? "<li>".$choice2."</li>" : "").
					((isset($choice3) && $choice3 != "") ? "<li>".$choice3."</li>" : "").
					((isset($choice4) && $choice4 != "") ? "<li>".$choice4."</li>" : "").
					((isset($choice5) && $choice5 != "") ? "<li>".$choice5."</li>" : "").
					((isset($choice6) && $choice6 != "") ? "<li>".$choice6."</li>" : "");

					if ($answer_choice == "1") $answer = $choice1;
					elseif ($answer_choice == "2") $answer = $choice2;
					elseif ($answer_choice == "3") $answer = $choice3;
					elseif ($answer_choice == "4") $answer = $choice4;
					elseif ($answer_choice == "5") $answer = $choice5;
					elseif ($answer_choice == "6") $answer = $choice6;
				?>
			</ul>
		</div>
		<?php }
			if ($type == "boolean")
			{
				if (strtolower($answer_boolean) == "b")
					$answer = "ถูก";
				else
					$answer = "ผิด";
			}
			elseif ($type == "numeric")
			{
				$answer = $answer_numeric;
			}
		?>

		<b>เฉลย:</b>
		<p class="question-answer-label"><?php echo $answer;?></p>
	</div>
	<div class="box-footer">
		<div class="row">
			<div class="col-md-4">
				<?php
					switch ($status) {
						case 'active':
							echo '<span class="text-success jtooltip" title="พร้อมนำไปใช้กับชุดข้อสอบ"><b>ใช้งานได้</b></span>';
							break;
						case 'inactive':
							echo '<span class="text-muted jtooltip" title="ใช้งานไม่ได้ชั่วคราว"><b>ใช้งานไม่ได้</b></span>';
							break;
						case 'inuse':
							echo '<span class="text-primary jtooltip" title="ถูกใช้ในชุดข้อสอบแล้ว ไม่สามารถเปลี่ยนแปลงได้"><b>นำไปใช้แล้ว</b></span>';
							break;
						case 'draft':
							echo '<span class="jtooltip" title="ยังไม่ได้ใช้งานจริง"><b>ฉบับร่าง</b></span>';
							break;
						default:
							echo '<span class="text-muted"><b>'.$status.'</b></span>';
							break;
					}
				?>
			</div>
			<div class="col-md-8 text-right">
				<span class="text-muted">สร้างเมื่อ ... โดย ...</span>
			</div>
		</div>
	</div>
</div>