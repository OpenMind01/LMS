@extends('layouts.default')

@section('containerClasses', 'aside-in aside-right aside-bright boards')

@section('content')

    {{--Page Title--}}
    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
    <div id="page-title">
        <h1 class="page-header text-overflow">{{ $currentDiscussionGroup->title }} Discussion Board</h1>

        <div class="add-thread-button">
            <a href="{{ route($routePrefix . '.threads.create', array_merge($routeParameters, [$currentDiscussionGroup->slug])) }}" class="btn btn-lg btn-rounded btn-primary"><i class="fa fa-plus"></i> Start a new conversation</a>
        </div>
    </div>
    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
    {{--End page title--}}

    {{--Page content--}}
    {{--===================================================--}}
    <div id="page-content">

        <div class="discussions-filter-mode">
            <a href="#" class="selected">Recent</a>
            <a href="#">Popular</a>
            <a href="#">Not Answered</a>
        </div>
        <div class="panel panel-default panel-left">
            <div class="discussions-list"> 

                @foreach($currentDiscussionGroup->threads as $thread)
                <div class="single-discussion-list">
                    <div class="row">
                        <div class="col-sm-1 author-photo">
                            <img src="http://www.gravatar.com/avatar/{{ md5($thread->user->email) }}" class="img-circle img-sm" alt="Profile Picture">
                            <span class="label {{ $thread->user->role == 'student' ? 'label-primary' : 'label-purple' }}">{{ ucfirst($thread->user->role) }}</span><br>
                        </div>
                        <div class="col-sm-5">
                            @if ($thread->hand_raised)
                                <div>
                                    <button class="btn btn-xs btn-warning btn-labeled fa fa-hand-paper-o">Hand raised</button>
                                    {{-- <button class="btn btn-xs btn-info btn-labeled fa fa-thumb-tack">Sticky</button> --}}
                                </div>
                            @endif

                            <h2><a class="text-primary" href="{{ route($routePrefix . '.threads.show', array_merge($routeParameters, [$currentDiscussionGroup->slug, $thread->slug]))}}">{{$thread->title}}</a></h2>
                            <p class="meta">
                                by <a class="text-primary" href="#"><b>{{ $thread->user->fullName }}</b></a>
                                @if ($thread->assetsCount > 0)
                                    with <a class="text-primary" href="{{ route($routePrefix . '.threads.show', array_merge($routeParameters, [$currentDiscussionGroup->slug, $thread->slug]))}}">
                                        {{$thread->assetsCount}} attachments</a>
                                @endif
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <div class="discussion-replies">
                                <b>{{ $thread->answers->count() }}</b>
                                Replies
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="discussion-views">
                                <b>677</b>
                                Views
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="status">
                                <button class="btn btn-md btn-rounded btn-success"><i class="fa fa-check"></i> Question Answered</button>
                            </div>
                            <div class="last-interaction">
                                Last interaction {{ \Carbon\Carbon::createFromTimeStamp(strtotime($thread->updated_at))->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>{{-- Single Discussion List --}}
                @endforeach

            </div>
        </div>
        
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
