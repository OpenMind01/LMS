@extends('layouts.default')

@section('content')

<div class="row">
	<div class="col-lg-6">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Theming Options</h3>
			</div>


			<!-- BASIC FORM ELEMENTS -->
			<!--===================================================-->
			<form class="panel-body form-horizontal form-padding">

				<div class="form-group">
					<label class="col-md-3 control-label" for="demo-readonly-input">Select Theme</label>
					<div class="col-md-9">
						<select class="form-control" name="template-switcher" id="templateSwitcher">
							<option value="theme-navy">No Theme</option>
							<option value="theme-light">Light</option>
							<option value="theme-navy">Navy</option>
							<option value="theme-ocean">Ocean</option>
							<option value="theme-lime">Lime</option>
							<option value="theme-purple">Purple</option>
							<option value="theme-dust">Dust</option>
							<option value="theme-mint">Mint</option>
							<option value="theme-yellow">Yellow</option>
							<option value="theme-well-red">Well Red</option>
							<option value="theme-coffee">Coffee</option>
							<option value="theme-dark">Dark</option>
						</select>
					</div>
				</div>

				<div class="form-group pad-ver">
					<label class="col-md-3 control-label">Theme Variant</label>
					<div class="col-md-9">
						<div class="col-md-6 pad-no">

							<!-- Radio Buttons -->
							<div class="radio">
								<label class="form-radio form-normal form-text"><input type="radio" name="style_type" value="a"> A Style</label>
							</div>
							<div class="radio">
								<label class="form-radio form-normal form-text"><input type="radio" name="style_type" value="b"> B Style</label>
							</div>
							<div class="radio">
								<label class="form-radio form-normal active form-text"><input type="radio" checked name="style_type" value="c"> C Style</label>
							</div>

						</div>
					</div>
				</div>
			</form>
			<!--===================================================-->
			<!-- END BASIC FORM ELEMENTS -->
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-7">

		<!--Network Line Chart-->
		<!--===================================================-->
		<div id="demo-panel-network" class="panel">
			<div class="panel-heading">
				<div class="panel-control">
					<button id="demo-panel-network-refresh" data-toggle="panel-overlay" data-target="#demo-panel-network" class="btn"><i class="fa fa-rotate-right"></i></button>
					<div class="btn-group">
						<button class="dropdown-toggle btn" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear"></i></button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</div>
				</div>
				<h3 class="panel-title">Network</h3>
			</div>

			<!--Morris line chart placeholder-->
			<div id="morris-chart-network" class="morris-full-content" style="position: relative;"><svg height="200" version="1.1" width="695" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;"><desc>Created with Raphaël 2.1.2</desc><defs></defs><path fill="none" stroke="#000000" d="M25,175H670" stroke-opacity="0" stroke-width="0.5" style=""></path><path fill="none" stroke="#000000" d="M25,137.5H670" stroke-opacity="0" stroke-width="0.5" style=""></path><path fill="none" stroke="#000000" d="M25,100H670" stroke-opacity="0" stroke-width="0.5" style=""></path><path fill="none" stroke="#000000" d="M25,62.5H670" stroke-opacity="0" stroke-width="0.5" style=""></path><path fill="none" stroke="#000000" d="M25,25H670" stroke-opacity="0" stroke-width="0.5" style=""></path><path fill="#cbdbef" stroke="none" d="M25,157C31.201923076923077,155.125,43.605769230769226,150.34375,49.80769230769231,149.5C56.00961538461539,148.65625,68.41346153846153,149.125,74.61538461538461,150.25C80.8173076923077,151.375,93.22115384615384,158.03125,99.42307692307692,158.5C105.625,158.96875,118.02884615384615,157.5625,124.23076923076923,154C130.43269230769232,150.4375,142.83653846153845,133,149.03846153846155,130C155.2403846153846,127,167.64423076923077,130.9375,173.84615384615384,130C180.0480769230769,129.0625,192.45192307692307,123.15625,198.65384615384613,122.5C204.85576923076923,121.84375,217.25961538461536,126.25,223.46153846153845,124.75C229.66346153846155,123.25,242.06730769230768,112.28125,248.26923076923077,110.5C254.47115384615387,108.71875,266.875,113.03125,273.0769230769231,110.5C279.2788461538462,107.96875,291.68269230769226,94.375,297.88461538461536,90.25C304.08653846153845,86.125,316.4903846153846,77.59375,322.6923076923077,77.5C328.8942307692308,77.40625,341.2980769230769,84.8125,347.5,89.5C353.7019230769231,94.1875,366.10576923076917,114.53125,372.30769230769226,115C378.50961538461536,115.46875,390.9134615384615,95.125,397.1153846153846,93.25C403.3173076923077,91.375,415.7211538461538,99.625,421.9230769230769,100C428.125,100.375,440.52884615384613,97.1875,446.7307692307692,96.25C452.9326923076923,95.3125,465.33653846153845,92.21875,471.53846153846155,92.5C477.74038461538464,92.78125,490.1442307692307,98.21875,496.3461538461538,98.5C502.5480769230769,98.78125,514.9519230769231,90.81249999999999,521.1538461538462,94.75C527.3557692307693,98.68749999999999,539.7596153846154,126.25,545.9615384615385,130C552.1634615384615,133.75,564.5673076923076,126.25,570.7692307692307,124.75C576.9711538461538,123.25,589.375,118.5625,595.5769230769231,118C601.7788461538462,117.4375,614.1826923076923,121.9375,620.3846153846154,120.25C626.5865384615385,118.5625,638.9903846153845,105.0625,645.1923076923076,104.5C651.3942307692307,103.9375,663.7980769230769,112.9375,670,115.75L670,175L25,175Z" fill-opacity="0.7" style="fill-opacity: 0.7;"></path><path fill="none" stroke="#8eb5e3" d="M25,157C31.201923076923077,155.125,43.605769230769226,150.34375,49.80769230769231,149.5C56.00961538461539,148.65625,68.41346153846153,149.125,74.61538461538461,150.25C80.8173076923077,151.375,93.22115384615384,158.03125,99.42307692307692,158.5C105.625,158.96875,118.02884615384615,157.5625,124.23076923076923,154C130.43269230769232,150.4375,142.83653846153845,133,149.03846153846155,130C155.2403846153846,127,167.64423076923077,130.9375,173.84615384615384,130C180.0480769230769,129.0625,192.45192307692307,123.15625,198.65384615384613,122.5C204.85576923076923,121.84375,217.25961538461536,126.25,223.46153846153845,124.75C229.66346153846155,123.25,242.06730769230768,112.28125,248.26923076923077,110.5C254.47115384615387,108.71875,266.875,113.03125,273.0769230769231,110.5C279.2788461538462,107.96875,291.68269230769226,94.375,297.88461538461536,90.25C304.08653846153845,86.125,316.4903846153846,77.59375,322.6923076923077,77.5C328.8942307692308,77.40625,341.2980769230769,84.8125,347.5,89.5C353.7019230769231,94.1875,366.10576923076917,114.53125,372.30769230769226,115C378.50961538461536,115.46875,390.9134615384615,95.125,397.1153846153846,93.25C403.3173076923077,91.375,415.7211538461538,99.625,421.9230769230769,100C428.125,100.375,440.52884615384613,97.1875,446.7307692307692,96.25C452.9326923076923,95.3125,465.33653846153845,92.21875,471.53846153846155,92.5C477.74038461538464,92.78125,490.1442307692307,98.21875,496.3461538461538,98.5C502.5480769230769,98.78125,514.9519230769231,90.81249999999999,521.1538461538462,94.75C527.3557692307693,98.68749999999999,539.7596153846154,126.25,545.9615384615385,130C552.1634615384615,133.75,564.5673076923076,126.25,570.7692307692307,124.75C576.9711538461538,123.25,589.375,118.5625,595.5769230769231,118C601.7788461538462,117.4375,614.1826923076923,121.9375,620.3846153846154,120.25C626.5865384615385,118.5625,638.9903846153845,105.0625,645.1923076923076,104.5C651.3942307692307,103.9375,663.7980769230769,112.9375,670,115.75" stroke-width="0" style=""></path><circle cx="25" cy="157" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="49.80769230769231" cy="149.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="74.61538461538461" cy="150.25" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="99.42307692307692" cy="158.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="124.23076923076923" cy="154" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="149.03846153846155" cy="130" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="173.84615384615384" cy="130" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="198.65384615384613" cy="122.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="223.46153846153845" cy="124.75" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="248.26923076923077" cy="110.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="273.0769230769231" cy="110.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="297.88461538461536" cy="90.25" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="322.6923076923077" cy="77.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="347.5" cy="89.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="372.30769230769226" cy="115" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="397.1153846153846" cy="93.25" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="421.9230769230769" cy="100" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="446.7307692307692" cy="96.25" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="471.53846153846155" cy="92.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="496.3461538461538" cy="98.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="521.1538461538462" cy="94.75" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="545.9615384615385" cy="130" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="570.7692307692307" cy="124.75" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="595.5769230769231" cy="118" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="620.3846153846154" cy="120.25" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="645.1923076923076" cy="104.5" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><circle cx="670" cy="115.75" r="0" fill="#3e80bd" stroke="none" stroke-width="1" style=""></circle><path fill="#2c87d5" stroke="none" d="M25,173.5C31.201923076923077,169.75,43.605769230769226,158.96875,49.80769230769231,158.5C56.00961538461539,158.03125,68.41346153846153,168.25,74.61538461538461,169.75C80.8173076923077,171.25,93.22115384615384,171.4375,99.42307692307692,170.5C105.625,169.5625,118.02884615384615,163.09375,124.23076923076923,162.25C130.43269230769232,161.40625,142.83653846153845,163.75,149.03846153846155,163.75C155.2403846153846,163.75,167.64423076923077,161.5,173.84615384615384,162.25C180.0480769230769,163,192.45192307692307,169.84375,198.65384615384613,169.75C204.85576923076923,169.65625,217.25961538461536,162.53125,223.46153846153845,161.5C229.66346153846155,160.46875,242.06730769230768,161.5,248.26923076923077,161.5C254.47115384615387,161.5,266.875,162.53125,273.0769230769231,161.5C279.2788461538462,160.46875,291.68269230769226,153.71875,297.88461538461536,153.25C304.08653846153845,152.78125,316.4903846153846,155.96875,322.6923076923077,157.75C328.8942307692308,159.53125,341.2980769230769,167.40625,347.5,167.5C353.7019230769231,167.59375,366.10576923076917,158.21875,372.30769230769226,158.5C378.50961538461536,158.78125,390.9134615384615,168.25,397.1153846153846,169.75C403.3173076923077,171.25,415.7211538461538,171.4375,421.9230769230769,170.5C428.125,169.5625,440.52884615384613,163.09375,446.7307692307692,162.25C452.9326923076923,161.40625,465.33653846153845,163.75,471.53846153846155,163.75C477.74038461538464,163.75,490.1442307692307,161.5,496.3461538461538,162.25C502.5480769230769,163,514.9519230769231,169.84375,521.1538461538462,169.75C527.3557692307693,169.65625,539.7596153846154,162.53125,545.9615384615385,161.5C552.1634615384615,160.46875,564.5673076923076,161.5,570.7692307692307,161.5C576.9711538461538,161.5,589.375,162.53125,595.5769230769231,161.5C601.7788461538462,160.46875,614.1826923076923,152.78125,620.3846153846154,153.25C626.5865384615385,153.71875,638.9903846153845,164.78125,645.1923076923076,165.25C651.3942307692307,165.71875,663.7980769230769,159.0625,670,157L670,175L25,175Z" fill-opacity="0.7" style="fill-opacity: 0.7;"></path><path fill="none" stroke="#1b72bc" d="M25,173.5C31.201923076923077,169.75,43.605769230769226,158.96875,49.80769230769231,158.5C56.00961538461539,158.03125,68.41346153846153,168.25,74.61538461538461,169.75C80.8173076923077,171.25,93.22115384615384,171.4375,99.42307692307692,170.5C105.625,169.5625,118.02884615384615,163.09375,124.23076923076923,162.25C130.43269230769232,161.40625,142.83653846153845,163.75,149.03846153846155,163.75C155.2403846153846,163.75,167.64423076923077,161.5,173.84615384615384,162.25C180.0480769230769,163,192.45192307692307,169.84375,198.65384615384613,169.75C204.85576923076923,169.65625,217.25961538461536,162.53125,223.46153846153845,161.5C229.66346153846155,160.46875,242.06730769230768,161.5,248.26923076923077,161.5C254.47115384615387,161.5,266.875,162.53125,273.0769230769231,161.5C279.2788461538462,160.46875,291.68269230769226,153.71875,297.88461538461536,153.25C304.08653846153845,152.78125,316.4903846153846,155.96875,322.6923076923077,157.75C328.8942307692308,159.53125,341.2980769230769,167.40625,347.5,167.5C353.7019230769231,167.59375,366.10576923076917,158.21875,372.30769230769226,158.5C378.50961538461536,158.78125,390.9134615384615,168.25,397.1153846153846,169.75C403.3173076923077,171.25,415.7211538461538,171.4375,421.9230769230769,170.5C428.125,169.5625,440.52884615384613,163.09375,446.7307692307692,162.25C452.9326923076923,161.40625,465.33653846153845,163.75,471.53846153846155,163.75C477.74038461538464,163.75,490.1442307692307,161.5,496.3461538461538,162.25C502.5480769230769,163,514.9519230769231,169.84375,521.1538461538462,169.75C527.3557692307693,169.65625,539.7596153846154,162.53125,545.9615384615385,161.5C552.1634615384615,160.46875,564.5673076923076,161.5,570.7692307692307,161.5C576.9711538461538,161.5,589.375,162.53125,595.5769230769231,161.5C601.7788461538462,160.46875,614.1826923076923,152.78125,620.3846153846154,153.25C626.5865384615385,153.71875,638.9903846153845,164.78125,645.1923076923076,165.25C651.3942307692307,165.71875,663.7980769230769,159.0625,670,157" stroke-width="0" style=""></path><circle cx="25" cy="173.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="49.80769230769231" cy="158.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="74.61538461538461" cy="169.75" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="99.42307692307692" cy="170.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="124.23076923076923" cy="162.25" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="149.03846153846155" cy="163.75" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="173.84615384615384" cy="162.25" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="198.65384615384613" cy="169.75" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="223.46153846153845" cy="161.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="248.26923076923077" cy="161.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="273.0769230769231" cy="161.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="297.88461538461536" cy="153.25" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="322.6923076923077" cy="157.75" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="347.5" cy="167.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="372.30769230769226" cy="158.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="397.1153846153846" cy="169.75" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="421.9230769230769" cy="170.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="446.7307692307692" cy="162.25" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="471.53846153846155" cy="163.75" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="496.3461538461538" cy="162.25" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="521.1538461538462" cy="169.75" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="545.9615384615385" cy="161.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="570.7692307692307" cy="161.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="595.5769230769231" cy="161.5" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="620.3846153846154" cy="153.25" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="645.1923076923076" cy="165.25" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle><circle cx="670" cy="157" r="0" fill="#3e80bd" stroke="#000000" stroke-width="1" stroke-opacity="0" style=""></circle></svg><div class="morris-hover morris-default-style" style="left: 13.92307692307692px; top: 92px; display: none;"><div class="morris-hover-row-label">2013 - 04</div><div class="morris-hover-point" style="color: #8eb5e3">
