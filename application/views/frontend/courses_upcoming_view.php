	<!-- content begin -->
	<div id="content">
		<div class="container">
			<div class="row course-list">
			<?php
				foreach ($upcomingList as $item) {
					
					// $regbtn = anchor('courses/view/'.$item['course_id'], 'ลงทะเบียน', 'class="btn btn-sm btn-info"');
					// $link = anchor('courses/view/'.$item['course_id'], $item['name']);
					list($startdate, $starttime) = explode(' ', $item['starttime']);
					list($enddate, $endtime) = explode(' ', $item['endtime']);
					$fulldate = $this->misc->getFullDateTH($startdate)." ".$starttime;
					$datediff = $this->misc->dateDifference($item['starttime'], $item['endtime']);

					$dayRemain = date_diff(date_create(date('Y-m-d H:i:s',now())), date_create($item['starttime']));
					$fulldayRemain = $this->misc->dateDifference(date('Y-m-d H:i:s',now()), $item['starttime']);
					$warnactive = "";
					if ($dayRemain->d <= 2) $warnactive = " active";

					echo <<<HTML
				<div class="col-md-8 course-item{$warnactive}" data-href="{$this->misc->getHref('student/exam/doexam/'.$item['paper_id'])}">

					<div class="row inner" style="padding: 0;">
						<div class="picbox">
							<img src="assets-student/img/pic-blank-1.gif" data-original="img/clipboard.png" alt="">
						</div>
						<div class="col-md-8" style="margin-left: 0; padding: 0;float: left;">
							<div class="info">
								<h4>{$item['code']} {$item['subjectname']}</h4>
								<span class="author">
									{$item['papertitle']}
								</span>
								<div class="clearfix"></div>
								<div class="user-count">
									<i class="icon-calendar"></i>{$fulldate}
									<small>(อีก {$fulldayRemain})</small>
									<br><i class="icon-time"></i>{$datediff}
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
	<!-- content close -->