		<tr id="question-<?php echo $question_id;?>" href="<?php echo $this->misc->getHref('teacher/qwarehouse/editq/')."/$question_id";?>">
			<td><?php echo $question_id;?></td>
			<td><?php echo $question;?></td>
			<td><?php
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
			if ($type == "choice") {
				if ($answer_choice == "1") $answer = $choice1;
				elseif ($answer_choice == "2") $answer = $choice2;
				elseif ($answer_choice == "3") $answer = $choice3;
				elseif ($answer_choice == "4") $answer = $choice4;
				elseif ($answer_choice == "5") $answer = $choice5;
				elseif ($answer_choice == "6") $answer = $choice6;
			}
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
			list($date, $time) = explode(' ', $created_time);
		?></td>
			<td><?php echo $answer;?></td>
			<td><span class="jtooltip" title="<?php
				echo $this->misc->getFullDateTH($date)."<br>เวลา ".$time."\">".
				$created_by; ?>
				</span>
			</td>
		</tr>
<?php


	// list($date, $time) = explode(' ', $created_time);
	// $fullthdate = $this->misc->getFullDateTH($date);
	// $date = $this->misc->chrsDateToBudDate($date,"-","/");

	// echo "<span class=\"jtooltip\" title=\"$fullthdate\">$date $time</span>";
	// 			 echo $created_by ;
	// 				switch ($status) {
	// 					case 'active':
	// 						echo '<span class="text-success jtooltip" title="พร้อมนำไปใช้กับชุดข้อสอบ"><b>ใช้งานได้</b></span>';
	// 						break;
	// 					case 'inactive':
	// 						echo '<span class="text-muted jtooltip" title="ใช้งานไม่ได้ชั่วคราว"><b>ใช้งานไม่ได้</b></span>';
	// 						break;
	// 					case 'inuse':
	// 						echo '<span class="text-primary jtooltip" title="ถูกใช้ในชุดข้อสอบแล้ว ไม่สามารถเปลี่ยนแปลงได้"><b>นำไปใช้แล้ว</b></span>';
	// 						break;
	// 					case 'draft':
	// 						echo '<span class="jtooltip" title="ยังไม่ได้ใช้งานจริง"><b>ฉบับร่าง</b></span>';
	// 						break;
	// 					default:
	// 						echo '<span class="text-muted"><b>'.$status.'</b></span>';
	// 						break;
	// 				}
	//