Download Speed:
22 Mb/s
</div><div class="morris-hover-point" style="color: #1b72bc">
Upload Speed:
6 Mb/s
</div></div></div>

			<!--Chart information-->
			<div class="panel-body bg-primary" style="position:relative;z-index:2">
				<div class="row">
					<div class="col-lg-6">
						<div class="row">
							<div class="col-xs-8">

								<!--Server load stat-->
								<div class="pad-ver media">
									<div class="media-left">
										<span class="icon-wrap icon-wrap-xs">
											<i class="fa fa-cloud fa-2x"></i>
										</span>
									</div>

									<div class="media-body">
										<p class="h3 text-thin media-heading">30%</p>
										<small class="text-uppercase">Server Load</small>
									</div>
								</div>

								<!--Progress bar-->
								<div class="progress progress-xs progress-dark-base mar-no">
									<div class="progress-bar progress-bar-light" style="width: 30%"></div>
								</div>

							</div>
							<div class="col-xs-4">
								<!-- User Online -->
								<div class="text-center">
									<span class="text-3x text-thin">43</span>
									<p>User Online</p>
								</div>
							</div>
						</div>

						<!--Additional text-->
						<div class="mar-ver">
							<small class="pad-btm"><em>* Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam.</em></small>
						</div>

					</div>
					<div class="col-lg-6">

						<!-- List Group -->
						<ul class="list-group bg-trans mar-no">
							<li class="list-group-item">
								<!-- Sparkline chart -->
								<div id="demo-chart-visitors" class="pull-right"><canvas width="110" height="22" style="display: inline-block; width: 110px; height: 22px; vertical-align: top;"></canvas></div> Visitors
							</li>
							<li class="list-group-item">
								<!-- Sparkline chart -->
								<div id="demo-chart-bounce-rate" class="pull-right"><canvas width="110" height="22" style="display: inline-block; width: 110px; height: 22px; vertical-align: top;"></canvas></div> Bounce rate
							</li>
							<li class="list-group-item">
								<span class="badge badge-success">11</span>
								Today sales
							</li>
							<li class="list-group-item">
								<span class="badge badge-warning">20</span>
								Broken links found
							</li>
						</ul>

					</div>
				</div>
			</div>


		</div>
		<!--===================================================-->
		<!--End network line chart-->

	</div>
	<div class="col-lg-5">
		<div class="row">
			<div class="col-sm-6 col-lg-6">

				<!--Sparkline Area Chart-->
				<div class="panel panel-success panel-colorful text-center">
					<div class="panel-body">

						<!--Placeholder-->
						<div id="demo-sparkline-area"><canvas width="110" height="50" style="display: inline-block; width: 110px; height: 50px; vertical-align: top;"></canvas></div>

					</div>
					<div class="bg-light pad-ver">
						<h4 class="mar-no text-thin"><i class="fa fa-hdd-o"></i> HDD Usage</h4>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-6">

				<!--Sparkline Line Chart-->
				<div class="panel panel-info panel-colorful text-center">
					<div class="panel-body">

						<!--Placeholder-->
						<div id="demo-sparkline-line"><canvas width="110" height="50" style="display: inline-block; width: 110px; height: 50px; vertical-align: top;"></canvas></div>

					</div>
					<div class="bg-light pad-ver">
						<h4 class="mar-no text-thin">Earning</h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-lg-6">

				<!--Sparkline bar chart -->
				<div class="panel panel-purple panel-colorful text-center">
					<div class="panel-body">

						<!--Placeholder-->
						<div id="demo-sparkline-bar" class="box-inline"><canvas width="97" height="50" style="display: inline-block; width: 97px; height: 50px; vertical-align: top;"></canvas></div>

					</div>
					<div class="bg-light pad-ver">
						<h4 class="mar-no text-thin">Sales</h4>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-6">

				<!--Sparkline pie chart -->
				<div class="panel panel-mint panel-colorful text-center">
					<div class="panel-body">

						<!--Placeholder-->
						<div id="demo-sparkline-pie" class="box-inline "><canvas width="50" height="50" style="display: inline-block; width: 50px; height: 50px; vertical-align: top;"></canvas></div>

					</div>
					<div class="bg-light pad-ver">
						<h4 class="mar-no text-thin">
							Top Movie
						</h4>
					</div>
				</div>
			</div>
		</div>


		<!--Extra Small Weather Widget-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="panel middle">
			<div class="media-left pad-all">
				<canvas id="demo-weather-xs-icon" width="48" height="48"></canvas>
			</div>

			<div class="media-body">
				<p class="text-2x mar-no text-thin text-mint">25°</p>
				<p class="text-muted mar-no">Partly Cloudy Day</p>
			</div>
		</div>

		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End Extra Small Weather Widget-->


	</div>
