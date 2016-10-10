@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Edit Article</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($article, ['route' => ['clients.manage.courses.modules.articles.update', $client->slug, $article->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.courses.modules.articles.form')

            {!! Form::submit('Update Article', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel panel-primary">

        <!--Panel heading-->
        <div class="panel-heading">
            <div class="panel-control">

                <!--Nav tabs-->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-read" aria-expanded="true">Read</a>
                    <li class=""><a data-toggle="tab" href="#tab-watch" aria-expanded="false">Watch</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-listen" aria-expanded="false">Listen</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-answer" aria-expanded="false">Do / Answer</a></li>
                </ul>

            </div>
            <h3 class="panel-title">Edit Article Details</h3>
        </div>

        <!--Panel body-->
        <div class="panel-body">

            <!--Tabs content-->
            <div class="tab-content">
                <div id="tab-read" class="tab-pane fade active in">
                    <h4 class="text-thin">Edit Article Body</h4>
                    <hr>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($article->topics as $topic)
                        <li @if($topic->number == 1) class="active" @endif>
                            <a href="#section_{{$topic->number}}" role="tab" data-toggle="tab">
                                Section {{ $topic->number }}@if($topic->title): {{ $topic->title }}@endif
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        @foreach($article->topics as $topic)
                            <div class="tab-pane @if($topic->number == 1) active @endif" id="section_{{$topic->number}}">
                                {!! Snippet::process($topic->body, $viewData) !!}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="tab-watch" class="tab-pane fade">
                    <h4 class="text-thin">Edit Article Action: Watch</h4>
                    <p>Duis autem vel eum iriure dolor in hendrerit in vulputate.</p>
                </div>
                <div id="tab-listen" class="tab-pane fade">
                    <h4 class="text-thin">Edit Article Action: Listen</h4>
                    <p>Duis autem vel eum iriure dolor in hendrerit in vulputate.</p>
                </div>
                <div id="tab-answer" class="tab-pane fade">
                    <h4 class="text-thin">Edit Article Action: Do / Answer</h4>
                    @include('pages.clients.manage.courses.modules.articles.partials.answer')
                </div>
            </div>
        </div>
    </div>

@stop