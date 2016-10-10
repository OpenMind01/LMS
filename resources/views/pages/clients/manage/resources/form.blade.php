{!! Form::hidden('client_id', $client->id) !!}

<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('type', 'Type', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('type', [null => 'Select a Type'] + Pi\Clients\Resources\Resource::$types, Input::old('type'), ['id' => 'resource-type', 'class' => 'form-control', 'placeholder' => 'Type']) !!}
    </div>
</div>

<div class="form-group" id="url-form-group" style="display: none;">
    {!! Form::label('url', 'Url', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('url', Input::old('url'), ['class' => 'form-control', 'placeholder' => 'Url for Link']) !!}
    </div>
</div>

<div id="upload-form-group">
    @if(!empty($resource) && $resource->file)

        <div class="row">
            <div class="col-sm-6 col-md-2">
                &nbsp;
            </div>
            @if($resource->type == Pi\Clients\Resources\Resource::TYPE_IMAGE)
                <div class="col-sm-6 col-md-4">
                    <img src="{{ $resource->file->url() }}" alt="{{ $resource->name }}" class="img-responsive">
                </div>
            @else
                <div class="col-sm-6 col-md-4">
                    <a href="{{ $resource->file->url() }}" class="btn btn-info" target="_preview">
                        <i class="fa fa-search"></i> View Resource</a>
                </div>
            @endif
            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    {!! Form::label('file', 'Upload a File', ['class' => 'col-sm-6 control-label']) !!}
                    <div class="col-sm-6">
                    <span class="pull-left btn btn-default btn-file">
                    Upload a different file... {!! Form::file('file', Input::old('file'), ['class' => 'form-control', 'placeholder' => 'Upload a different file']) !!}
                    </span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="form-group">
            {!! Form::label('file', 'Upload a File', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
            <span class="pull-left btn btn-default btn-file">
            Upload a File... {!! Form::file('file', Input::old('file'), ['class' => 'form-control', 'placeholder' => 'Upload a File']) !!}
            </span>
            </div>
        </div>
    @endif

</div>

@section('inline-scripts')
    @parent

    <script>
        (function ($) {
            var $urlFormGroup = $("#url-form-group");
            var $uploadFormGroup = $("#upload-form-group");
            $("#resource-type").change(function(e) {
                $value = $(this).val();
                if ($value == '{{ Pi\Clients\Resources\Resource::TYPE_LINK }}' || $value == '{{ Pi\Clients\Resources\Resource::TYPE_YOUTUBE }}') {
                    $urlFormGroup.show();
                    $uploadFormGroup.hide();
                }else {
                    $urlFormGroup.hide();
                    $uploadFormGroup.show();
                }
            });
        })(jQuery);
    </script>
@stop