</div>

<div class="row">
	<div class="col-sm-6 col-lg-3">

		<!--Registered User-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="panel media pad-all">
			<div class="media-left">
				<span class="icon-wrap icon-wrap-sm icon-circle bg-success">
				<i class="fa fa-user fa-2x"></i>
				</span>
			</div>

			<div class="media-body">
				<p class="text-2x mar-no text-thin">241</p>
				<p class="text-muted mar-no">Registered User</p>
			</div>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

	</div>
	<div class="col-sm-6 col-lg-3">

		<!--New Order-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="panel media pad-all">
			<div class="media-left">
				<span class="icon-wrap icon-wrap-sm icon-circle bg-info">
				<i class="fa fa-shopping-cart fa-2x"></i>
				</span>
			</div>

			<div class="media-body">
				<p class="text-2x mar-no text-thin">543</p>
				<p class="text-muted mar-no">New Order</p>
			</div>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

	</div>
	<div class="col-sm-6 col-lg-3">

		<!--Comments-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="panel media pad-all">
			<div class="media-left">
				<span class="icon-wrap icon-wrap-sm icon-circle bg-warning">
				<i class="fa fa-comment fa-2x"></i>
				</span>
			</div>

			<div class="media-body">
				<p class="text-2x mar-no text-thin">34</p>
				<p class="text-muted mar-no">Comments</p>
			</div>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

	</div>
	<div class="col-sm-6 col-lg-3">

		<!--Sales-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="panel media pad-all">
			<div class="media-left">
				<span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
				<i class="fa fa-dollar fa-2x"></i>
				</span>
			</div>

			<div class="media-body">
				<p class="text-2x mar-no text-thin">654</p>
				<p class="text-muted mar-no">Sales</p>
			</div>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

	</div>
</div>

