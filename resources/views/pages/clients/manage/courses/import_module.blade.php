@extends('layouts.default')

@section('content')

    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Course {{ $title }}</h3>
        </div>
        <div class="panel-body">
			<div class="row" id="add_buttons">
				<div class="col-md-8">
					<p>Arrange the imported content in modules and lessons</p>
				</div>
				<div class="col-md-4 text-right">
					<button class="btn btn-success" data-type="module">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						Add module
					</button>			
				</div>
			</div>
				
			<br>

			<div id="course_content">
				<ol class="default vertical" id="course_ol">
					@for ($i = 0; $i < count($slides); $i++)
						<li class="item">				
							<div class="row item">
								<div class="title">
									<div class="col-sm-8">
										<div class="input"><input type="text" value="{{ $slides[$i]['title'] }}" name="title" /></div>
									</div>
									<div class="col-sm-2 text-center">
										<button class="btn btn-default edit_topics">
											<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
											Edit topic
										</button>
		
										<button class="btn btn-primary add_lesson">
											<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
											Add lesson
										</button>
									</div>
									<div class="col-sm-2 text-right">		
										<button class="btn btn-danger delete">
											<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										</button>
										
										<button class="btn btn-info expand">
											<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
										</button>
									</div>
								</div>
								<div class="col-sm-12 body-container">
									<div class="item-body">
										{!! $slides[$i]['content'] !!}
									</div>
								</div>
							</div>
								
							<ol></ol>
						</li>					
					@endfor
				</ol>				
			</div>

			<div class="row text-center">
				<button class="btn btn-primary" id="save_button">
					<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
					Save content
				</button>
			</div>
			
			{{--
			<div class="images">
				@foreach ($images as $img)
					<p>This is an image {{ $img }} - <img src="{{ $img }}" alt="Image not found" /></p>
				@endforeach
			</div>
			--}}
			
        </div>
    </div>

	<div id="raptor_dialog">
		<div class="row">
			<div class="col-sm-10 text-left"><h4>Edit content</h4></div>
			<div class="col-sm-2 text-right">
				<button class="btn btn-danger cancel">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				</button>
			</div>
		</div>
		<div class="content">Click to edit</div>
		<div class="row text-center">
			<div class="col-sm-6">
				<button class="btn btn-primary save" >
					<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
					Save
				</button>
			</div>
			<div class="col-sm-6">
				<button class="btn btn-danger cancel">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					Cancel
				</button>
			</div>
		</div>
	</div>

    @parent
@stop

@section('inline-scripts')
    @parent
	<script src="/assets/plugins/raptor-editor/raptor.min.js"></script>
	<script src="/assets/plugins/sweet-alert/sweetalert.min.js"></script>
	<script src="/assets/plugins/jquery-sortable/jquery-sortable-min.js"></script>
	<script src="/assets/plugins/textcomplete/qtip/jquery.qtip.min.js" type="text/javascript"></script>
	<script src="/assets/plugins/textcomplete/jquery.textcomplete.mod.js" type="text/javascript"></script>
	<script src="/assets/js/pi/pages/clients/course-drag-editor.js" type="text/javascript"></script>
	<script src="/assets/plugins/block-ui/jquery.blockUI.js"></script>
	<script src="/assets/plugins/jquery-bpopup/jquery.bpopup.min.js"></script>
    <script>
        $(document).ready(function() {
		
			// Make content items sortable.
			$("ol.default").sortable();
		
			// Add behaviors to content items.
			CourseDragEditor.applyContentItemBehaviors("#course_content li.item");
			
			// Move all slides as descendants of the first.
			var first = $("#course_ol li.item:first");
			var allOthers = $("#course_ol li.item:not(:first)")
			first.find("ol").append(allOthers);
			
			// Initialize dialog for edit the content.
			CourseDragEditor.initRaptorDialog("#raptor_dialog");

			// Set behaviour for menu buttons.
			$('#add_buttons button').click(function() {
				var html = CourseDragEditor.getContentItemHtml();
				$("#course_ol").prepend(html);
			
				CourseDragEditor.applyContentItemBehaviors("#course_ol li.item:first-child");
			});
			
			// Show a loading dialog when doing an ajax request.
			$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
			
			$("#save_button").click(function() {
				// Get course data.
				var token = $('meta[name=_token]').attr('content');
			
				// Serialize data.
				var items = [];
				var moduleCount = 0;
				var articleCount = 0;
				$("#course_content li.item").each(function(index, item){
					// Get item data.
					var type = $(item).parent().closest('li.item').size() > 0? "lesson" : "module";		
					var title = $(item).find('input[name="title"]').val();
					var content = $(item).find('div.item-body').html();
				
					//// Verify that the first element is a module.
					//if(index == 0 && type != 'module') {
					//	items.push({
					//		'type': 'module',
					//		'name': 'Module 1',
					//		'number': 1,
					//	});
					//	moduleCount++;
					//}
					
					// Add item.
					if (type == 'module') {
						moduleCount++;
						articleCount = 0;
						items.push({
							'type': type,
							'name': title,
							'number': moduleCount,
						});
                    } else {
						articleCount++;
						items.push({
							'type': type,
							'name': title,
							'number': articleCount,							
							'body': content,							
						});
					}
				});
				
				// Save content using AJAX.
				var data = JSON.stringify(items);				
				$.ajax({
					type: "POST",
					headers: { 'X-CSRF-Token' : token },
					url: "{{ URL::to('c/' . $client->slug . '/manage/courses/' . $course->slug . '/import/saveItems') }}",
					data: {
						'_token' : token,
						'items': items
					},
					success: function(data, textStatus, jqXHR) {
						// Redirect to course page.				
						// console.log(data);
						window.location = "{{ URL::to('c/' . $client->slug . '/manage/courses/' . $course->slug . '/edit') }}";
					},
					error: function(jqXHR, status, error) {
						// Show error message.
						console.log(jqXHR.responseText);
						console.log(status);
						console.log(error);
						alert("An unexpected error at the server prevented saving the information. Please, try again.");
					},
				});
			});
		});
    </script>
