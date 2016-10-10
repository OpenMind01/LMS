@inject('elements', 'Pi\Clients\Courses\Quizzes\ElementTypes\Rendering\QuizElementService')
@extends('layouts.default')

@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">Client: {{ $client->name }}</a></li>
    <li><a href="#">Manage</a></li>
    <li><a href="{{ route('clients.manage.courses.edit', [$client->slug, $course->slug]) }}">Course: {{ $course->name }}</a></li>
    <li><a href="{{ route('clients.manage.courses.modules.edit', [$client->slug, $course->slug, $module->slug]) }}">Module: #{{ $module->number }}</a></li>
    <li><a href="{{ route('clients.manage.courses.modules.articles.edit', [$client->slug, $course->slug, $module->slug, $article->id]) }}">Article: #{{ $article->number }}</a></li>
    <li class="active"><a href="#">Edit Quiz</a></li>
@stop

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Quiz Options</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($quiz, ['route' => [
                    'clients.manage.courses.modules.articles.quizzes.update',
                    $client->slug, $course->slug, $module->slug, $article->id, $quiz->id
                ], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

            <div class="form-group">
                {!! Form::label('pass_percentage', '', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('pass_percentage', Input::old('pass_percentage', ($article->pass_percentage) ?: 100), ['class' => 'form-control', 'placeholder' => '']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('max_attempts', 'Max. Attempts', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('max_attempts', Input::old('max_attempts'), ['class' => 'form-control', 'placeholder' => 'Max. Attempts (Leave blank for unlimited attempts']) !!}
                </div>
            </div>



            {!! Form::submit('Save Quiz Options', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a target="_quizpreview" href="{{ route('clients.courses.modules.articles.quizzes.show', [$client->slug, $course->slug, $module->slug, $article->number, $quiz->id]) }}" class="btn btn-info">
                    <i class="fa fa-search"></i>
                    Preview Quiz
                </a>
                <a data-toggle="modal" href="#modal-question-checkbox" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i>
                    Checkbox Question
                </a>
                <a data-toggle="modal" href="#modal-question-select" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i>
                    Select Question
                </a>
                <a data-toggle="modal" href="#modal-question-text" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i>
                    Text Question
                </a>
                <a data-toggle="modal" href="#modal-question-dragdrop" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i>
                    Drag and Drop Question
                </a>
            </div>
            <h3 class="panel-title">Questions</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover" id="questions-table">
                <thead>
                <tr>
                    <th class="col-sm-1">#</th>
                    <th class="col-sm-6">Question / Body</th>
                    <th class="col-sm-2">Answer</th>
                    <th class="col-sm-2">Options</th>
                    <th class="col-sm-1">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($quiz->elements as $element)
                <tr class="question-row" data-question-id="{{ $element->id }}">
                    <td>
                        <span style="cursor: pointer; margin-right: 10px;">
                                <i class="fa fa-arrows"></i>
                            </span>
                        {{ $element->number }}
                        <div style="font-size: 90%; color: #bbb;">{{ $element->type_name }}</div>
                    </td>
                    <td>{!! $element->label !!}</td>
                    <td>
                        @if($element->answer)
                            {{ $element->answer }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($element->options->count())
                            @foreach($element->options as $option)
                                <div class="option">{{ $option->value }}: {{ $option->label }}</div>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="#" style="color: red;" class="danger remove-question-button" data-question-id="{{ $element->id }}">
                            <i class="fa fa-trash-o"></i> Remove
                        </a>
                        <br>
                        <a href="#" class="info edit-question-button" data-question-id="{{ $element->id }}">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-question-checkbox">
        <div class="modal-dialog modal-lg">
            {!! Form::open(['route' => [
                'clients.manage.courses.modules.articles.quizzes.add-question',
                $client->slug, $course->slug, $module->slug, $article->id, $quiz->id
            ],'class' => 'form form-horizontal question-form', 'method' => 'post', 'data-type' => 'checkbox']) !!}
            {!! Form::hidden('type', (new Pi\Clients\Courses\Quizzes\ElementTypes\CheckboxQuestion)->getTypeId()) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Checkbox Question</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        {!! Form::label('body', 'Question', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <div class="editable-description" data-input-id="checkbox-body" data-id="body" style="min-height: 100px; width 100%;"><p><br /></p></div>
                            {!! Form::hidden('body', Input::old('body'), ['id' => 'checkbox-body']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('options[]', 'Answers', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <span class="help-block">
                                Add the multiple choice questions you'd like to use here.  Place a check next to the answers that
                                are correct.
                            </span>
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="col-sm-2">Correct?</th>
                                    <th class="col-sm-9">Label</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody class="options">
                                <tr class="add-option">
                                    <td colspan="3">
                                        <a href="#" data-type="checkbox" class="add-option-button"><i class="fa fa-plus-circle"></i> Add Answer</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-question-select">
        <div class="modal-dialog modal-lg">
            {!! Form::open(['route' => [
                'clients.manage.courses.modules.articles.quizzes.add-question',
                $client->slug, $course->slug, $module->slug, $article->id, $quiz->id
            ],'class' => 'form form-horizontal question-form', 'method' => 'post', 'data-type' => 'select']) !!}
            {!! Form::hidden('type', (new Pi\Clients\Courses\Quizzes\ElementTypes\SelectQuestion)->getTypeId()) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Select Box Question</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        {!! Form::label('body', 'Question', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <div class="editable-description" data-input-id="select-body" data-id="body" style="min-height: 100px; width 100%;"><p><br /></p></div>
                            {!! Form::hidden('body', Input::old('body'), ['id' => 'select-body']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('options[]', 'Answers', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <span class="help-block">
                                Add the dropdown box answers you'd like to use here.  Place a check next to the answers that
                                are correct.
                            </span>
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="col-sm-2">Correct</th>
                                    <th class="col-sm-9">Label</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody class="options">
                                <tr class="add-option">
                                    <td colspan="3">
                                        <a href="#" data-type="select" class="add-option-button"><i class="fa fa-plus-circle"></i> Add Answer</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-question-text">
        <div class="modal-dialog modal-lg">
            {!! Form::open(['route' => [
                'clients.manage.courses.modules.articles.quizzes.add-question',
                $client->slug, $course->slug, $module->slug, $article->id, $quiz->id
            ],'class' => 'form form-horizontal question-form', 'method' => 'post', 'data-type' => 'select']) !!}
            {!! Form::hidden('type', (new Pi\Clients\Courses\Quizzes\ElementTypes\TextQuestion)->getTypeId()) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Text Responseg Question</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        {!! Form::label('body', 'Question', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <div class="editable-description" data-input-id="text-body" data-id="body" style="min-height: 100px; width 100%;"><p><br /></p></div>
                            {!! Form::hidden('body', Input::old('body'), ['id' => 'text-body']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('answer', 'Answer', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('answer', Input::old('answer'), ['class' => 'form-control', 'placeholder' => 'Answer']) !!}
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-question-dragdrop">
        <div class="modal-dialog modal-lg">
            {!! Form::open(['route' => [
                'clients.manage.courses.modules.articles.quizzes.add-question',
                $client->slug, $course->slug, $module->slug, $article->id, $quiz->id
            ],'class' => 'form form-horizontal question-form', 'method' => 'post', 'enctype' => 'multipart/form-data', 'data-type' => 'select']) !!}
            {!! Form::hidden('type', (new Pi\Clients\Courses\Quizzes\ElementTypes\DragDropQuestion)->getTypeId()) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Checkbox Question</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        {!! Form::label('body', 'Question', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::file('ufile', ['class' => 'file-upload'] ) !!}
                            <div class="q-order-area">
                                <div class="order-block" draggable="true">
                                    <div class="c-order" data-id="1">1</div>
                                </div>
                                <div class="order-block" draggable="true">
                                    <div class="c-order" data-id="2">2</div>
                                </div>
                                <div class="order-block" draggable="true">
                                    <div class="c-order" data-id="3">3</div>
                                </div>
                                <div class="order-block" draggable="true">
                                    <div class="c-order" data-id="4">4</div>
                                </div>
                            </div>
                            {!! Form::hidden('body', Input::old('body'), ['class' => 'form-control', 'placeholder' => 'Question', 'cols' => '50', 'rows' => '5']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('options[]', 'Answers', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <span class="help-block">
                                Add the multiple choice questions you'd like to use here.  Place a check next to the answers that
                                are correct.
                            </span>
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="col-sm-2">Order?</th>
                                    <th class="col-sm-9">Label</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody class="options">
                                <tr class="add-option">
                                    <td colspan="3">
                                        <a href="#" data-type="draganddrop" class="add-option-button drag-drop-add"><i class="fa fa-plus-circle"></i> Add Answer</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop

@section('inline-scripts')
    <script>
        (function ($) {
            window.Pi = window.Pi || {_token: '{{ csrf_token() }}'};
            window.Pi.quiz = {!!  $quiz  !!};
        })(jQuery);
    </script>

    <script src="/assets/plugins/raptor-editor/raptor.js"></script>
    <script>
        var clientSlug = '{{ $client->slug }}';
        var courseSlug = '{{ $course->slug }}';
        var uuid = '{{ $article->uuid }}';
        (function ($) {

            $(".editable-description").raptor({
//uriSave is used for inline image editor to save image updates
                uriSave: '/api/filemanager/'+clientSlug+'/'+courseSlug,
                bind: {
                    saved: function(data, xhr) {
                        console.log(this);
                        console.log(data);
                        var id = $(this.element).data('inputId');
                        var $input = $("#"+id);
                        $input.val(data.content.body);
                    },
                },
                plugins: {
                    // Define which save plugin to use. May be saveJson or saveRest
                    save: {
                        plugin: 'saveJson'
                    },

                    revisions: {
                        url: function() {
                            return '/api/articles/versions/'+uuid;
                        }
                    },

                    fileManager: {
                        uriPublic: '',
                        uriAction: '/api/filemanager/'+clientSlug+'/'+courseSlug,
                        uriIcon: '/file-manager/icon/'
                    },

                    snippetMenu: {
                        snippets: {
                            'Add Topic': '[topic=This is the topic title]'
                        }
                    },

                    // Provide options for the saveJson plugin
                    saveJson: {
                        // The URL to which Raptor data will be POSTed
                        url: '/raptor-stub',
                        // The parameter name for the posted data
                        postName: 'raptor-content',

                        post: function(data) {
                            data._token = '{{ csrf_token() }}';
                            return data;
                        },
                        // A string or function that returns the identifier for the Raptor instance being saved
                        id: function() {
                            return this.raptor.getElement().data('id');
                        },
                    },

                    statistics: false,
                    topicCreate: true
                }, layouts: {
                    toolbar: {
                        uiOrder: [
                            ['logo'],
                            ['save', 'cancel'],
                            ['dockToScreen', 'dockToElement', 'guides'],
                            ['viewSource'],
                            ['historyUndo', 'historyRedo'],
                            ['alignLeft', 'alignCenter', 'alignJustify', 'alignRight'],
                            ['textBold', 'textItalic', 'textUnderline'],
                            ['listUnordered', 'listOrdered'],
                            ['hrCreate', 'textBlockQuote'],
                            ['textSizeDecrease', 'textSizeIncrease', 'fontFamilyMenu'],
                            ['clearFormatting', 'cleanBlock'],
                            ['linkCreate', 'linkRemove'],
                            ['embed', 'fileManager', 'imageEditor'],
                            ['floatLeft', 'floatNone', 'floatRight'],
                            ['colorMenuBasic'],
                            ['tagMenu'],
                            ['classMenu'],
                            ['specialCharacters'],
                            ['tableCreate', 'tableInsertRow', 'tableDeleteRow', 'tableInsertColumn', 'tableDeleteColumn'],
                            ['languageMenu']
                        ]
                    }
                }

            });
        })(jQuery);
    </script>

    <!-- <script src="/assets/js/pi/pages/clients/manage/quizzes/edit.js"></script>
         <script src="/assets/plugins/jquery-hotkeys/jquery.hotkeys.js"></script>-->
    <script src="/assets/plugins/jquery-sortable/jquery-sortable.js"></script>
    <script>
        (function ($) {
            function sortTable()
            {
                var $rows = $("#questions-table").find('tr.question-row');
                var rowOrder = []
                $rows.each(function() {
                    rowOrder.push($(this).data('questionId'));
                });

                $.ajax({
                    url: '{{ route('clients.manage.courses.modules.articles.quizzes.question-order', [$client->slug, $course->slug, $module->slug, $article->id, $quiz->id]) }}',
                    type: 'post',
                    data: {
                        _token: window.Pi._token,
                        order: rowOrder
                    },
                    success: function(response) {
//                            console.log(response);
                        if (response.success)
                            window.location.reload();
                    }
                })
            }
            $("#questions-table").sortable({
                containerSelector: 'table',
                itemPath: '> tbody',
                itemSelector: 'tr',
                placeholder: '<tr class="placeholder" style="height: 20px;"><td colspan="3" style="border: 3px dashed #bbb;"></td></tr>',
                onDrop: function($item, container, _super)
                {
                    sortTable();
                }
            });

            $(".remove-question-button").click(function(e) {
                e.preventDefault();
                var questionId = $(this).data("questionId");
                var $tr = $(this).closest('tr');
                bootbox.confirm('Are you sure you wish to delete this quiz element?', function (yes) {
                    if (yes) {
                        $.ajax({
                            url: '{{ route('clients.manage.courses.modules.articles.quizzes.destroy-question', [$client->slug, $course->slug, $module->slug, $article->id, $quiz->id]) }}/'+questionId,
                            type: 'post',
                            data: {
                                _token: window.Pi._token,
                                _method: 'delete'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $tr.fadeOut().remove();
                                    sortTable();
                                }

                            }
                        })
                    }
                });

            });
        })(jQuery);
    </script>
@stop