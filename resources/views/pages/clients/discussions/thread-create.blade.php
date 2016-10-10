@extends('layouts.default')

@section('containerClasses', 'aside-in aside-right aside-bright boards')

@section('content')
    {{--Page Title--}}
    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
    <div id="page-title">
        <h1 class="page-header text-overflow">Compose Thread Message</h1>
    </div>
    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
    {{--End page title--}}

    {{--Page content--}}
    {{--===================================================--}}
    <div id="page-content">

        {{-- Compose Thread Message --}}
        {{--===================================================--}}
        <form role="form" method="post" class="form-horizontal" enctype="multipart/form-data" action="{{ route($routePrefix . '.threads.store', $routeParameters) }}">

            <div class="panel panel-default panel-left">
                <div class="panel-body">

                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input placeholder="Write your question here..." type="text" id="title" name="title" class="form-control compose-title">
                        </div>
                    </div>

                    {{--Attact file button--}}
                    <div class="media pad-btm">
                        <div class="media-left">
                            <span class="btn btn-lg btn-primary btn-labeled fa fa-paper-plane btn-file" style="width: 166px;">
                                Add Attachment <input type="file" name="attachment" id="attachment">
                            </span>
                        </div>
                        <div id="demo-attach-file" class="media-body"></div>
                    </div>

                    <textarea placeholder="Write here more details about your question..." class="form-control" style="width:100%; height: 500px;" name="body" id="body"></textarea>

                    <div class="pad-ver">

                        {{--Send button--}}
                        <button type="submit" class="btn btn-success btn-labeled">
                            <span class="btn-label"><i class="fa fa-paper-plane"></i></span> Save Thread
                        </button>

                        {{--Discard button--}}
                        <a href="{{ route($routePrefix . '.index', $routeParameters) }}" type="button" class="btn btn-warning btn-labeled">
                            <span class="btn-label"><i class="fa fa-paper-plane"></i></span> Discard
                        </a>
                    </div>
                </div>
            </div>
        </form>
        {{--===================================================--}}
        {{-- End compose thread message --}}


    </div>
    {{--===================================================--}}
    {{--End page content--}}
@stop

@section('aside')
    @include('pages.clients.courses.modules.articles.partials.aside')
@stop

@section('inline-scripts')
<script type="text/javascript" src="/assets/js/p4.js"></script>
@stop