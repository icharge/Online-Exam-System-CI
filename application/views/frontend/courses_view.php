	<!-- content begin -->
	<div id="content">
		<div class="container">
			<div class="row course-list">
			<?php
				foreach ($courseslist as $item) {
					$desc = strip_tags($item['description']);
					$countstd = $this->courses->countStudentInCourse($item['course_id']);
					$regbtn = anchor('courses/view/'.$item['course_id'], 'ลงทะเบียน', 'class="btn btn-sm btn-info"');
					$link = anchor('courses/view/'.$item['course_id'], $item['name']);
					echo <<<HTML
				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>{$desc}</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4>{$link}</h4>
							<span class="author">{$item['shortname']}</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>{$countstd}</div>
							<div class="rating" style="margin-top: -8px">
								{$regbtn}
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
HTML;
				}

				echo '<div class="clearfix"></div>';
				echo $pagin; ?>

		</div>

	</div>
	<!-- content close -->