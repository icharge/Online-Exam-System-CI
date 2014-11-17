<div id="question-<?php echo $question_id;?>" data-chapterid="<?php echo $chapter_id; ?>" class="box box-solid nav-tabs-custom question-item collapsed-box">
	<ul class="box-header nav nav-tabs">
		<li class="pull-left header">
			<i class="fa fa-file-o"></i> <?php 
				echo "<span class=\"question-labelno\">ข้อ</span> <span class=\"question-no\">$number</span>";
			?>
		</li>
	</ul>
	<div class="box-body">
		<div class="question-label"><?php echo $question;?></div>
		<?php if ($type == "choice") { ?>
		<div class="question-choices-label">
			<ul>
				<?php

					echo ((isset($choice1) && $choice1 != "") ? $lib->_makeChoiceComp($question_id, $choice1, 1) : "").
					((isset($choice2) && $choice2 != "") ? $lib->_makeChoiceComp($question_id, $choice2, 2) : "").
					((isset($choice3) && $choice3 != "") ? $lib->_makeChoiceComp($question_id, $choice3, 3) : "").
					((isset($choice4) && $choice4 != "") ? $lib->_makeChoiceComp($question_id, $choice4, 4) : "").
					((isset($choice5) && $choice5 != "") ? $lib->_makeChoiceComp($question_id, $choice5, 5) : "").
					((isset($choice6) && $choice6 != "") ? $lib->_makeChoiceComp($question_id, $choice6, 6) : "");

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
<?php 
/*
	echo <<<HTML
		<b>เฉลย:</b>
		<p class="question-answer-label">{$answer}</p>
HTML;
*/
?>
	</div>
	<!-- <div class="box-footer">
		<div class="row">

		</div>
	</div> -->
</div>