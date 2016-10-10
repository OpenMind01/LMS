@foreach($client->courses as $key => $course)
	<?php 
    	$pcomp  = [];
    	$phalfp = [];
    	$phalfm = [];
    	$never = [];
    	$overall = 0;
    ?>
    @foreach($course->users as $key_user => $user)
        <?php 

        	$courseUser = \Pi\Clients\Courses\CourseUser::whereCourseId($course->id)->whereUserId($user->id)->first();

        	if(empty($user->last_login)){
        		$last = 'never logged in';
        	}else{
        		$last = 'last activity ' . \Carbon\Carbon::createFromTimeStamp(strtotime($user->last_login))->diffForHumans();
        	}

        	$overall = $courseUser->progress_percent + $overall;

        	if(empty($courseUser->progress_percent)){
        		array_push(
        			$never, 
        			[
        				'name' => $user->name,
        				'progress' => $courseUser->progress_percent,
        				'last_activity' => $last
        			]
        		);
        		continue;
        	}

        	if($courseUser->progress_percent < 50 && $courseUser->progress_percent > -1){
        		array_push(
        			$phalfm, 
        			[
        				'name' => $user->name,
        				'progress' => $courseUser->progress_percent,
        				'last_activity' => $last
        			]
        		);
        		continue;
        	}

        	if($courseUser->progress_percent >= 50 && $courseUser->progress_percent < 100){
        		array_push(
        			$phalfp, 
        			[
        				'name' => $user->name,
        				'progress' => $courseUser->progress_percent,
        				'last_activity' => $last
        			]
        		);
        		continue;
        	}

        	if($courseUser->progress_percent == 100){
        		array_push(
        			$pcomp, 
        			[
        				'name' => $user->name,
        				'progress' => $courseUser->progress_percent,
        				'last_activity' => $last
        			]
        		);
        		continue;
        	}

        ?>

		<?php
		$overall = $overall / ($key_user + 1);
		?>
	@endforeach

    <script>
    var progress_course_{{$key}} = '<?php echo json_encode([$never, $phalfm, $phalfp, $pcomp, $overall]); ?>';
    </script>
@endforeach

<div class="widget" data-widget="students-completion-progress"> 
@include('include.panel.begin', ['title' => 'Student Completion'])         
<div class="row" id="students-completion-progress-widget">

	<select id="progress_course_switch" class="form-control btn" style="margin-bottom: 20px;">
		@foreach($client->courses as $key => $course)
		<option value="{{ $key }}">{{ $course->name }}</option>
		@endforeach
	</select>

	<div id="demo-morris-donut" class="morris-donut"></div>

	<div class="pad-hor">
		<p class="text-lg">Overall course progress</p>
		<div class="progress progress-sm">
			<div id="overall-key" role="progressbar" style="width: 41%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="41" class="progress-bar progress-bar-purple">
				<span class="sr-only">41%</span>
			</div>
		</div>
		<small class="text-muted">41% Completed</small>
		<small> - Progress for all the users enrolled in this course.</small>
	</div>
	<hr>
	<h5>Students in this course</h5>
	<div id="less_adv_students" class="list-group bg-trans">

	</div>
</div>
@include('include.panel.end')
</div>
<script>
var course_data = function () {
	return [
      {label: "100% Done", value: jQuery.parseJSON(window['progress_course_'+$('#progress_course_switch').val()])[3].length},
      {label: "+50% Done", value: jQuery.parseJSON(window['progress_course_'+$('#progress_course_switch').val()])[2].length},
      {label: "-50% Done", value: jQuery.parseJSON(window['progress_course_'+$('#progress_course_switch').val()])[1].length},
      {label: "Never Logged", value: jQuery.parseJSON(window['progress_course_'+$('#progress_course_switch').val()])[0].length}
    ]
};
$('#progress_course_switch').on('change', function(){
	user_progress_morris.setData(course_data());
	update_progress_list(window['progress_course_'+this.value]);
});
var update_progress_list = function( json ){
	var data = jQuery.parseJSON(json);
	$('#overall-key').css('width', data[4]+'%');
	$('#overall-key').parent().parent().find('.text-muted').html(data[4]+'% Completed');
	$('#less_adv_students').html('');
	$.each(data, function(index, value2){
		$.each(value2, function(index2, value){
			$('#less_adv_students').append('<a href="#" class="list-group-item">\
		        <div class="media-left">\
		            <img class="img-circle img-xs" src="/assets/img/av2.png" alt="Profile Picture">\
		        </div>\
		        <div class="media-body">\
		            <span class="text-muted">'+value.name+'</span>\
					<div class="progress progress-sm">\
						<div role="progressbar" style="width: '+value.progress+'%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="'+value.progress+'" class="progress-bar progress-bar-purple">\
							<span class="sr-only">'+value.progress+'%</span>\
						</div>\
					</div>\
		            <span class="text-muted">'+value.last_activity+'</span>\
		        </div>\
		    </a>');
		});
	});
}
update_progress_list(window['progress_course_'+$('#progress_course_switch').val()]);
</script>