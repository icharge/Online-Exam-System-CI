	<!-- content begin -->
	<div id="content">
		<div class="container">
			<div class="row fix">
				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4><a href="#">Course Name</a></h4>
							<span class="author">John Smith</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>10</div>
							<div class="rating">
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4><a href="#">Course Name</a></h4>
							<span class="author">John Smith</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>10</div>
							<div class="rating">
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4><a href="#">Course Name</a></h4>
							<span class="author">John Smith</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>10</div>
							<div class="rating">
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="span3 course-item">
					<div class="inner">
						<div class="hover">
							<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
						</div>
						<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
						<div class="info">
							<h4><a href="#">Course Name</a></h4>
							<span class="author">John Smith</span>
							<div class="clearfix"></div>
							<div class="user-count"><i class="icon-user"></i>10</div>
							<div class="rating">
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
								<span class="star-on"></span>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-4">
					<h3>Meet The Instructor</h3>
					<ul class="trainer-list">
						<li>
							<img src="assets-student/img/trainer-1.jpg">
							<div class="info">
								<h5><a href="#">Michael Bubble</a></h5>
								<h6>Project Manager</h6>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
							</div>
						</li>

						<li>
							<img src="assets-student/img/trainer-2.jpg">
							<div class="info">
								<h5><a href="#">Michael Bubble</a></h5>
								<h6>Project Manager</h6>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
							</div>
						</li>

						<li>
							<img src="assets-student/img/trainer-3.jpg">
							<div class="info">
								<h5><a href="#">Michael Bubble</a></h5>
								<h6>Project Manager</h6>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
							</div>
						</li>
					</ul>
				</div>

				<div class="col-md-8">
					<h3>Latest Courses</h3>
					<div class="row fix">
						<?php 
							foreach ($coursesList as $courseItem) {
								$desc = strip_tags($courseItem['description']);
								echo <<<HTML
						<div class="span2 course-item-small center">
							<div class="inner">
								<div class="hover">
									<span>{$desc}</span>
								</div>
								<img src="assets-student/img/pic-blank-1.gif" data-original="assets-student/img/course/pic (1).jpg" alt="">
								<div class="info">
									<h5><a href="#">{$courseItem['name']}</a></h5>
									<span class="author">{$courseItem['shortname']}</span>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
HTML;
							}

						?>

					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- content close -->


	<div class="call-to-action bg-blue">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="inner">
						<h1>Learn from 542 courses, from our 107 partners.</h1>
						<a class="btn btn-large btn-black pull-right">Try Now!</a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>