<div class="row">
	<div class="col-lg-7">

		<!--User table-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="panel">
			<div class="panel-heading">
				<div class="panel-control">
					<a class="fa fa-question-circle fa-lg fa-fw unselectable add-tooltip" href="#" data-original-title="&lt;h4 class='text-thin'&gt;Information&lt;/h4&gt;&lt;p style='width:150px'&gt;This is an information bubble to help the user.&lt;/p&gt;" data-html="true" title=""></a>
				</div>
				<h3 class="panel-title">Member</h3>
			</div>

			<div class="panel-body">
				<div class="pad-btm form-inline">
					<div class="row">
						<div class="col-sm-6 table-toolbar-left">
							<button id="demo-btn-addrow" class="btn btn-purple btn-labeled fa fa-plus">Add</button>
							<div class="btn-group btn-group">
								<button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
								<button class="btn btn-default"><i class="fa fa-trash"></i></button>
							</div>
						</div>
						<div class="col-sm-6 table-toolbar-right">
							<div class="form-group">
								<input id="demo-input-search2" type="text" placeholder="Search" class="form-control" autocomplete="off">
							</div>
							<div class="btn-group">
								<div class="btn-group">
									<button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
										<i class="fa fa-cog"></i>
										<span class="caret"></span>
									</button>
									<ul role="menu" class="dropdown-menu dropdown-menu-right">
										<li><a href="#">Action</a></li>
										<li><a href="#">Another action</a></li>
										<li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li><a href="#">Separated link</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width:4ex">ID</th>
								<th>Name</th>
								<th>Balance</th>
								<th class="text-center">Subscription</th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="#" class="btn-link">NY531</a></td>
								<td>Steve N. Horton</td>
								<td>$24.98</td>
								<td class="text-center"><span class="label label-table label-success">Enterprise</span></td>
								<td class="text-right">
									<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" href="#" data-original-title="Edit" data-container="body"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<tr>
								<td><a href="#" class="btn-link">NY532</a></td>
								<td>Scott S. Calabrese</td>
								<td>$543.65</td>
								<td class="text-center"><span class="label label-table label-info">Trial</span></td>
								<td class="text-right">
									<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" href="#" data-original-title="Edit" data-container="body"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<tr>
								<td><a href="#" class="btn-link">NY533</a></td>
								<td>Teresa L. Doe</td>
								<td>$753.95</td>
								<td class="text-center"><span class="label label-table label-purple">Premium</span></td>
								<td class="text-right">
									<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" href="#" data-original-title="Edit" data-container="body"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<tr>
								<td><a href="#" class="btn-link">NY534</a></td>
								<td>Lucy Doe</td>
								<td>$234.86</td>
								<td class="text-center"><span class="label label-table label-info">Trial</span></td>
								<td class="text-right">
									<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" href="#" data-original-title="Edit" data-container="body"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<tr>
								<td><a href="#" class="btn-link">NY535</a></td>
								<td>Charles S Boyle</td>
								<td>$75.32</td>
								<td class="text-center"><span class="label label-table label-success">Enterprise</span></td>
								<td class="text-right">
									<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" href="#" data-original-title="Edit" data-container="body"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<tr>
								<td><a href="#" class="btn-link">NY536</a></td>
								<td>Paul Aguilar</td>
								<td>$193.64</td>
								<td class="text-center"><span class="label label-table label-info">Trial</span></td>
								<td class="text-right">
									<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" href="#" data-original-title="Edit" data-container="body"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<tr>
								<td><a href="#" class="btn-link">NY537</a></td>
								<td>Betty Murphy</td>
								<td>$41.84</td>
								<td class="text-center"><span class="label label-table label-purple">Premium</span></td>
								<td class="text-right">
									<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" href="#" data-original-title="Edit" data-container="body"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<tr>
								<td><a href="#" class="btn-link">NY538</a></td>
								<td>Steve N. Horton</td>
								<td>$534.77</td>
								<td class="text-center"><span class="label label-table label-success">Enterprise</span></td>
								<td class="text-right">
									<a class="btn btn-xs btn-default add-tooltip" data-toggle="tooltip" href="#" data-original-title="Edit" data-container="body"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-xs btn-danger add-tooltip" data-toggle="tooltip" href="#" data-original-title="Delete" data-container="body"><i class="fa fa-times"></i></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End user table-->


		<div class="row">

			<!--Large tile (Visit Today)-->
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			<div class="col-sm-6 col-md-4">
				<div class="panel panel-dark panel-colorful">
					<div class="panel-body text-center">
						<p class="text-uppercase mar-btm text-sm">Visit Today</p>
						<i class="fa fa-users fa-5x"></i>
						<hr>
						<p class="h2 text-thin">254,487</p>
						<small><span class="text-semibold">7%</span> Higher than yesterday</small>
					</div>
				</div>
			</div>
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			<!--End large tile (Visit Today)-->


			<!--Large tile (Comments)-->
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			<div class="col-sm-6 col-md-4">
				<div class="panel panel-danger panel-colorful">
					<div class="panel-body text-center">
						<p class="text-uppercase mar-btm text-sm">Comments</p>
						<i class="fa fa-comment fa-5x"></i>
						<hr>
						<p class="h2 text-thin">873</p>
						<small><span class="text-semibold"><i class="fa fa-unlock-alt fa-fw"></i> 154</span> Unapproved comments</small>
					</div>
				</div>
			</div>
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			<!--Large tile (Comments)-->


			<!--Large tile (New orders)-->
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			<div class="col-sm-12 col-md-4">
				<div class="panel panel-primary panel-colorful">
					<div class="panel-body text-center">
						<p class="text-uppercase mar-btm text-sm">New Orders</p>
						<i class="fa fa-shopping-cart fa-5x"></i>
						<hr>
						<p class="h2 text-thin">2,423</p>
						<small><span class="text-semibold"><i class="fa fa-shopping-cart fa-fw"></i> 954</span> Sales in this month</small>
					</div>
				</div>
			</div>
			<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
			<!--End Large tile (New orders)-->


		</div>


		<!--Simple pricing table-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="row">

			<!--Personal Plan-->
			<div class="col-sm-6 col-md-4">
				<div class="panel plan">
					<div class="panel-body">
						<span class="plan-title">Personal</span>
						<p class="text-semibold text-mint">$99/year</p>
						<div class="plan-icon">
							<i class="fa fa-mobile-phone"></i>
						</div>

						<p class="text-muted pad-btm">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
						</p>
						<button class="btn btn-block btn-primary btn-lg">Choose</button>
					</div>
				</div>
			</div>

			<!--Premium Plan-->
			<div class="col-sm-6 col-md-4">
				<div class="panel plan">
					<div class="panel-body">
						<span class="plan-title">Premium</span>
						<p class="text-semibold text-mint">$299/year</p>
						<div class="plan-icon">
							<i class="fa fa-laptop"></i>
						</div>

						<p class="text-muted pad-btm">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
						</p>
						<button class="btn btn-block btn-mint btn-lg">Choose</button>
					</div>
				</div>
			</div>

			<!--Enterprise Plan-->
			<div class="col-sm-12 col-md-4">
				<div class="panel plan">
					<div class="panel-body">
						<span class="plan-title">Enterprise</span>
						<p class="text-semibold text-mint">$399/year</p>
						<div class="plan-icon">
							<i class="fa fa-desktop"></i>
						</div>

						<p class="text-muted pad-btm">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
						</p>
						<button class="btn btn-block btn-purple btn-lg">Choose</button>
					</div>
				</div>
			</div>

		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End Simple pricing table-->


		<div class="row">
			<div class="col-lg-6">

				<!--List Todo-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<div class="panel panel-dark panel-colorful">
					<div class="panel-heading">
						<div class="panel-control">
							<button class="btn btn-default"><i class="fa fa-gear"></i></button>
						</div>
						<h3 class="panel-title">To do list</h3>
					</div>
					<div class="pad-ver">
						<ul class="list-group bg-trans list-todo mar-no">
							<li class="list-group-item">
								<label class="form-checkbox form-icon form-text">
									<input type="checkbox">
									<span>Find an idea.</span>
								</label>
							</li>
							<li class="list-group-item">
								<label class="form-checkbox form-icon active form-text">
									<input type="checkbox" checked="">
									<span>Do some work</span>
								</label>
							</li>
							<li class="list-group-item">
								<label class="form-checkbox form-icon active form-text">
									<input type="checkbox" checked="">
									<span>Redesign my logo</span>
								</label>
							</li>
							<li class="list-group-item">
								<label class="form-checkbox form-icon form-text">
									<input type="checkbox">
									<span>Read the book</span>
								</label>
							</li>
							<li class="list-group-item">
								<label class="form-checkbox form-icon form-text">
									<input type="checkbox">
									<span>Upgrade server</span>
								</label>
							</li>
							<li class="list-group-item">
								<label class="form-checkbox form-icon active form-text">
									<input type="checkbox" checked="">
									<span>Redesign my logo</span>
								</label>
							</li>
							<li class="list-group-item">
								<label class="form-checkbox form-icon active form-text">
									<input type="checkbox" checked="">
									<span>Redesign my logo</span>
								</label>
							</li>
							<li class="list-group-item">
								<label class="form-checkbox form-icon form-text">
									<input type="checkbox">
									<span>Read the book</span>
								</label>
							</li>
						</ul>
					</div>
					<div class="input-group pad-all">
						<input type="text" class="form-control" placeholder="New task" autocomplete="off">
						<span class="input-group-btn">
							<button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
						</span>
					</div>
				</div>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End todo list-->

			</div>
			<div class="col-lg-6">
				<div class="row">
					<div class="col-sm-6 col-md-4 col-lg-6">

						<!--Sales tile-->
						<div class="panel panel-primary panel-colorful">
							<div class="pad-all text-center">
								<span class="text-5x text-thin">53</span>
								<p>Sales</p>
								<i class="fa fa-shopping-cart"></i>
							</div>
						</div>

					</div>
					<div class="col-sm-6 col-md-4 col-lg-6">

						<!--Messages tile-->
						<div class="panel panel-warning panel-colorful">
							<div class="pad-all text-center">
								<span class="text-5x text-thin">68</span>
								<p>Messages</p>
								<i class="fa fa-envelope"></i>
							</div>
						</div>

					</div>
					<div class="col-sm-6 col-md-4 col-lg-6">

						<!--Projects-->
						<div class="panel panel-purple panel-colorful">
							<div class="pad-all text-center">
								<span class="text-5x text-thin">32</span>
								<p>Projects</p>
								<i class="fa fa-code"></i>
							</div>
						</div>

					</div>
					<div class="col-sm-6 col-md-4 col-lg-6">

						<!--Reports-->
						<div class="panel panel-dark panel-colorful">
							<div class="pad-all text-center">
								<span class="text-5x text-thin">12</span>
								<p>Reports</p>
								<i class="fa fa-file-text"></i>
							</div>
						</div>

					</div>
					<div class="col-sm-6 col-md-4 col-lg-6">

						<!--New Items-->
						<div class="panel panel-info panel-colorful">
							<div class="pad-all text-center">
								<span class="text-5x text-thin">254</span>
								<p>New Items</p>
								<i class="fa fa-plus-circle"></i>
							</div>
						</div>

					</div>
					<div class="col-sm-6 col-md-4 col-lg-6">

						<!--Task-->
						<div class="panel panel-success panel-colorful">
							<div class="pad-all text-center">
								<span class="text-5x text-thin">52</span>
								<p>Task</p>
								<i class="fa fa-tasks"></i>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="col-lg-5">
		<div class="row">
			<div class="col-sm-6 col-lg-6">

				<!--Tile with progress bar (Comments)-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<div class="panel panel-mint panel-colorful">
					<div class="pad-all media">
						<div class="media-left">
							<span class="icon-wrap icon-wrap-xs">
								<i class="fa fa-comment fa-3x"></i>
							</span>
						</div>
						<div class="media-body">
							<p class="h3 text-thin media-heading">45.9%</p>
							<small class="text-uppercase">comments</small>
						</div>
					</div>

					<div class="progress progress-xs progress-dark-base mar-no">
						<div role="progressbar" aria-valuenow="45.9" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-light" style="width: 45.9%"></div>
					</div>

					<div class="pad-all text-right">
						<small><span class="text-semibold"><i class="fa fa-unlock-alt fa-fw"></i> 312</span> Unapproved comments</small>
					</div>
				</div>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--End Tile with progress bar (Comments)-->

			</div>
			<div class="col-sm-6 col-lg-6">

				<!--Tile with progress bar (New Orders)-->
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<div class="panel panel-purple panel-colorful">
					<div class="pad-all media">
						<div class="media-left">
							<span class="icon-wrap icon-wrap-xs">
								<i class="fa fa-shopping-cart fa-fw fa-3x"></i>
							</span>
						</div>
						<div class="media-body">
							<p class="h3 text-thin media-heading">5,345</p>
							<small class="text-uppercase">New Orders</small>
						</div>
					</div>

					<div class="progress progress-xs progress-dark-base mar-no">
						<div role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-light" style="width: 75%"></div>
					</div>

					<div class="pad-all text-right">
						<small><span class="text-semibold"><i class="fa fa-shopping-cart fa-fw"></i> 954</span> Sales in this month</small>
					</div>
				</div>
				<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				<!--Tile with progress bar (New Orders)-->

			</div>
		</div>

		<!--Morris donut chart-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="panel">
			<div class="panel-heading">
				<div class="panel-control">
					<button data-dismiss="panel" class="btn btn-default">
						<i class="fa fa-times"></i>
					</button>
				</div>
				<h3 class="panel-title">Services</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6 text-center">

						<!--Chart placeholder -->
						<div id="demo-morris-donut" class="morris-donut"><svg height="200" version="1.1" width="200" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.078125px;"><desc>Created with Raphaël 2.1.2</desc><defs></defs><path fill="none" stroke="#c686be" d="M100,160A60,60,0,0,0,156.95770043472743,118.86320124442965" stroke-width="2" opacity="0" style="opacity: 0;"></path><path fill="#c686be" stroke="#ffffff" d="M100,163A63,63,0,0,0,159.8055854564638,119.80636130665113L180.69007561586386,126.72286842960867A85,85,0,0,1,100,185Z" stroke-width="3" style=""></path><path fill="none" stroke="#986291" d="M156.95770043472743,118.86320124442965A60,60,0,0,0,46.2086089202603,73.42019101448432" stroke-width="2" opacity="1" style="opacity: 1;"></path><path fill="#986291" stroke="#ffffff" d="M159.8055854564638,119.80636130665113A63,63,0,0,0,43.51903936627332,72.09120056520852L19.312913380390455,60.13028652172646A90,90,0,0,1,185.4365506520911,128.29480186664446Z" stroke-width="3" style=""></path><path fill="none" stroke="#ab6fa3" d="M46.2086089202603,73.42019101448432A60,60,0,0,0,99.98115044438853,159.9999970391187" stroke-width="2" opacity="0" style="opacity: 0;"></path><path fill="#ab6fa3" stroke="#ffffff" d="M43.51903936627332,72.09120056520852A63,63,0,0,0,99.98020796660796,162.99999689107466L99.97329646288375,184.99999580541817A85,85,0,0,1,23.795529303702097,62.345270603852775Z" stroke-width="3" style=""></path><text x="100" y="90" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" font-size="15px" font-weight="800" transform="matrix(1.4679,0,0,1.4679,-46.789,-46.8913)" stroke-width="0.6812499999999999" style="text-anchor: middle; font-style: normal; font-variant: normal; font-weight: 800; font-size: 15px; line-height: normal; font-family: Arial;"><tspan dy="5.8203125">Sales</tspan></text><text x="100" y="110" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" font-size="14px" transform="matrix(1.0483,0,0,1.0483,-4.8321,-4.854)" stroke-width="0.95390625" style="text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-size: 14px; line-height: normal; font-family: Arial;"><tspan dy="5.4296875">30</tspan></text></svg></div>

					</div>
					<div class="col-sm-6">
						<div class="pad-ver">
							<p class="text-lg">Upgrade Progress</p>
							<div class="progress progress-sm">
								<div role="progressbar" style="width: 15%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="15" class="progress-bar progress-bar-purple">
									<span class="sr-only">15%</span>
								</div>
							</div>
							<small class="text-muted">15% Completed</small>
						</div>
						<div class="pad-ver">
							<p class="text-lg">Database</p>
							<div class="progress progress-sm">
								<div role="progressbar" style="width: 70%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" class="progress-bar progress-bar-success">
									<span class="sr-only">70%</span>
								</div>
							</div>
							<small class="text-muted">70% Completed</small>
						</div>

						<hr>
						<p class="text-muted">Lorem ipsum dolor sit amet, consectetuer <a data-title="45%" class="add-tooltip text-semibold" href="#" data-original-title="" title="">adipiscing elit</a>, sed diam nonummy nibh. Lorem ipsum dolor sit amet.</p>
						<small class="text-muted"><em>Last Update : Des 12, 2014</em></small>
					</div>
				</div>
			</div>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End Morris donut chart-->


		<!--Chat Widget-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div class="panel">

			<!--Chat widget header-->
			<div class="panel-heading">
				<div class="panel-control">
					<div class="btn-group">
						<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#demo-chat-body"><i class="fa fa-chevron-down"></i></button>
						<button type="button" class="btn btn-default" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#">Available</a></li>
							<li><a href="#">Busy</a></li>
							<li><a href="#">Away</a></li>
							<li class="divider"></li>
							<li><a id="demo-connect-chat" href="#" class="disabled-link" data-target="#demo-chat-body">Connect</a></li>
							<li><a id="demo-disconnect-chat" href="#" data-target="#demo-chat-body">Disconect</a></li>
						</ul>
					</div>
				</div>
				<h3 class="panel-title">Chat</h3>
			</div>

			<!--Chat widget body-->
			<div id="demo-chat-body" class="collapse in">
				<div class="nano has-scrollbar" style="height:500px">
					<div class="nano-content pad-all" tabindex="0" style="right: -15px;">
						<ul class="list-unstyled media-block">
							<li class="mar-btm">
								<div class="media-left">
									<img src="/assets/img/av1.png" class="img-circle img-sm" alt="Profile Picture">
								</div>
								<div class="media-body pad-hor">
									<div class="speech">
										<a href="#" class="media-heading">John Doe</a>
										<p>Hello Lucy, how can I help you today ?</p>
										<p class="speech-time">
										<i class="fa fa-clock-o fa-fw"></i>09:23AM
										</p>
									</div>
								</div>
							</li>
							<li class="mar-btm">
								<div class="media-right">
									<img src="/assets/img/av4.png" class="img-circle img-sm" alt="Profile Picture">
								</div>
								<div class="media-body pad-hor speech-right">
									<div class="speech">
										<a href="#" class="media-heading">Lucy Doe</a>
										<p>Hi, I want to buy a new shoes.</p>
										<p class="speech-time">
											<i class="fa fa-clock-o fa-fw"></i> 09:23AM
										</p>
									</div>
								</div>
							</li>
							<li class="mar-btm">
								<div class="media-left">
									<img src="/assets/img/av1.png" class="img-circle img-sm" alt="Profile Picture">
								</div>
								<div class="media-body pad-hor">
									<div class="speech">
										<a href="#" class="media-heading">John Doe</a>
										<p>Shipment is free. You'll get your shoes tomorrow!</p>
										<p class="speech-time">
											<i class="fa fa-clock-o fa-fw"></i> 09:25
										</p>
									</div>
								</div>
							</li>
							<li class="mar-btm">
								<div class="media-right">
									<img src="/assets/img/av4.png" class="img-circle img-sm" alt="Profile Picture">
								</div>
								<div class="media-body pad-hor speech-right">
									<div class="speech">
										<a href="#" class="media-heading">Lucy Doe</a>
										<p>Wow, that's great!</p>
										<p class="speech-time">
											<i class="fa fa-clock-o fa-fw"></i> 09:27
										</p>
									</div>
								</div>
							</li>
							<li class="mar-btm">
								<div class="media-right">
									<img src="/assets/img/av4.png" class="img-circle img-sm" alt="Profile Picture">
								</div>
								<div class="media-body pad-hor speech-right">
									<div class="speech">
										<a href="#" class="media-heading">Lucy Doe</a>
										<p>Ok. Thanks for the answer. Appreciated.</p>
										<p class="speech-time">
										<i class="fa fa-clock-o fa-fw"></i> 09:28
										</p>
									</div>
								</div>
							</li>
							<li class="mar-btm">
								<div class="media-left">
									<img src="/assets/img/av1.png" class="img-circle img-sm" alt="Profile Picture">
								</div>
								<div class="media-body pad-hor">
									<div class="speech">
										<a href="#" class="media-heading">John Doe</a>
										<p>You are welcome! <br> Is there anything else I can do for you today?</p>
										<p class="speech-time">
											<i class="fa fa-clock-o fa-fw"></i> 09:30
										</p>
									</div>
								</div>
							</li>
							<li class="mar-btm">
								<div class="media-right">
									<img src="/assets/img/av4.png" class="img-circle img-sm" alt="Profile Picture">
								</div>
								<div class="media-body pad-hor speech-right">
									<div class="speech">
										<a href="#" class="media-heading">Lucy Doe</a>
										<p>Nope, That's it.</p>
										<p class="speech-time">
											<i class="fa fa-clock-o fa-fw"></i> 09:31
										</p>
									</div>
								</div>
							</li>
							<li class="mar-btm">
								<div class="media-left">
									<img src="/assets/img/av1.png" class="img-circle img-sm" alt="Profile Picture">
								</div>
								<div class="media-body pad-hor">
									<div class="speech">
										<a href="#" class="media-heading">John Doe</a>
										<p>Thank you for contacting us today</p>
										<p class="speech-time">
											<i class="fa fa-clock-o fa-fw"></i> 09:32
										</p>
									</div>
								</div>
							</li>
						</ul>
					</div>
				<div class="nano-pane"><div class="nano-slider" style="height: 234px; transform: translate(0px, 0px);"></div></div></div>



				<!--Chat widget footer-->
				<div class="panel-footer">
					<div class="row">
						<div class="col-xs-9">
							<input type="text" placeholder="Enter your text" class="form-control chat-input">
						</div>
						<div class="col-xs-3">
							<button class="btn btn-primary btn-block" type="submit">Send</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End Chat Widget-->


		<!--Weather Widget-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<div id="demo-weather-widget" class="panel panel-mint panel-colorful text-center">
			<div class="panel-body">

				<!--Weather widget body-->
				<div class="row pad-top">
					<div class="col-xs-6">
						<canvas id="demo-weather-icon-1" width="98" height="98"></canvas>
					</div>
					<div class="col-xs-6">
						<p class="text-4x">27°</p>
						<p class="text-semibold">Partly Cloudy Day</p>
					</div>
				</div>

				<h4 class="mar-no pad-top">San Jose, CA</h4>
				<p>Today</p>

				<hr>

				<!--Weather widget footer-->
				<ul class="list-unstyled text-center clearfix">
					<li class="col-xs-3">
						<canvas id="demo-weather-icon-2" width="32" height="32"></canvas>
						<p class="text-sm mar-no">Saturday</p>
						<p>25 °C</p>
					</li>
					<li class="col-xs-3">
						<canvas id="demo-weather-icon-3" width="32" height="32"></canvas>
						<p class="text-sm mar-no">Sunday</p>
						<p>22 °C</p>
					</li>
					<li class="col-xs-3">
						<canvas id="demo-weather-icon-4" width="32" height="32"></canvas>
						<p class="text-sm mar-no">Monday</p>
						<p>20 °C</p>
					</li>
					<li class="col-xs-3">
						<canvas id="demo-weather-icon-5" width="32" height="32"></canvas>
						<p class="text-sm mar-no">Monday</p>
						<p>28 °C</p>
					</li>
				</ul>
			</div>
		</div>
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End Weather Widget-->

	</div>
