	<!-- content begin -->
	<div id="content">
		<div class="container">
			<div class="row course-list">
			<?php
				foreach ($reportRows as $item) {
					$teachers = $this->courses->getTeacherlist($item['course_id']);
					$htmlteas = "";
					foreach ($teachers as $teac) {
						if ($htmlteas == "") $htmlteas .= '<i class="icon-user"></i>';
						else $htmlteas .= '<i class="icon-user" style="visibility: hidden"></i>';
						$htmlteas .= "$teac[name] $teac[lname]<br>";
					}
					//Extract date/time
					// list($startdate, $starttime) = explode(' ', $item['starttime']);
					// list($enddate, $endtime) = explode(' ', $item['endtime']);
					// $fulldate = $this->misc->getFullDateTH($startdate)." ".$starttime;
					// $datediff = $this->misc->dateDifference($item['starttime'], $item['endtime']);

					echo <<<HTML
				<div class="col-md-8 col-md-offset-2 course-item" data-toggle="modal" data-target=".paperstdscore" href="{$this->misc->getHref('student/stats/paperscore/'.$item['course_id'])}">

					<div class="row inner" style="padding: 0;">
						<div class="picbox">
							<img src="assets-student/img/pic-blank-1.gif" data-original="img/clipboard.png" alt="">
						</div>
						<div class="col-md-8" style="margin-left: 0; margin-bottom: 5px; padding: 0;float: left;">
							<div class="info">
								<h4>{$item['code']} {$item['name']}</h4>
								<span class="author">
									
								</span>
								<div class="clearfix"></div>
								<div class="user-count">
								{$htmlteas}
								</div>
								<div class="rating" style="margin-top: -8px">
									
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

				</div>
HTML;
				}

				echo '<div class="clearfix"></div>';
				//echo $pagin;
				?>
			</div>
		</div>
	</div>
	<!-- content close -->
	<div class="modal fade paperstdscore" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		
	</div>