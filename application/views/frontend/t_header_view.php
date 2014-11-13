<!doctype html>
<html lang="th">
<head>
	<base href="<?php echo base_url(); ?>">
	<meta charset="utf-8">
	<title>Online Examination System</title>
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
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
							<a href="index.html">
								<img src="assets-student/img/logo.png" alt=""></a>
						</div>
					</div>

<?php $this->load->view('frontend/t_nav_view');?>

					<div class="clearfix"></div>
				</div>
			</div>
		</div>

	</header>
	<!-- header close -->
<?php $this->load->view('frontend/t_slider_view');?>
	<div class="call-to-action">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="inner">
						<h1>Learn from 542 courses, from our 107 partners.</h1>
						<a class="btn btn-large btn-blue pull-right">Try Now!</a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>