</div>
<div class="row">
						<div class="col-md-6 col-lg-3">
					
							<!--Profile Widget-->
							<!--===================================================-->
							<div class="panel widget">
								<div class="widget-header bg-primary"></div>
								<div class="widget-body text-center">
									<img alt="Profile Picture" class="widget-img img-circle img-border-light" src="/assets/img/av2.png">
									<h4 class="mar-no">John Doe</h4>
									<p class="text-muted mar-btm">Administrator</p>
					
									<div class="pad-ver">
										<button class="btn btn-primary">Follow</button>
										<button class="btn btn-success">Message</button>
									</div>
								</div>
							</div>
							<!--===================================================-->
					
						</div>
						<div class="col-md-6 col-lg-3">
					
							<!--Profile Widget-->
							<!--===================================================-->
							<div class="panel widget">
								<div class="widget-header bg-success"></div>
								<div class="widget-body text-center">
									<img alt="Profile Picture" class="widget-img img-circle img-border" src="/assets/img/av3.png">
									<h4 class="mar-no">Donald Brown</h4>
									<p class="text-muted mar-btm">Web and Graphic designer</p>
					
									<div class="pad-ver">
										<a class="btn btn-default btn-icon btn-hover-primary fa fa-facebook icon-lg add-tooltip" href="#" title="" data-original-title="Facebook"></a>
										<a class="btn btn-default btn-icon btn-hover-info fa fa-twitter icon-lg add-tooltip" href="#" title="" data-original-title="Twitter"></a>
										<a class="btn btn-default btn-icon btn-hover-danger fa fa-google-plus icon-lg add-tooltip" href="#" title="" data-original-title="Google+"></a>
										<a class="btn btn-default btn-icon btn-hover-mint fa fa-envelope icon-lg add-tooltip" href="#" title="" data-original-title="Email"></a>
									</div>
								</div>
							</div>
							<!--===================================================-->
					
						</div>
						<div class="col-md-6 col-lg-3">
					
							<!--Profile Widget-->
							<!--===================================================-->
							<div class="panel widget">
								<div class="widget-header bg-purple">
									<img class="widget-bg img-responsive" src="/assets/img/thumbs/img3.jpg" alt="Image">
								</div>
								<div class="widget-body text-center">
									<img alt="Profile Picture" class="widget-img img-border-light" src="/assets/img/av4.png">
									<h4 class="mar-no">Lucy Moon</h4>
									<p class="text-muted mar-btm">Art Designer</p>
					
									<ul class="list-unstyled text-center pad-top mar-no clearfix">
										<li class="col-xs-4">
											<span class="text-lg">1,345</span>
											<p class="text-muted text-uppercase">
												<small>Following</small>
											</p>
										</li>
										<li class="col-xs-4">
											<span class="text-lg">23,456</span>
											<p class="text-muted text-uppercase">
												<small>Followers</small>
											</p>
										</li>
										<li class="col-xs-4">
											<span class="text-lg">52,678</span>
											<p class="text-muted text-uppercase">
												<small>Likes</small>
											</p>
										</li>
									</ul>
								</div>
							</div>
							<!--===================================================-->
					
						</div>
						<div class="col-md-6 col-lg-3">
							<!--Profile Widget-->
							<!--===================================================-->
							<div class="panel text-center">
								<div class="panel-body">
									<img alt="Avatar" class="img-md img-circle img-border mar-btm" src="/assets/img/av6.png">
									<h4 class="mar-no">Brenda Fuller</h4>
									<p>Project manager</p>
								</div>
								<div class="pad-all">
									<p class="text-muted">
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
									</p>
									<div class="pad-btm">
										<button class="btn btn-primary">Follow</button>
										<button class="btn btn-success">Message</button>
									</div>
								</div>
							</div>
							<!--===================================================-->
						</div>
					</div>
