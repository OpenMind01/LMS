@extends('pages.clients.courses.modules.articles.show')

@section('content')
    <div class="panel">

        <!--Panel heading-->
        <div class="panel-heading">
            <div class="panel-control">

                <!--Nav tabs-->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tools-main">Tools</a></li>
                    <li>
                        <a data-toggle="tab" href="#tools-answer-do">
                            @if($article->answerQuiz) <strong>Answer</strong> @else Answer @endif
                            /
                            @if($article->doQuiz) <strong>Do</strong> @else Do @endif
                        </a>
                    <li><a data-toggle="tab" href="#tools-watch-listen">
                            @if($article->watchActions->count()) <strong>Watch</strong> @else Watch @endif
                            /
                            @if($article->listenActions->count()) <strong>Listen</strong> @else Listen @endif
                        </a>
                    </li>
                </ul>

            </div>
            <h3 class="panel-title"><i class="fa fa-wrench"></i> Article Management</h3>
        </div>

        <!--Panel body-->
        <div class="panel-body">

            <!--Tabs content-->
            <div class="tab-content">
                <div id="tools-main" class="tab-pane fade">
                    <a href="#" id="upload-file-button" class="btn btn-info">Import a .docx file</a>
                </div>
                <div id="tools-answer-do" class="tab-pane fade">
                    @if($article->doQuiz)
                        {!! Form::open(['class' => 'delete-quiz-form', 'id' => 'delete-do-quiz', 'route' => ['clients.manage.courses.modules.articles.quizzes.destroy', $client->slug, $course->slug, $module->slug, $article->id, $article->doQuiz->id], 'method' => 'delete']) !!}
                        <a href="{{ route('clients.manage.courses.modules.articles.quizzes.edit', [
                    'clientSlug' => $client->slug,
                    'courseSlug' => $course->slug,
                    'moduleSlug' => $module->slug,
                    'articleId' => $article->id,
                    'quizId' => $article->doQuiz->id,
                ]) }}" class="btn btn-info">Edit Do Quiz</a>
                        <button class="btn btn-danger" type="submit">
                            <i class="fa fa-trash"></i>
                            Delete Do Quiz
                        </button>
                        {!! Form::close() !!}
                    @else
                        <a href="{{ route('clients.manage.courses.modules.articles.quizzes.create', [
                    'clientSlug' => $client->slug,
                    'courseSlug' => $course->slug,
                    'moduleSlug' => $module->slug,
                    'articleId' => $article->id,
                    'quizType' => Pi\Clients\Courses\Quizzes\Quiz::TYPE_DO,
                ]) }}" class="btn btn-info">Create Do Quiz</a>
                    @endif

                    @if($article->answerQuiz)
                            {!! Form::open(['class' => 'delete-quiz-form', 'id' => 'delete-answer-quiz', 'route' => ['clients.manage.courses.modules.articles.quizzes.destroy', $client->slug, $course->slug, $module->slug, $article->id, $article->answerQuiz->id], 'method' => 'delete']) !!}
                        <a href="{{ route('clients.manage.courses.modules.articles.quizzes.edit', [
                    'clientSlug' => $client->slug,
                    'courseSlug' => $course->slug,
                    'moduleSlug' => $module->slug,
                    'articleId' => $article->id,
                    'quizId' => $article->answerQuiz->id,
                ]) }}" class="btn btn-info">Edit Answer Quiz</a>
                            <button class="btn btn-danger" type="submit">
                                <i class="fa fa-trash"></i>
                                Delete Answer Quiz
                            </button>
                            {!! Form::close() !!}
                    @else
                        <a href="{{ route('clients.manage.courses.modules.articles.quizzes.create', [
                    'clientSlug' => $client->slug,
                    'courseSlug' => $course->slug,
                    'moduleSlug' => $module->slug,
                    'articleId' => $article->id,
                    'quizType' => Pi\Clients\Courses\Quizzes\Quiz::TYPE_ANSWER,
                ]) }}" class="btn btn-info">Create Answer Quiz</a>
                    @endif
                </div>

                <div id="tools-watch-listen" class="tab-pane fade">
                    @include('pages.clients.courses.modules.articles.partials.edit-actions')
                </div>
            </div>
        </div>
    </div>
    @parent
@stop

