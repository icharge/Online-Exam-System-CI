					<ul id="mainmenu">
						<li><?php echo anchor('', 'หน้าแรก'); ?></li>
						<li><a href="#">วิชา</a>
							<ul>
								<li><?php echo anchor('subject-list', 'รายการวิชาทั้งหมด'); ?></li>
								<li><?php echo anchor('course-list', 'รายวิชาที่เปิดสอบ'); ?></li>
							</ul>
						</li>
						<li><?php echo anchor('news', 'ข่าวสาร'); ?></li>
						<li><?php echo anchor('contact', 'ติดต่อ'); ?></li>
						<li class="sign-in-btn"><?php echo anchor('auth/login', 'เข้าสู่ระบบ'); ?></li>
					</ul>