<div class="row">
						<div class="col-lg-8">
					
							<!--Profile Heading-->
							<!--===================================================-->
							<div class="panel">
								<div class="panel-bg-cover">
									<img class="img-responsive" src="/assets/img/thumbs/img1.jpg" alt="Image">
								</div>
								<div class="panel-media">
									<img src="/assets/img/av1.png" class="panel-media-img img-circle img-border-light" alt="Profile Picture">
									<div class="row">
										<div class="col-lg-7">
											<h3 class="panel-media-heading">Stephen Tran</h3>
											<a href="#" class="btn-link">@stephen_doe</a>
											<p class="text-muted mar-btm">Web and Graphic designer</p>
										</div>
										<div class="col-lg-5 text-lg-right">
											<button class="btn btn-sm btn-primary">Add Friend</button>
											<button class="btn btn-sm btn-mint btn-icon fa fa-envelope icon-lg"></button>
										</div>
									</div>
								</div>
								<div class="panel-body">
									<h4>Consectetur adipisicing</h4>
									Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
								</div>
							</div>
							<!--===================================================-->
					
						</div>
						<div class="col-lg-4">
					
							<!--Profile Widget-->
							<!--===================================================-->
							<div class="panel text-center">
								<div class="panel-body bg-purple">
									<img alt="Avatar" class="img-lg img-circle img-border mar-btm" src="/assets/img/av5.png">
					
									<h4 class="mar-no">Brenda Fuller</h4>
									<p>Project manager</p>
								</div>
					
								<div class="pad-all">
									<p class="text-muted">
										Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut sed diam.
									</p>
									<a href="#" class="btn-link">http://www.themeon.net</a>
									<div class="pad-ver">
										<button class="btn btn-primary">Follow</button>
										<button class="btn btn-success">Message</button>
									</div>
								</div>
							</div>
							<!--===================================================-->
					
						</div>
					</div>
<br>
<hr>
<br>
<div class="row">
						<div class="col-md-6 col-lg-8">
					
							<!--Realtime flot chart-->
							<!--===================================================-->
							<div class="panel">
								<div class="panel-heading">
									<div class="panel-control">
										<span class="label label-success">Online</span>
									</div>
									<h3 class="panel-title">Server Load</h3>
								</div>
								<div class="panel-body">
									<ul class="list-inline mar-no">
										<li>
											<div class="pad-hor">
												<span class="h4">40%</span>
												<p class="text-muted text-uppercase"><small>Avg. Server Load</small></p>
											</div>
										</li>
										<li>
											<div class="pad-hor">
												<span class="h4">24 Days</span>
												<p class="text-muted text-uppercase"><small>Up Time</small></p>
											</div>
										</li>
										<li>
											<div class="pad-hor">
												<span class="h4">00:05:23</span>
												<p class="text-muted text-uppercase"><small>Avg. Time on Site</small></p>
											</div>
										</li>
									</ul>
								</div>
								<div id="demo-realtime-chart" class="flot-full-content" style="padding: 0px; position: relative;">
									<!--Flot chart placement-->
								<canvas class="flot-base" width="757" height="212" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 757px; height: 212px;"></canvas><canvas class="flot-overlay" width="757" height="212" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 757px; height: 212px;"></canvas></div>
							</div>
							<!--===================================================-->
							<!--End Realtime flot chart-->
					
						</div>
						<div class="col-md-6 col-lg-4">
					
							<!--Guege server load-->
							<!--===================================================-->
							<div class="panel">
								<div class="panel-body bg-success text-center">
					
									<!--Gauge placeholder-->
									<canvas id="demo-gauge" height="105" class="canvas-responsive"></canvas>
					
								</div>
								<div class="pad-all">
									<p class="text-muted">Lorem ipsum dolor sit amet, consectetuer <a href="#" class="add-tooltip text-semibold" data-title="45%" data-original-title="" title="">adipiscing elit</a>, sed diam nonummy nibh. Lorem ipsum dolor sit amet.</p>
									<small class="text-muted"><em>Last Update : Des 12, 2014</em></small>
									<hr>
									<ul class="list-unstyled row text-center">
					
										<!--Gauge info-->
										<li class="col-xs-6">
											<span id="demo-gauge-text" class="text-2x">57</span>
											<p class="text-uppercase">
												<small>% Server Load</small>
											</p>
										</li>
										<li class="col-xs-6">
											<span class="text-2x">48 Days</span>
											<p class="text-uppercase">
												<small>Up Time</small>
											</p>
										</li>
									</ul>
								</div>
							</div>
							<!--===================================================-->
							<!--End Guege server load-->
					
						</div>
					</div>
<div class="row">
						<div class="col-lg-4">
					
							<!--Weather widget-->
							<!--===================================================-->
							<div id="demo-weather-widget-md" class="panel panel-mint panel-colorful text-center">
								<div class="panel-body">
					
									<!--Weather widget body-->
									<div class="row pad-top">
										<div class="col-xs-6">
											<canvas id="demo-weather-md-icon-1" width="98" height="98"></canvas>
										</div>
										<div class="col-xs-6">
											<p class="text-4x">27°</p>
											<p class="">Partly Cloudy Day</p>
										</div>
									</div>
									<h4 class="mar-no pad-top">San Jose, CA</h4>
									<p>Today</p>
									<hr>
					
					
									<!--Weather widget footer-->
									<ul class="list-unstyled text-center clearfix">
										<li class="col-xs-3">
											<canvas id="demo-weather-md-icon-2" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Saturday</p>
											<p>25 °C</p>
										</li>
										<li class="col-xs-3">
											<canvas id="demo-weather-md-icon-3" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Sunday</p>
											<p>22 °C</p>
										</li>
										<li class="col-xs-3">
											<canvas id="demo-weather-md-icon-4" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Monday</p>
											<p>20 °C</p>
										</li>
										<li class="col-xs-3">
											<canvas id="demo-weather-md-icon-5" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Monday</p>
											<p>28 °C</p>
										</li>
									</ul>
								</div>
							</div>
							<!--===================================================-->
							<!--End Weather widget-->
					
						</div>
						<div class="col-lg-8">
					
					
							<!--Large weather widget-->
							<!--===================================================-->
							<div id="demo-weather-widget-lg" class="panel panel-info panel-colorful text-center">
								<div class="panel-body">
					
									<!--Widget heading-->
									<div class="media">
										<div class="media-left">
											<i class="fa fa-map-marker fa-3x"></i>
										</div>
										<div class="media-body">
											<h4 class="mar-no text-left">San Jose, CA</h4>
											<p class="text-left">Today</p>
										</div>
									</div>
					
									<!--Widget body-->
									<div class="row pad-top">
										<div class="col-xs-6">
											<canvas id="demo-weather-lg-icon-1" width="98" height="98"></canvas>
										</div>
										<div class="col-xs-6">
											<p class="text-4x">27°</p>
											<p>Partly Cloudy Day</p>
										</div>
									</div>
									<hr>
					
									<!--Widget footer-->
									<ul class="list-unstyled text-center clearfix">
										<li class="col-xs-2">
											<canvas id="demo-weather-lg-icon-2" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Saturday</p>
											<p>25 °C</p>
										</li>
										<li class="col-xs-2">
											<canvas id="demo-weather-lg-icon-3" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Sunday</p>
											<p>22 °C</p>
										</li>
										<li class="col-xs-2">
											<canvas id="demo-weather-lg-icon-4" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Monday</p>
											<p>20 °C</p>
										</li>
										<li class="col-xs-2">
											<canvas id="demo-weather-lg-icon-5" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Tuesday</p>
											<p>28 °C</p>
										</li>
										<li class="col-xs-2">
											<canvas id="demo-weather-lg-icon-6" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Wednesday</p>
											<p>22 °C</p>
										</li>
										<li class="col-xs-2">
											<canvas id="demo-weather-lg-icon-7" width="32" height="32"></canvas>
											<p class="text-sm mar-no">Thursday</p>
											<p>25 °C</p>
										</li>
									</ul>
								</div>
							</div>
							<!--===================================================-->
							<!--End Large weather widget-->
					
						</div>
					</div>
