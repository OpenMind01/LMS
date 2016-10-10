@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.courses.create', ['clientSlug' => $client->slug]) }}" class="btn btn-success">Create Course</a>
                <a href="#" id="import_module" class="btn btn-primary">Import Course from Word</a>
            </div>
            <h3 class="panel-title">Courses for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th># of Modules</th>
                    <th class="col-sm-3">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td>
                            {{ Snippet::process($course->name, $viewData) }}
                            <div style="color: #aaa">Slug: {{ $course->slug }}</div>
                        </td>
                        <td>{{ $course->modules->count() }}</td>
                        <td>
                            {!! Form::open(['class' => 'delete-course-form', 'route' => ['clients.manage.courses.destroy', $client->slug, $course->slug], 'method' => 'DELETE']) !!}
                            <a href="{{ route('clients.manage.courses.edit', ['clientSlug' => $client->slug, 'courseSlug' => $course->slug]) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <a href="{{ route('clients.manage.courses.clone', ['clientSlug' => $client->slug, 'courseSlug' => $course->slug]) }}" class="btn btn-sm btn-success">
                                Clone
                            </a>

                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            {!! Form::close() !!}

                            @if(!$client->isUsergroupClient())
                                @can('usergroups.manage')
                                    <a href="{{ route('clients.manage.courses.usergroup', ['clientSlug' => $client->slug, 'courseSlug' => $course->slug]) }}" class="btn btn-sm btn-warning">
                                        Create usergroup
                                    </a>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="import_dialog">
        <div class="panel-body">
            {!! Form::open(['url' => ['c/' . $client->slug . '/manage/courses/' . $course->slug . '/import'], 'class' => 'form form-horizontal', 'files' => true]) !!}
            {!! Form::hidden('client_id', $client->id) !!}
            {!! Form::hidden('name', 'Imported Course') !!}
            <div class="form-group">
                {!! Form::label('file', "Create a Module by importing a Word file (.docx) with the Module's title, lessons and topics.", ['class' => 'col-sm-12 control-label text-left']) !!}
                <div class="col-sm-12">
                    <span class="btn btn-default btn-file">
                        Select file to upload
                        {!! Form::file('file', ['id' => 'word-file']) !!}
                    </span>
                    <span style="margin-left: 4px; margin-top: 15px;" id="word-filename">

                    </span>
                </div>
            </div>
            {!! Form::submit('Import Modules', ['class' => 'btn btn-info pull-right']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('inline-scripts')
    <script src="/assets/plugins/jquery-bpopup/jquery.bpopup.min.js"></script>
    <script src="/assets/plugins/jquery-sortable/jquery-sortable.js"></script>
    <script>
        (function ($) {
            // Button for import a module from a word file.
            $("#import_module").click(function() {
                // Find for the highest module number.

                // Show dialog for select a file.
                $("#import_dialog").bPopup({
                    follow: [false, false],
                    modal: true
                });

                return false;
            });

            // File selector for the word file.
            $("#word-file").change(function(e) {
                // Remove previous messages.
                $("#word-filename").children().remove();

                // Display the file's name.
                var fullPath = $(e.target).val();
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
                $("#word-filename").append('<span>File selected: ' + filename+'</span>');

                // Verify that the file's extension is .docx
                if(filename != null && !filename.toLowerCase().endsWith('.docx')) {
                    $("#word-filename").append(' <small style="color:red">The file extension is not .docx (it may not be a Word file)</small>');
                }
            });

            $(".delete-course-form").submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                bootbox.confirm('Are you sure you wish to delete this course? This action is irreversible, and all user course progress will be lost.', function (yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                })
            });
        })(jQuery);
    </script>

@stop

@section('inline-styles')
    @parent
    <style type="text/css">
        #import_dialog {
            border: 1px solid grey;
            background-color: white;
            width: 600px;
            display: none;
        }
    </style>
@stop