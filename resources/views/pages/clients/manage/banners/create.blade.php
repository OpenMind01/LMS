@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Create a Banner for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => ['clients.manage.banners.store', $client->slug], 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.banners.form')

            {!! Form::submit('Create Banner', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <script type="text/javascript" src="/assets/plugins/textcomplete/jquery.textcomplete.mod.js"></script>
    <link type="text/css" rel="stylesheet" href="/assets/plugins/textcomplete/jquery.textcomplete.mod.css" />
    <script>
    (function($) {
        $(document).on('ready', function() {
            var allowed = [
                'client.name',
                'user.first_name',
                'user.last_name',
                'user.rank',
            ];

            var isAllowed = function(value) {
                return $.inArray(value.shortCode, allowed) !== -1;
            };

            var words = [];
            var summary = {}
            var tooltip = {}

            var allowedSnippets = window.Pi.snippets.filter(isAllowed);

            for(var i in allowedSnippets) {
                var snippet = allowedSnippets[i];
                words.push(snippet.shortCode);
                summary[snippet.shortCode] = snippet.description;
                tooltip[snippet.shortCode] = snippet.value;
            }
            $('#body').textcomplete([
                {
                    words: words,
                    summary: summary,
                    snippetStyle: '',//'background-color: #e79824; color: #fff; font-weight: 700;',
                    tooltip: tooltip,
                }
            ]);
        });
    })(jQuery);
    </script>
@stop