<div class="row">
						<div class="col-md-6 col-lg-3">
					
							<!--Small weather widget-->
							<!--===================================================-->
							<div class="panel text-center">
								<div class="panel-body bg-warning">
									<canvas id="demo-weather-sm-icon" width="128" height="128"></canvas>
									<h4 class="text-thin mar-no pad-top">San Jose, CA</h4>
									<p>Today</p>
								</div>
								<div class="pad-all">
									<p class="text-4x">20°</p>
									<p class="">Rainy Day</p>
								</div>
							</div>
							<!--===================================================-->
							<!--End Small weather widget-->
					
					
							<!--Extra small weather widget-->
							<!--===================================================-->
					
							<div class="panel media middle">
								<div class="media-left bg-primary pad-all">
									<canvas id="demo-weather-xs-icon-1" width="48" height="48"></canvas>
								</div>
								<div class="media-body pad-lft">
									<p class="text-2x mar-no text-thin">32°</p>
									<p class="text-muted mar-no">Sunny</p>
								</div>
							</div>
							<!--===================================================-->
							<!--End Extra small weather widget-->
					
						</div>
						<div class="col-md-6 col-lg-3">
					
							<!--Easy pie chart-->
							<!--===================================================-->
							<div class="panel">
								<div class="panel-body bg-purple text-center">
					
									<!--Placeholder-->
									<div id="demo-pie-1" data-percent="35" class="pie-title-center">
										<span class="pie-value">35%</span>
									<canvas height="110" width="110"></canvas></div>
					
								</div>
								<div class="pad-all text-center">
									<p class="text-muted">Lorem ipsum dolor sit amet, consectetuer <a href="#" class="add-tooltip text-semibold" data-title="45%" data-original-title="" title="">adipiscing elit</a>, sed diam nonummy nibh. Lorem ipsum dolor sit amet.</p>
									<small class="text-muted"><em>Last Update : Des 12, 2014</em></small>
									<hr>
									<p class="text-3x text-primary">5,327</p>
								</div>
							</div>
							<!--===================================================-->
							<!--End Easy pie chart-->
					
					
							<!--Extra small weather widget-->
							<!--===================================================-->
							<div class="panel media middle">
								<div class="media-left pad-all">
									<canvas id="demo-weather-xs-icon-2" width="48" height="48"></canvas>
								</div>
								<div class="media-body pad-lft">
									<p class="text-2x mar-no text-thin text-mint">25°</p>
									<p class="text-muted mar-no">Partly Cloudy Day</p>
								</div>
							</div>
							<!--===================================================-->
							<!--End Extra small weather widget-->
					
					
					
						</div>
						<div class="col-md-12 col-lg-6">
					
							<!--Chat widget-->
							<!--===================================================-->
							<div class="panel">
								<!--Heading-->
								<div class="panel-heading">
									<div class="panel-control">
										<div class="btn-group">
											<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#demo-chat-body"><i class="fa fa-chevron-down"></i></button>
											<button type="button" class="btn btn-default" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
											<ul class="dropdown-menu dropdown-menu-right">
												<li><a href="#">Available</a></li>
												<li><a href="#">Busy</a></li>
												<li><a href="#">Away</a></li>
												<li class="divider"></li>
												<li><a id="demo-connect-chat" href="#" class="disabled-link" data-target="#demo-chat-body">Connect</a></li>
												<li><a id="demo-disconnect-chat" href="#" data-target="#demo-chat-body">Disconect</a></li>
											</ul>
										</div>
									</div>
									<h3 class="panel-title">Chat</h3>
								</div>
					
								<!--Widget body-->
								<div id="demo-chat-body" class="collapse in">
									<div class="nano has-scrollbar" style="height:380px">
										<div class="nano-content pad-all" tabindex="0" style="right: -15px;">
											<ul class="list-unstyled media-block">
												<li class="mar-btm">
													<div class="media-left">
														<img src="/assets/img/av1.png" class="img-circle img-sm" alt="Profile Picture">
													</div>
													<div class="media-body pad-hor">
														<div class="speech">
															<a href="#" class="media-heading">John Doe</a>
															<p>Hello Lucy, how can I help you today ?</p>
															<p class="speech-time">
															<i class="fa fa-clock-o fa-fw"></i>09:23AM
															</p>
														</div>
													</div>
												</li>
												<li class="mar-btm">
													<div class="media-right">
														<img src="/assets/img/av4.png" class="img-circle img-sm" alt="Profile Picture">
													</div>
													<div class="media-body pad-hor speech-right">
														<div class="speech">
															<a href="#" class="media-heading">Lucy Doe</a>
															<p>Hi, I want to buy a new shoes.</p>
															<p class="speech-time">
																<i class="fa fa-clock-o fa-fw"></i> 09:23AM
															</p>
														</div>
													</div>
												</li>
												<li class="mar-btm">
													<div class="media-left">
														<img src="/assets/img/av1.png" class="img-circle img-sm" alt="Profile Picture">
													</div>
													<div class="media-body pad-hor">
														<div class="speech">
															<a href="#" class="media-heading">John Doe</a>
															<p>Shipment is free. You\'ll get your shoes tomorrow!</p>
															<p class="speech-time">
																<i class="fa fa-clock-o fa-fw"></i> 09:25
															</p>
														</div>
													</div>
												</li>
												<li class="mar-btm">
													<div class="media-right">
														<img src="/assets/img/av4.png" class="img-circle img-sm" alt="Profile Picture">
													</div>
													<div class="media-body pad-hor speech-right">
														<div class="speech">
															<a href="#" class="media-heading">Lucy Doe</a>
															<p>Wow, that\'s great!</p>
															<p class="speech-time">
																<i class="fa fa-clock-o fa-fw"></i> 09:27
															</p>
														</div>
													</div>
												</li>
												<li class="mar-btm">
													<div class="media-right">
														<img src="/assets/img/av4.png" class="img-circle img-sm" alt="Profile Picture">
													</div>
													<div class="media-body pad-hor speech-right">
														<div class="speech">
															<a href="#" class="media-heading">Lucy Doe</a>
															<p>Ok. Thanks for the answer. Appreciated.</p>
															<p class="speech-time">
															<i class="fa fa-clock-o fa-fw"></i> 09:28
															</p>
														</div>
													</div>
												</li>
												<li class="mar-btm">
													<div class="media-left">
														<img src="/assets/img/av1.png" class="img-circle img-sm" alt="Profile Picture">
													</div>
													<div class="media-body pad-hor">
														<div class="speech">
															<a href="#" class="media-heading">John Doe</a>
															<p>You are welcome! <br> Is there anything else I can do for you today?</p>
															<p class="speech-time">
																<i class="fa fa-clock-o fa-fw"></i> 09:30
															</p>
														</div>
													</div>
												</li>
												<li class="mar-btm">
													<div class="media-right">
														<img src="/assets/img/av4.png" class="img-circle img-sm" alt="Profile Picture">
													</div>
													<div class="media-body pad-hor speech-right">
														<div class="speech">
															<a href="#" class="media-heading">Lucy Doe</a>
															<p>Nope, That\'s it.</p>
															<p class="speech-time">
																<i class="fa fa-clock-o fa-fw"></i> 09:31
															</p>
														</div>
													</div>
												</li>
												<li class="mar-btm">
													<div class="media-left">
														<img src="/assets/img/av1.png" class="img-circle img-sm" alt="Profile Picture">
													</div>
													<div class="media-body pad-hor">
														<div class="speech">
															<a href="#" class="media-heading">John Doe</a>
															<p>Thank you for contacting us today</p>
															<p class="speech-time">
																<i class="fa fa-clock-o fa-fw"></i> 09:32
															</p>
														</div>
													</div>
												</li>
											</ul>
										</div>
									<div class="nano-pane"><div class="nano-slider" style="height: 135px; transform: translate(0px, 0px);"></div></div></div>
					
									<!--Widget footer-->
									<div class="panel-footer">
										<div class="row">
											<div class="col-xs-9">
												<input type="text" placeholder="Enter your text" class="form-control chat-input">
											</div>
											<div class="col-xs-3">
												<button class="btn btn-primary btn-block" type="submit">Send</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--===================================================-->
							<!--Chat widget-->
						</div>
					</div>
<br>
<hr>
<br>
<div class="row">
						<div class="col-sm-6 col-md-4 col-lg-2">
					
							<!--Sales-->
							<div class="panel panel-primary panel-colorful">
								<div class="pad-all text-center">
									<span class="text-5x text-thin">53</span>
									<p>Sales</p>
									<i class="fa fa-shopping-cart"></i>
								</div>
							</div>
					
						</div>
						<div class="col-sm-6 col-md-4 col-lg-2">
					
							<!--Messages-->
							<div class="panel panel-warning panel-colorful">
								<div class="pad-all text-center">
									<span class="text-5x text-thin">68</span>
									<p>Messages</p>
									<i class="fa fa-envelope"></i>
								</div>
							</div>
					
						</div>
						<div class="col-sm-6 col-md-4 col-lg-2">
					
							<!--Projects-->
							<div class="panel panel-purple panel-colorful">
								<div class="pad-all text-center">
									<span class="text-5x text-thin">32</span>
									<p>Projects</p>
									<i class="fa fa-code"></i>
								</div>
							</div>
					
						</div>
						<div class="col-sm-6 col-md-4 col-lg-2">
					
							<!--Reports-->
							<div class="panel panel-dark panel-colorful">
								<div class="pad-all text-center">
									<span class="text-5x text-thin">12</span>
									<p>Reports</p>
									<i class="fa fa-file-text"></i>
								</div>
							</div>
					
						</div>
					
						<div class="col-sm-6 col-md-4 col-lg-2">
					
							<!--New Items-->
							<div class="panel panel-info panel-colorful">
								<div class="pad-all text-center">
									<span class="text-5x text-thin">254</span>
									<p>New Items</p>
									<i class="fa fa-plus-circle"></i>
								</div>
							</div>
					
						</div>
						<div class="col-sm-6 col-md-4 col-lg-2">
					
							<!--Task-->
							<div class="panel panel-success panel-colorful">
								<div class="pad-all text-center">
									<span class="text-5x text-thin">52</span>
									<p>Task</p>
									<i class="fa fa-tasks"></i>
								</div>
							</div>
					
						</div>
					</div>
