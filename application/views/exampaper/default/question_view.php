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
					if ($answer_choice == "1") $answer = $choice1;
					elseif ($answer_choice == "2") $answer = $choice2;
					elseif ($answer_choice == "3") $answer = $choice3;
					elseif ($answer_choice == "4") $answer = $choice4;
					elseif ($answer_choice == "5") $answer = $choice5;
					elseif ($answer_choice == "6") $answer = $choice6;

					echo form_label('คำตอบ <span class="text-danger">*</span>', 'answer['.$question_id.']');
					echo ((isset($choice1) && $choice1 != "") ? $lib->_makeChoiceComp($question_id, $choice1, 1, (($showAns)?($answer_choice == "1"?true:false):false) , $enabled) : "").
					((isset($choice2) && $choice2 != "") ? $lib->_makeChoiceComp($question_id, $choice2, 2, (($showAns)?($answer_choice == "2"?true:false):false) , $enabled) : "").
					((isset($choice3) && $choice3 != "") ? $lib->_makeChoiceComp($question_id, $choice3, 3, (($showAns)?($answer_choice == "3"?true:false):false) , $enabled) : "").
					((isset($choice4) && $choice4 != "") ? $lib->_makeChoiceComp($question_id, $choice4, 4, (($showAns)?($answer_choice == "4"?true:false):false) , $enabled) : "").
					((isset($choice5) && $choice5 != "") ? $lib->_makeChoiceComp($question_id, $choice5, 5, (($showAns)?($answer_choice == "5"?true:false):false) , $enabled) : "").
					((isset($choice6) && $choice6 != "") ? $lib->_makeChoiceComp($question_id, $choice6, 6, (($showAns)?($answer_choice == "6"?true:false):false) , $enabled) : "");

				?>
			</div>
		</div>
		<div class="clearfix"></div>
<?php } elseif ($type == "boolean")
				{
					echo '<div class="col-md-8">';
					echo form_label('คำตอบ <span class="text-danger">*</span>', 'answer['.$question_id.']');
					echo $lib->_makeChoiceComp($question_id, '', 't', (($showAns)?(strtolower($answer_boolean)=="t"?true:false):false) ,$enabled).
					$lib->_makeChoiceComp($question_id, '', 'f', (($showAns)?(strtolower($answer_boolean)=="f"?true:false):false) ,$enabled);
					echo '</div><div class="clearfix"></div>';
					if (strtolower($answer_boolean) == "t")
						$answer = "ถูก";
					else
						$answer = "ผิด";
				}
				elseif ($type == "numeric")
				{
					$inputops = array(
					'name'=>'answer['.$question_id.']',
					'type'=>'text',
					'class'=>'form-control',
					'placeholder'=>'',
					'value'=>(($showAns)?($answer_numeric):''));
					if (!$enabled) $inputops['readonly'] = "readonly";
					echo '
	<div class="question-choices-label">
		<div class="col-md-5">
			<div class="form-group">'.
				form_label('คำตอบ <span class="text-danger">*</span>', 'answer['.$question_id.']').
				form_input($inputops).
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