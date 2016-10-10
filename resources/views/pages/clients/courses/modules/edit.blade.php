@extends('pages.clients.courses.modules.show')

@section('content')

    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Manage {{ $course->name }}</h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-6 col-md-4">
                <h4>Import Article from Word</h4>
                {!! Form::open(['route' => ['clients.courses.modules.wordfile', $client->slug, $course->slug, $module->slug], 'class' => 'form form-horizontal', 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('file', 'Choose .docx File', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-7">
                        <span class="pull-left btn btn-default btn-file">
                            Browse...
                            {!! Form::file('file', ['id' => 'word-file']) !!}
                        </span>
                        <span class="pull-right" style="mergin-right: 20px; margin-top: 8px;" id="word-filename">

                        </span>
                    </div>
                    <div class="col-sm-2">
                        {!! Form::submit('Upload Word File', ['class' => 'btn btn-info']) !!}
                    </div>
                </div>
                {!! Form::close() !!}

            </div>

        </div>
    </div>

    @parent
@stop

@section('inline-scripts')
    @parent
    <script>
        (function ($) {
            $("#word-file").change(function(e) {
                console.log(e);
                var fullPath = $(e.target).val();
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
                $("#word-filename").html('Uploading: ' + filename);
            });
        })(jQuery);
    </script>
@stop