@section('inline-styles')
    <link rel="stylesheet" href="/assets/plugins/raptor-editor/raptor-front-end.min.css">
    <style>
    .ui-icon-topic-create {
        display: block;
        width: 16px;
        height: 16px;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAU5JREFUeNpi/P//PwMlgAVEMDExNQIpbRL1Xv337189C5Sj29zcHPjnzx+4LMhlQAVg/PfvXzgNwuzs7AxdXV1McBcAAfPv378Zbt68+XblypVHYYYUFxf7gTRMmDBhE0zM0tLSWl1dXRikB+x6ZK8ANZ8EUv5QzPLp0yeGz58/w+TB4sePHz/JxsYG1wNzwbWmpiYQex5y+Pz8+ZMBGsgsSOLzZs2aBeJfQ5YoxRbA379/B/sZzYC1UMyALoEOWH/+/AUMPLALWPFGIy4DQEHEyMhAvgGMjCxAAxiJMwBLimRjZgaFNiNIjg1dEmowJBqxaDYHYg6QARBDGDigYgzoFjJhcdUKUJLQ1TUVg6QVZgY9PTMxkBhUDtUlIJNgzoGCZ9HRWZIg8b9/QbbAXMcITGgzngMZUsiuwGbABiC2whFmx4A4AMMASgBAgAEAx96Jw4UbHlsAAAAASUVORK5CYII=) 0 0 !important
    }

    .ui-icon-topic-link-create {
        display: block;
        width: 16px;
        height: 16px;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAABIFBMVEUAAAADAwMODg5NTU3///9MTEwAAAASEhIEBARFRUVUVFQvLy8QEBA6OjoDAwMEBAQfHx4BAQEEBAQSEhIqKiwAAAABAQEBAQEAAAABAQF+foMWFhZCQkKAgH8nJycpKSkAAADCwsGysrgAAACcnKWenqcAAAACAgIAAAA6OjpYWFgtLTUuLjaxsbG0tLTT09OOjpaQkJjExNHJydfd3d3g4ODc3Nzf3986Oj06Oj4+PkQ+PkVQUFBRUVFWVmJWVmNWVmVWVmZXV2dXV2haWmlbW2pgYGBhYWFiYmJvb29wcHBxcXFzc3N0dHR2dnZ3d3d4eHh7e3t9fX1/f3+AgICEhISIiIiZmZnCwsHGxsbU1OPW1tXa2trj4+Pq6urr6+vMJabiAAAAOHRSTlMAAAAAADU3QkVlZ25ycnuAgIGKj5aorK6wsbbExMXR09rc3+Dj4+bp6uzs8PD19vj5+fz8/f3+/gSYqYUAAADDSURBVBjTXc87TsNQEEDRO+OxDSaxjPIRNNBmAbSkYtksIBUtSp0GKVECfuD4xxta4HanvGL8zZimvzgEI1s7uLvHGNMNhsbXEzzEF6juFHNtvj6YD54eyFw9sclQPWqqPbfr7r1t5PJmbPxJAH+Wwt7UynBELb9IE46hNIuhGMczAONVEaLk06pcbWMuZ11t61MQzfIEFjM57OG7603bFrLSpPvsAUs0wmJZTHQsrAE1gOt7d1/Kbg8YQL0DoAaQ//s/oflNskbMmK4AAAAASUVORK5CYII=) 0 0 !important;
    }

    .ui-icon-topic-link-remove {
        display: block;
        width: 16px;
        height: 16px;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAByFBMVEUAAAACAgIDAwMEBAQODg4WFhYiIiIjIyMoKCgpKSkvLy85OTk6Ojo7MSZAQEBDQ0NFRUVJSUlLS0tNTU1PT09UVFRVVVWFZkaqgFX///9TU1NMTEwAAAASEhIEBARMTEwBAQEBAQFUVFRFRUVUVFQEBAQvLy8QEBA6OjoiIiJnZ2cEBAQfHx4BAQEODg4EBAQBAQESEhIuLi4qKiwAAAABAQEBAQEAAAABAQEBAQF+foMBAQEWFhZEREQBAQGAgH8BAQEBAQECAgIfHyAVFRUgICA9PT0JCQkCAgIcHBwAAAADAwPGxsbCwsEJCQm4uMAcHB2vr7sCAgITExM5OTkAAAAAAAA6OjpYWFgAAAAWFhYBAQGzs7Ovr64CAgIaGh+np66hoazT09Orq6rCws/Z2dmoqLC4uMPPz8/Ozs7a2trc3NwqKiorKysvLzM3N0A6OkA8PDw9PT0+PkVAQEBBQUFCQkJISEdISFNNTU9PT05PT1BQUFNRUVNWVmNhYWFjY2NnZ2dwcHBzc3Nzc3p0dHR2dnd3d3d3d3p+foJ/f36BgYClpbKmprG1tba4uLe4uMO+vsvOztzQ0N7U1OTX19fj4+Pm5uaBgo+/AAAAbHRSTlMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADM1N0JFT1BTX2VnaG5ycn19gICBhoqLj5CWqKyusLG1trm9v8LFzM3Pz9LU1dbY2Nrb29ze3+Lj5OXl5urs7O3t8PP09fb29/j5/Pz9/f3+/v5GyzMwAAAA7klEQVQY01XBQU6DQBgG0G+Gf2AssZRUE0kaqXWhTYwn8Aqe1b0ncOGmJi6MaBRtICWISAqDTGdc+x6bepIDgFG9BQCSi3h8wexjvWl7QK1Jzi+LBHYUi9qx4saQ8Kv0Dbgu65cmPueaGxVU+Z2sQvX+kHLGqftg84zGs913N+S3naCM5dTZ34T9ZP722YKwBuC2gdGeAAACgD3P5cx3fWFUTwDfh5yE3mh7dJW91pzIN0YG6snu9H1zKjkJrXXgbiYqSlbloXDIWrs8E9GXMztwQ1bQAODkeJALxu2qTDua2lalTBQAyk/dZCzCf39rtGqDiyOJzgAAAABJRU5ErkJggg==) 0 0 !important;
    }

    .ui-icon-tooltip-create {
        display: block;
        width: 16px;
        height: 16px;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAQlBMVEX///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQEBARERESEhJISEhKSkpmZmajo6Pj4+Pm5ubn5+f+/v7///+0W9fJAAAACXRSTlMABkeIiZCR7e6XQew6AAAAVUlEQVR4Aa2K3RpAIBBEp0WMyk94/1f1bRG6dm7acxoY61kYrEEX4lGIoYFXXxJaelB/qORLQzrm/P4U9nfY/L3IrFObFsILZ40uxAkeWDko48fByk8oVAzkAjoERAAAAABJRU5ErkJggg==) 0 0 !important;
    }

    .topic-name {
        background-color: #e79824;
        color: #fff;
        font-weight: 700;
    }

    .has-child-ul {
        list-style: none;
    }

    .has-child-ul > ul:not(".has-child-ul") {
        list-style: initial;
    }
    </style>

