	<!-- Begin navbar -->
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Online Examination</a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					<li ng-class="{active: $routeSegment.startsWith('frontend')}"><a href="#/">Home</a></li>
					<li ng-class="{active: $routeSegment.startsWith('tea')}"><a href="#/teacher">Teacher</a></li>
					<li ng-class="{active: $routeSegment.startsWith('admin')}"><a href="#/admin">Administrator</a></li>
					<li class="dropdown">
						<a href class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href>Action</a></li>
							<li><a href>Another action</a></li>
							<li><a href>Something else here</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Dropdown header</li>
							<li><a href>Separated link</a></li>
							<li><a href>One more separated link</a></li>
						</ul>
					</li>
				</ul>
				<form class="navbar-form navbar-right">
					<input type="text" class="form-control col-lg-8" placeholder="Search">
				</form>
				<!--
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Link</a></li>
					<li class="dropdown open">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</li>
				</ul> -->
				Current route: <span ng-bind="$routeSegment.name"></span>
			</div>
		</div>
	</div>
	<!-- End navbar -->