@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Create a Course for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['url' => ['c/' . $client->slug . '/manage/courses/import/edit'], 'class' => 'form form-horizontal', 'files' => true]) !!}

            {!! Form::hidden('client_id', $client->id) !!}

            <div class="form-group">
                {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                </div>
            </div>

			<div class="form-group">
				{!! Form::label('file', 'Word File', ['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
                        <span class="btn btn-default btn-file">
                            Select file to upload
                            {!! Form::file('file', ['id' => 'word-file']) !!}
                        </span>
                        <span style="margin-left: 4px; margin-top: 15px;" id="word-filename">

                        </span>
				</div>
			</div>

            {!! Form::submit('Upload File and Create Course', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
            
        </div>
    </div>
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
                $("#word-filename").html('File selected: ' + filename);
				
				// TODO: Verify that the extension of the file is .docx
            });
        })(jQuery);
    </script>
@stop