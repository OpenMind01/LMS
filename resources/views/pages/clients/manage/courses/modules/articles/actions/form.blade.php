{!! Form::hidden('article_id', $article->id) !!}
{!! Form::hidden('client_id', $client->id) !!}
<div class="form-group">
    {!! Form::label('title', 'Title', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('title', Input::old('title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <div class="description-edit" data-id="description" style="min-height: 100px; width: 100%;">
            {!!  Input::old('description', (!empty($articleAction) ? $articleAction->description : '')) !!}
        </div>
        {!! Form::hidden('description', Input::old('description'), ['id' => 'description-input']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('type_id', 'Type', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('type_id', [null => 'Select a type'] + $actionTypes, Input::old('type_id'), ['class' => 'type-select form-control', 'placeholder' => 'Type']) !!}
    </div>
</div>

{{-- */ $youtubeId = Pi\Clients\Courses\Actions\ArticleAction::TYPE_YOUTUBE /* --}}
{{-- */ $youtubeEnabled = !(empty($articleAction) || $articleAction->type_id != $youtubeId) /* --}}
<div class="type-container type-youtube" data-type-id="{{ $youtubeId }}" @if(!$youtubeEnabled) style="display: none;" @endif>
    {!! Form::hidden('type_id', Pi\Clients\Courses\Actions\ArticleAction::TYPE_YOUTUBE) !!}
    <div class="form-group">
        {!! Form::label('url', 'Youtube URL', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <input type="text" name="url" value="{{ Input::old('url', (!empty($articleAction) ? $articleAction->url : '')) }}" class="form-control" placeholder="Youtube URL" @if(!$youtubeEnabled) disabled="disabled" @endif />
        </div>
    </div>
</div>

{{-- */ $audioId = Pi\Clients\Courses\Actions\ArticleAction::TYPE_AUDIO /* --}}
{{-- */ $audioEnabled = !(empty($articleAction) || $articleAction->type_id != $audioId) /* --}}
<div class="type-container type-audio" data-type-id="{{ Pi\Clients\Courses\Actions\ArticleAction::TYPE_AUDIO }}" @if(!$audioEnabled) style="display: none;" @endif>
    {!! Form::hidden('type_id', Pi\Clients\Courses\Actions\ArticleAction::TYPE_AUDIO) !!}
    <div class="form-group">
        {!! Form::label('file', 'Audio File', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <input type="file" name="file" class="form-control" @if(!$audioEnabled) disabled="disabled" @endif />
        </div>
    </div>
</div>

@section('inline-scripts')
    @parent
    <script src="/assets/plugins/raptor-editor/raptor.js"></script>
    <script>
        var clientSlug = '{{ $client->slug }}';
        var courseSlug = '{{ $course->slug }}';
        var uuid = '{{ $article->uuid }}';
        (function ($) {
            $(".type-select").change(function(e) {
                $(".type-container").hide();
                $(".type-container input").attr('disabled', 'disabled')
                var typeId = $(this).val();
                $(".type-container[data-type-id='"+typeId+"']").show();
                $(".type-container[data-type-id='"+typeId+"'] input").removeAttr('disabled');
            })

            $(".description-edit").raptor({
//uriSave is used for inline image editor to save image updates
                uriSave: '/api/filemanager/'+clientSlug+'/'+courseSlug,
                bind: {
                    saved: function(data, xhr) {
                        console.log('hi');
                        console.log(data.content.description);
                        $("#description-input").val(data.content.description);
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
@stop



