<!doctype html>
<html lang="th">
<head>
	<base href="<?php echo base_url(); ?>">
	<meta charset="utf-8">
	<title>Online Examination System</title>
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link href="vendor/css/iCheck/all.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="vendor/css/messenger.css">
	<link rel="stylesheet" href="vendor/css/messenger-theme-air.css">
	<link href="assets-student/css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
	<!-- header begin -->
	<header>
		<div class="container">
			<div class="row">
				<div class="span12">
					<div id="logo">
						<div class="inner">
							<?php echo anchor('', '<img src="assets-student/img/logo.png" alt="">'); ?>
						</div>
					</div>

<?php $this->load->view('frontend/t_nav_view');?>

					<div class="clearfix"></div>
				</div>
			</div>
		</div>

	</header>
	<!-- header close -->
<?php
	$subheader['title'] = (isset($title)?$title:'');
	$subheader['subtitle'] = (isset($subtitle)?$subtitle:'');
	if (isset($enableSlider)) $this->load->view('frontend/t_slider_view');
	else $this->load->view('frontend/t_subheader_view', $subheader);

	if ((isset($statbar)?$statbar:false))
	{
?>
	<div class="call-to-action">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="inner">
						<h1>มีวิชาให้ลงสอบ <?php echo $coursesNum;?> รายการ จากทั้งหมด</h1>
						<a class="btn btn-large btn-blue pull-right">ลงทะเบียนเดี๋ยวนี้</a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
<?php
	}
?>