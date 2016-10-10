{!! Form::hidden('client_id', $client->id) !!}

<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    </div>
</div>

@if(!empty($course) && $course->id)
<div class="form-group">
    {!! Form::label('slug', 'Slug', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('slug', Input::old('slug'), ['class' => 'form-control', 'placeholder' => 'Slug']) !!}
    </div>
</div>
@endif

@if(empty($course))
<div class="form-group">
    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::textarea('description', Input::old('description'), ['class' => 'form-control', 'placeholder' => 'Description']) !!}
    </div>
</div>
@else
    <div class="form-group">
        {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <div class="panel-body body-editable" data-id="description">
                    {!! $course->description !!}
            </div>
        </div>
    </div>
@endif

@section('inline-scripts')
    @parent
    @if(!empty($course))
    <script src="/assets/plugins/raptor-editor/raptor.js"></script>
    <script>
        (function ($) {
            var clientSlug = '{{ $client->slug }}';
            var courseSlug = '{{ $course->slug }}';
            // Add Raptor editing functions here, or extract to a js file
            $(".body-editable").raptor({
                plugins: {
                    // Define which save plugin to use. May be saveJson or saveRest
                    save: {
                        plugin: 'saveJson'
                    },

                    fileManager: {
                        uriPublic: '',
                        uriAction: '/api/filemanager/'+clientSlug+'/'+courseSlug,
                        uriIcon: '/file-manager/icon/'
                    },

                    // Provide options for the saveJson plugin
                    saveJson: {
                        // The URL to which Raptor data will be POSTed
                        url: '/api/courses/{{ $course->id }}/update',
                        // The parameter name for the posted data
                        postName: 'raptor-content',

                        post: function(data) {
                            data._token = '{{ csrf_token() }}';
                            return data;
                        },
                        // A string or function that returns the identifier for the Raptor instance being saved
                        id: function() {
                            return this.raptor.getElement().data('id');
                        }
                    }
                }
            });
        })(jQuery);
    </script>
    @endif

@stop