<br>
<div class="row">
						<div class="col-md-6 col-lg-3">
					
							<!--Registered User-->
							<div class="panel media pad-all">
								<div class="media-left">
									<span class="icon-wrap icon-wrap-sm icon-circle bg-success">
									<i class="fa fa-user fa-2x"></i>
									</span>
								</div>
								<div class="media-body">
									<p class="text-2x mar-no text-thin">241</p>
									<p class="text-muted mar-no">Registered User</p>
								</div>
							</div>
					
						</div>
						<div class="col-md-6 col-lg-3">
					
							<!--New Order-->
							<div class="panel media pad-all">
								<div class="media-left">
									<span class="icon-wrap icon-wrap-sm icon-circle bg-info">
									<i class="fa fa-shopping-cart fa-2x"></i>
									</span>
								</div>
					
								<div class="media-body">
									<p class="text-2x mar-no text-thin">543</p>
									<p class="text-muted mar-no">New Order</p>
								</div>
							</div>
					
						</div>
						<div class="col-md-6 col-lg-3">
					
							<!--Comments-->
							<div class="panel media pad-all">
								<div class="media-left">
									<span class="icon-wrap icon-wrap-sm icon-circle bg-warning">
									<i class="fa fa-comment fa-2x"></i>
									</span>
								</div>
					
								<div class="media-body">
									<p class="text-2x mar-no text-thin">34</p>
									<p class="text-muted mar-no">Comments</p>
								</div>
							</div>
					
						</div>
						<div class="col-md-6 col-lg-3">
					
							<!--Sales-->
							<div class="panel media pad-all">
								<div class="media-left">
									<span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
									<i class="fa fa-dollar fa-2x"></i>
									</span>
								</div>
					
								<div class="media-body">
									<p class="text-2x mar-no text-thin">654</p>
									<p class="text-muted mar-no">Sales</p>
								</div>
							</div>
					
						</div>
					</div>
<br>
<div class="row">
					
						<!--Tile with progress bar - (Visit Today)-->
						<!--===================================================-->
						<div class="col-md-6 col-lg-3">
							<div class="panel panel-success panel-colorful">
								<div class="pad-all media">
									<div class="media-left">
										<span class="icon-wrap icon-wrap-xs">
											<i class="fa fa-users fa-2x"></i>
										</span>
									</div>
									<div class="media-body">
										<p class="h3 text-thin media-heading">314,675</p>
										<small class="text-uppercase">Visit Today</small>
									</div>
								</div>
								<div class="progress progress-xs progress-dark-base mar-no">
									<div style="width: 30%" class="progress-bar progress-bar-light" aria-valuemax="100" aria-valuemin="0" aria-valuenow="30" role="progressbar"></div>
								</div>
								<div class="pad-all text-right">
									<small><span class="text-semibold">30%</span> Higher than yesterday</small>
								</div>
							</div>
						</div>
						<!--===================================================-->
						<!--End Tile with progress bar - (Visit Today)-->
					
					
						<!--Tile with progress bar - (Comments)-->
						<!--===================================================-->
						<div class="col-md-6 col-lg-3">
							<div class="panel panel-mint panel-colorful">
								<div class="pad-all media">
									<div class="media-left">
										<span class="icon-wrap icon-wrap-xs">
											<i class="fa fa-comment fa-2x"></i>
										</span>
									</div>
									<div class="media-body">
										<p class="h3 text-thin media-heading">45.9%</p>
										<small class="text-uppercase">comments</small>
									</div>
								</div>
								<div class="progress progress-xs progress-dark-base mar-no">
									<div style="width: 45.9%" class="progress-bar progress-bar-light" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45.9" role="progressbar"></div>
								</div>
								<div class="pad-all text-right">
									<small><span class="text-semibold"><i class="fa fa-unlock-alt fa-fw"></i> 312</span> Unapproved comments</small>
								</div>
							</div>
						</div>
						<!--===================================================-->
						<!--End Tile with progress bar - (Comments)-->
					
					
						<!--Tile with progress bar - (New Order)-->
						<!--===================================================-->
						<div class="col-md-6 col-lg-3">
							<div class="panel panel-purple panel-colorful">
								<div class="pad-all media">
									<div class="media-left">
										<span class="icon-wrap icon-wrap-xs">
											<i class="fa fa-shopping-cart fa-fw fa-2x"></i>
										</span>
									</div>
									<div class="media-body">
										<p class="h3 text-thin media-heading">5,345</p>
										<small class="text-uppercase">New Order</small>
									</div>
								</div>
								<div class="progress progress-xs progress-dark-base mar-no">
									<div style="width: 75%" class="progress-bar progress-bar-light" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar"></div>
								</div>
								<div class="pad-all text-right">
									<small><span class="text-semibold"><i class="fa fa-shopping-cart fa-fw"></i> 954</span> Sales in this month</small>
								</div>
							</div>
						</div>
						<!--===================================================-->
						<!--End Tile with progress bar - (New Order)-->
					
					
						<!--Tile with progress bar - (Earning)-->
						<!--===================================================-->
						<div class="col-md-6 col-lg-3">
							<div class="panel panel-pink panel-colorful">
								<div class="pad-all media">
									<div class="media-left">
										<span class="icon-wrap icon-wrap-xs">
											<i class="fa fa-dollar fa-fw fa-2x"></i>
										</span>
									</div>
									<div class="media-body">
										<p class="h3 text-thin media-heading">7,428</p>
										<small class="text-uppercase">Earning</small>
									</div>
								</div>
								<div class="progress progress-xs progress-dark-base mar-no">
									<div style="width: 37.4%" class="progress-bar progress-bar-light" aria-valuemax="100" aria-valuemin="0" aria-valuenow="37.4" role="progressbar"></div>
								</div>
								<div class="pad-all text-right">
									<small><span class="text-semibold"><i class="fa fa-dollar fa-fw"></i> 22,675</span> Total Earning</small>
								</div>
							</div>
						</div>
						<!--===================================================-->
						<!--End Tile with progress bar - (Earning)-->
					
					</div>
<br>
<div class="row">
					
						<!--Large Tile - (Visit Today)-->
						<!--===================================================-->
						<div class="col-md-6 col-lg-3">
							<div class="panel panel-dark panel-colorful">
								<div class="panel-body text-center">
									<p class="text-uppercase mar-btm text-sm">Visit Today</p>
									<i class="fa fa-users fa-5x"></i>
									<hr>
									<p class="h2 text-thin">254,487</p>
									<small><span class="text-semibold">7%</span> Higher than yesterday</small>
								</div>
							</div>
						</div>
						<!--===================================================-->
						<!--End Large Tile - (Visit Today)-->
					
						<!--Large Tile - (Comments)-->
						<!--===================================================-->
						<div class="col-md-6 col-lg-3">
							<div class="panel panel-danger panel-colorful">
								<div class="panel-body text-center">
									<p class="text-uppercase mar-btm text-sm">Comments</p>
									<i class="fa fa-comment fa-5x"></i>
									<hr>
									<p class="h2 text-thin">873</p>
									<small><span class="text-semibold"><i class="fa fa-unlock-alt fa-fw"></i> 154</span> Unapproved comments</small>
								</div>
							</div>
						</div>
						<!--===================================================-->
						<!--End Large Tile - (Comments)-->
					
						<!--Large Tile - (New Orders)-->
						<!--===================================================-->
						<div class="col-md-6 col-lg-3">
							<div class="panel panel-primary panel-colorful">
								<div class="panel-body text-center">
									<p class="text-uppercase mar-btm text-sm">New Order</p>
									<i class="fa fa-shopping-cart fa-5x"></i>
									<hr>
									<p class="h2 text-thin">2,423</p>
									<small><span class="text-semibold"><i class="fa fa-shopping-cart fa-fw"></i> 954</span> Sales in this month</small>
								</div>
							</div>
						</div>
						<!--===================================================-->
						<!--Large Tile - (New Orders)-->
					
						<!--Large Tile - (Earning)-->
						<!--===================================================-->
						<div class="col-md-6 col-lg-3">
							<div class="panel panel-info panel-colorful">
								<div class="panel-body text-center">
									<p class="text-uppercase mar-btm text-sm">Earning</p>
									<i class="fa fa-dollar fa-5x"></i>
									<hr>
									<p class="h2 text-thin">7,428</p>
									<small><span class="text-semibold"><i class="fa fa-dollar fa-fw"></i> 22,675</span> Total Earning</small>
								</div>
							</div>
						</div>
						<!--===================================================-->
						<!--End Large Tile - (Earning)-->
					
					
					</div>
@stop