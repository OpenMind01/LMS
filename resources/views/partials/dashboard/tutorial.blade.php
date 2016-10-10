<div class="tutorial" id="tutorial">
	<div class="tutorial-popover" data-target="#continue-class" data-placement="right">
		<div class="tutorial-popover-content">
			Continue your most recent class here.
		</div>
	</div>
	<div class="tutorial-popover" data-target="#mainnav-menu" data-placement="bottom">
		<div class="tutorial-popover-content">
			View your courses here.
		</div>
	</div>
	<div class="tutorial-popover" data-target="#dropdown-user" data-placement="bottom">
		<div class="tutorial-popover-content">
			Here you can edit your profile and other useful information.
		</div>
	</div>

	<div class="tutorial-modal">
		<h2>Welcome</h2>
		<p>Check out all the features of your dashboard.</p>
		<form id="tutorial-form" action="/update-profile{{-- !! action('Auth\UpdateProfileController@ndex', Auth::user()) !!--}}" method="POST">
			{{ csrf_field() }}
			<label>
				<input type="checkbox" name="show_tutorial" value="0" checked>
				Hide this tutorial next time
			</label>
			<button class="btn btn-success">Got it!</button>
		</form>
	</div>
	<div class="tutorial-background"></div>
</div>
