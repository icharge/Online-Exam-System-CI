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
			<div class="col-md-8">
				<?php
					echo form_label('คำตอบ <span class="text-danger">*</span>', 'answer['.$question_id.']');
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
			</div>
		</div>
		<div class="clearfix"></div>
<?php } elseif ($type == "boolean")
				{
					echo '<div class="col-md-8">';
					echo form_label('คำตอบ <span class="text-danger">*</span>', 'answer['.$question_id.']');
					echo $lib->_makeChoiceComp($question_id, '', 't').$lib->_makeChoiceComp($question_id, '', 'f');
					echo '</div><div class="clearfix"></div>';
					if (strtolower($answer_boolean) == "b")
						$answer = "ถูก";
					else
						$answer = "ผิด";
				}
				elseif ($type == "numeric")
				{
					echo '
	<div class="question-choices-label">
		<div class="col-md-5">
			<div class="form-group">'.
				form_label('คำตอบ <span class="text-danger">*</span>', 'answer['.$question_id.']').
				form_input(array(
					'name'=>'answer['.$question_id.']',
					'type'=>'text',
					'class'=>'form-control',
					'placeholder'=>'')).
			'</div>
		</div>
	</div>
	<div class="clearfix"></div>
';
					$answer = $answer_numeric;
				}
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