@stop

@section('inline-scripts')
    @parent
    {{--<script src="/assets/plugins/raptor-editor/raptor.js"></script>--}}
    <script src="/assets/js/pi/pages/clients/articles/edit.js"></script>


    @can('manage', $client)

    <script>
        (function ($) {
            $(function() {
                var clientId = '{{ $client->id }}';
                var uuid = '{{ $article->uuid }}';
                var clientSlug = '{{ $client->slug }}';
                var courseSlug = '{{ $course->slug }}';
                // Add Raptor editing functions here, or extract to a js file
                $('.panel-title-editable').raptor({
                    plugins: {
                        save: {
                            plugin: 'saveJson'
                        },
                        saveJson: {
                            url: '/api/articles/{{ $article->id }}/update',
                            postName: 'raptor-content',

                            post: function(data) {
                                data._token = '{{ csrf_token() }}';
                                return data;
                            },
                            id: function() {
                                return this.raptor.getElement().data('id');
                            }
                        },
                        modalLi: {

                        }
                    }, layouts: {
                        toolbar: {
                            uiOrder: [
                                ['logo'],
                                ['save', 'cancel']
                            ]
                        },
                        hoverPanel: {
                            uiOrder: [
                                ['clickButtonToEdit']
                            ]
                        }
                    }
                })
                var $editable = $(".body-editable");
                $editable.raptor({

                    //uriSave is used for inline image editor to save image updates
                    uriSave: '/api/filemanager/'+clientSlug+'/'+courseSlug,
                    bind: {
                        saved: function(data, xhr) {
                            // Update save  url to save the new version's id
                            this.plugins.saveJson.options.url = '/api/articles/'+data.article.id+'/update';
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
                            url: '/api/articles/{{ $article->id }}/update',
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
                                ['linkCreate', 'linkRemove', 'topicCreate', 'topicLinkCreate', 'topicLinkRemove', 'tooltipCreate'],
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
                })
            });
        })(jQuery);
    </script>

    <!-- Add qTip (start) -->
    <script src="/assets/plugins/textcomplete/qtip/jquery.qtip.min.js" type="text/javascript"></script>
    <link href="/assets/plugins/textcomplete/qtip/jquery.qtip.min.css" type="text/css" rel="stylesheet" />
    <!-- Add qTip (end) -->

    <!-- Add autocomplete (start) -->
    <script type="text/javascript" src="/assets/plugins/textcomplete/jquery.textcomplete.mod.js"></script>
    <link type="text/css" rel="stylesheet" href="/assets/plugins/textcomplete/jquery.textcomplete.mod.css" />
    <script>
        jQuery(function($) {
            var words = [];
            var summary = {}
            var tooltip = {}
            for(var i in window.Pi.snippets) {
                var snippet = window.Pi.snippets[i];
                words.push(snippet.shortCode);
                summary[snippet.shortCode] = snippet.description;
                tooltip[snippet.shortCode] = snippet.value;
            }
            $('.body-editable').attr("contenteditable", "").textcomplete([
                {
                    words: words,
                    summary: summary,
                    snippetStyle: '',//'background-color: #e79824; color: #fff; font-weight: 700;',
                    tooltip: tooltip,
                }
            ]).removeAttr("contenteditable");
        });
    </script>
    <!-- Add autocomplete (end) -->

    <!-- Quiz Deleting Confirmation -->
    <script>
        (function($) {
            $(".delete-quiz-form").submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                bootbox.confirm('Are you sure you wish to delete this quiz? All user progress and responses will be lost and cannot be recovered.', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                })
            })
        })(jQuery);
    </script>
    <!-- Quiz Deleting Confirmation -->
    @endcan
@stop