@stop

@section('inline-styles')
    @parent
	<meta name="_token" content="{{ csrf_token() }}"/>
	<link href="/assets/plugins/raptor-editor/raptor-front-end.min.css" rel="stylesheet" />
	<link href="/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />
	<link href="/assets/plugins/textcomplete/qtip/jquery.qtip.min.css" type="text/css" rel="stylesheet" />
	<link href="/assets/plugins/textcomplete/jquery.textcomplete.mod.css" type="text/css" rel="stylesheet" />
	<style type="text/css">
		#course_content div.item {
			margin: 5px 0;
			position: relative;
		}
		
		#course_content div.item div.input input {
			width: 100%;
		}
		
		#course_content div.item div.select,
		#course_content div.item div.input {
			margin-top: 5px;
		}
		
		#course_content div.item div.item-body {
			background-color: white;
		}
		
		#course_content div.item span.show-content {
			position: relative;
			top: 6px;
		}

		/* --- Sortable default styles (start) --- */
		
		#course_content body.dragging, 
		#course_content body.dragging * {
			cursor: move !important;
		}

		#course_content .dragged {
			position: absolute;
			top: 0;
			opacity: 0.5;
			z-index: 2000;
		}
		
		#course_content ol.vertical {
			margin: 0 0 9px 0;
		}
		  
		#course_content ol.vertical li {
			display: block;
			margin: 5px;
			border: 1px solid #cccccc;
			background: #eeeeee;
		}
		
		#course_content ol.vertical li.placeholder {
			position: relative;
			margin: 0;
			padding: 0;
			border: none;
		}
		
		#course_content ol.vertical li.placeholder:before {
			position: absolute;
			content: "";
			width: 0;
			height: 0;
			margin-top: -5px;
			left: -5px;
			top: -4px;
			border: 5px solid transparent;
			border-left-color: red;
			border-right: none;
		}
		
		#course_content ol {
			list-style-type: none;
		}
		  
		#course_content ol i.icon-move {
			cursor: pointer;
		}
		  
		#course_content ol li.highlight {
			background: #333333;
			color: #999999;
		}
		
		#course_content ol.default li {
			cursor: pointer;
		}
		
		/* --- Sortable default styles (end) --- */
  
		/* Change color for lessons */
		#course_content ol.default li.item ol li.item {
			background-color: #dfd;
		}  

		/*  Do not allow lessons to have descendants */
		#course_content ol.default li.item ol li.item ol {
			display: none;
		}
		
		/* Hide 'Edit topics' button for modules */
		#course_content ol.default li.item button.edit_topics,
		#course_content ol.default li.item span.show-content {
			display: none;
		}
		
		/* Hide 'Expand' and 'Add lesson' button for modules */
		#course_content ol.default li.item ol li.item button.expand,
		#course_content ol.default li.item ol li.item button.add_lesson {
			display: none;
		}
		
		/* Show 'Edit topics' button for lessons */
		#course_content ol.default li.item ol li.item button.edit_topics,
		#course_content ol.default li.item ol li.item span.show-content {
			display: inline;
		}
		
		#raptor_dialog {
			border: 1px solid green;
			background-color: #efe;
			width: 850px;
			padding: 5px;
			display: none;
		}

		#raptor_dialog div.content {
			background-color: white;
			width: 100%;
			min-height: 400px;
			margin: 5px;
		}
	</style>
@stop
