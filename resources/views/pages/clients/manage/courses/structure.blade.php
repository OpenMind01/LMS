@extends('layouts.default')

@section('content')

    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Course {{ $course->name }}</h3>
        </div>
        <div class="panel-body">
			<div class="row" id="add_buttons">
				<div class="col-md-8">
					<p>Arrange the structure of modules and articles</p>

                    <div>
                        <button class="btn btn-primary" id="save_button">
                            <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                            Save content
                        </button>
                    </div>

				</div>
				<div class="col-md-4 text-right">
					<button class="btn btn-success add_module" data-type="module">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						Add module
					</button>
				</div>
			</div>

			<br>

			<div id="course_content">
                <div>
                    <button type="button" class="btn btn-warning" id="expand-all">
                        <span class="visible-when-collapsed"><i class="fa fa-plus"></i> Expand all</span>
                        <span class="visible-when-expanded"><i class="fa fa-minus"></i> Collapse all</span>
                    </button>
                </div>

				<ol class="default vertical" id="course_ol">
					@foreach ($course->modules as $key => $module)
						<li class="item module" data-type="module" data-id="{{ $module->id }}">
							<div class="row item">
								<div class="title">
									<div class="col-sm-1">
										<a href="#" class="move-li"><i class="fa fa-sort"></i></a>
										<button class="btn btn-info btn-xs expand">
                                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
										</button>
										<span class="label label-primary">Module</span>
									</div>
									<div class="col-sm-7">
										<span class="editable editable-click"
											  data-name="name"
											  data-type="text" data-pk="{{ $module->id }}"
											  data-url="{{ url('api/modules/'.$module->id) }}"
											  data-title="Enter Module Name">{{ $module->name }}</span>
										{{--<div class="input"><input type="text" value="{{ $module->name }}" name="title" /></div>--}}
									</div>
									<div class="col-sm-2 text-center">
										<button class="btn btn-default edit_topics">
											<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
											Edit Article
										</button>

										<button class="btn btn-primary add_lesson">
											<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
											Add article
										</button>
									</div>
									<div class="col-sm-2 text-right">
										<button class="btn btn-danger delete">
											<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										</button>
									</div>
								</div>
							</div>

							<ol class="lesson-sortable">
								<!-- START LESSON -->
								@foreach($module->articles as $article)
								<li class="item lesson" data-type="lesson" data-module-id="{{ $module->id }}" data-id="{{ $article->id }}">
									<div class="row item">
										<div class="title">
											<div class="col-sm-1">
												<a href="#" class="move-li"><i class="fa fa-sort"></i></a>
												<span class="label label-mint">Article</span>
											</div>
											<div class="col-sm-7">
												<span class="editable editable-click"
													  data-name="name"
													  data-type="text" data-pk="{{ $article->id }}"
													  data-url="{{ url('api/articles/'.$article->id) }}"
													  data-title="Enter Article Name">{{ $article->name }}</span>
												{{--<div class="input"><input type="text" value="{{ $article->name }}" name="title" /></div>--}}
											</div>
											<div class="col-sm-2 text-center">
												<button class="btn btn-default edit_topics">
													<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
													Edit topic
												</button>
											</div>
											<div class="col-sm-2 text-right">
												<button class="btn btn-danger delete">
													<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
												</button>
											</div>
										</div>
										<div class="col-sm-12 body-container">
											<div class="item-body">
												{!! $article->content !!}
											</div>
										</div>
									</div>
								</li>
								@endforeach
								<!-- END LESSON -->
							</ol>
							<input type="text" class="form-control result" value="" style="display: none;">
						</li>
					@endforeach
				</ol>
				<input id="module-values" type="text" class="form-control result" value="" style="display: none;">
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
	<script src="/assets/plugins/x-editable/js/bootstrap-editable.min.js"></script>
	<script src="/assets/plugins/jquery-bpopup/jquery.bpopup.min.js"></script>
    <script>
		var itemvalues = [];
		var modulevalues = [];
		var saveOrder = function(moduleId) {
			var order = [];
			$(".item.module[data-id='"+moduleId+"']").find('.lesson').each(function(index, item) {
				var articleId = $(item).data('id');
				order.push(articleId);
//				console.log('Index: '. index);
			});
			$.ajax({
				url: '/api/modules/'+moduleId+'/update-order',
				type: 'post',
				data: {
					order: order
				},
				success: function(response) {
					console.log(response);
				}
			})
		}
	    var updateInputs = function(){
			$(".item.module").each(function(){
				itemvalues.push($(this).data('id'));
				modulevalues.push($(this).data('id'));
				$(this).find('.lesson').each(function(){
					itemvalues.push($(this).data('id'));
				});
				$(this).find('.result').attr('value', itemvalues.join());
				$('#module-values').attr('value', modulevalues.join());
				itemvalues = [];
			});
			modulevalues = [];
		}
        $(document).ready(function() {

			updateInputs();

			// Make content items sortable.
			var oldContainer;
			$("#course_ol").sortable({
				group: 'nested',
				nested: false,
  				exclude: '.lesson',
				afterMove: function (placeholder, container) {
					if(oldContainer != container){
					  if(oldContainer)
					    oldContainer.el.removeClass("active");
					  	container.el.addClass("active");

					  	oldContainer = container;
					}
				},
				onDrop: function ($item, container, _super) {
					container.el.removeClass("active");
					_super($item, container);
					updateInputs();
				}
			});

			$(".lesson-sortable").sortable({
				group: 'nested-lesson',
				nested: false,
				afterMove: function (placeholder, container) {
					if(oldContainer != container){
					  if(oldContainer)
					    oldContainer.el.removeClass("active");
					  	container.el.addClass("active");
					  	oldContainer = container;
					}
				},
				onDrop: function ($item, container, _super) {
					container.el.removeClass("active");
					_super($item, container);
					var moduleId = $item.data('moduleId');
					saveOrder(moduleId);
					updateInputs();
				}
			});

			// Add behaviors to content items.
			CourseDragEditor.applyContentItemBehaviors("#course_content li.item");

			// Move all slides as descendants of the first.
			// var first = $("#course_ol li.item:first");
			// var allOthers = $("#course_ol li.item:not(:first)")
			// first.find("ol").append(allOthers);

			// Initialize dialog for edit the content.
			CourseDragEditor.initRaptorDialog("#raptor_dialog");

			// Set behaviour for menu buttons.
            $('#add_buttons .add_module').click(function() {
                var html = CourseDragEditor.getContentItemHtml();
                $("#course_ol").prepend(html);

                CourseDragEditor.applyContentItemBehaviors("#course_ol li.item:first-child");
            });

            $('#add_buttons .add_module').click(function() {
                var html = CourseDragEditor.getContentItemHtml();
                $("#course_ol").prepend(html);

                CourseDragEditor.applyContentItemBehaviors("#course_ol li.item:first-child");
            });

            $('#expand-all').click(function() {
                var el = $(this);
                el.toggleClass('is-all-expanded');

                if (el.hasClass('is-all-expanded')) {
                    $('#course_content li.item').addClass('is-expanded');
                }
                else {
                    $('#course_content li.item').removeClass('is-expanded');
                }
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
				var modules = [];
				var moduleNumber = 1;
				$("#course_content li.item.module").each(function(index, item) {
					var $moduleLi = $(item);
					var title = $moduleLi.find('input[name="title"]').val();
					var moduleId = $moduleLi.data('id');
					var articles = [];
					var number = 1;
					$moduleLi.find('li.item.lesson').each(function(lIndex, article) {
                        var $article = $(article);

						articles.push({
							id: $article.data('id'),
							name: $article.find('input[name="title"]').val(),
							number: number
						});
						number++;
					});

					modules.push({
						name: title,
						number: moduleNumber,
						articles: articles
					})
					moduleNumber++;
				});
				console.log(modules);
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
						{{--window.location = "{{ URL::to('c/' . $client->slug . '/manage/courses/' . $course->slug . '/edit') }}";--}}
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


			/*
			 * Inline Editable
			 */
			$.fn.editable.defaults.ajaxOptions = {type: 'PUT'}
			$(".editable").editable();

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
	<link href="/assets/plugins/x-editable/css/bootstrap-editable.css" type="text/css" rel="stylesheet" />
	<style type="text/css">
		.active{
			border: 1px solid black;
		}

		#course_content div.item {
			margin: 5px 0;
			position: relative;
		}

		#course_content .label{
			position: relative;
			left: 14px;
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
			padding-left: 0px;
		}

		#course_content ol.vertical li {
			display: block;
			border: 1px solid #f0f0f0;
			background: #f8f8f8;
			padding-left: 0px;
		}

		.item.module{
			margin-bottom: 10px;
		}

		#course_content ol li > div > div > div > a{
			display: inline-block;
			line-height: 31px;
			opacity: 0.3;
		}

		#course_content ol li > div:hover > div > div > a{
			opacity: 1;
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
			padding: 25px 10px 25px 25px;
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
			background-color: #FCFCFC;
			margin-bottom: 10px;
			border-color: transparent;
			box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.2);
		}

		#course_content ol.default li.item ol li.item:hover{
			background: #ECF9FF;
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

		.expand {
			margin-left: 10px;
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

        /**
        * Additional expand/collapse logics
        */
        #course_content ol.lesson-sortable {
            display: none;
        }

        #course_content .item.is-expanded ol.lesson-sortable {
            display: block;
        }


        #course_content .item .expand .glyphicon-minus {
            display: none;
        }

        #course_content .item.is-expanded .expand .glyphicon-minus {
            display: block;
        }

        #course_content .item.is-expanded .expand .glyphicon-plus {
            display: none;
        }


        #expand-all .visible-when-expanded {
            display: none;
        }
        #expand-all.is-all-expanded .visible-when-expanded {
            display: block;
        }
        #expand-all.is-all-expanded .visible-when-collapsed {
            display: none;
        }
	</style>
@stop
