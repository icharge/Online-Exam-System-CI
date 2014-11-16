<div id="question-<?php echo $question_id;?>" data-chapterid="<?php echo $chapter_id; ?>" class="box box-solid nav-tabs-custom question-item collapsed-box">
	<ul class="box-header nav nav-tabs">
		<li class="pull-left header">
			<i class="fa fa-file-o"></i> <?php 
				echo "<span class=\"question-labelno\">ข้อ</span> <span class=\"question-no\">$number</span>";
			?>
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
	<!-- <div class="box-footer">
		<div class="row">

		</div>
	</div> -->
</div>