@extends('layouts.default')

@section('containerClasses', 'aside-in aside-right aside-bright boards')
@inject('assetStorage', Pi\Utility\Assets\AssetStorageService)

@section('content')
    {{--Page Title--}}
    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
    <div id="page-title">
        <h1 class="page-header text-overflow">
            {{ $thread->title }}
        </h1>
    </div>

    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
    {{--End page title--}}

    {{--Page content--}}
    {{--===================================================--}}
    <div id="page-content">

        <div class="panel panel-default panel-left discussion-single">
            <div class="panel-body">

                <div class="question">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="user-meta">
                                <img src="http://www.gravatar.com/avatar/{{ md5($thread->user->email) }}" class="img-circle img-sm" alt="Profile Picture">
                                <div class="text-bold">{{ $thread->question->user->fullName }}</div>
                                <small class="text-muted">{{ $thread->question->user->email }}</small>
                                <div class="user-stats">
                                    <span class="label {{ $thread->question->user->role == 'student' ? 'label-primary' : 'label-purple' }}">{{ ucfirst($thread->question->user->role) }}</span><br>
                                    Answers: <b>{{ $thread->question->user->answers->count() }}</b><br>
                                    {{--Appreciations: <b>23</b>--}}
                                </div>
                            </div>
                        </div>
                            <div class="col-sm-9">
                                <div class="message-well">
                                    <p class="mar-no"><small class="text-muted">{{ date('l d, M Y'), strtotime($thread->question->created_at) }}</small></p>
                                    @if ($thread->question->assets->count() > 0)
                                        <h4><i class="fa fa-paperclip fa-fw"></i> Attachments <span>({{ $thread->question->assets->count() }})</span></h4>
                                        @endif
                                    <div class="message-body">{{ $thread->question->body }}</div>
                                    @if (isset($hasAnswer))
                                    <div class="answer-body">
                                        <div class="answer-meta">This question has been answered by <a class="text-primary" href="#">John Doe</a> on June 14, 2015 14:22 - <a class="text-primary" href="#">Jump to the answer</a></div>
                                        <div class="message-body">{{ $thread->question->body }}</div>
                                    </div>
                                    @endif
                                    <div class="question-meta">
                                        <button class="btn btn-sm btn-primary btn-labeled fa fa-thumbs-up">I have this question too</button>

                                        @if (Auth::user()->isModerator() && !$thread->hand_raised)

                                            {{-- @TODO: Use a jQuery handler here --}}
                                            <a onclick="if(!confirm('Do you really want to raise hand for this thread?')) {return false }"
                                                href="{{ route($routePrefix . '.threads.raise_hand', $routeParameters) }}"
                                                class="btn btn-sm btn-warning btn-labeled fa fa-hand-paper-o">Raise Hand</a>
                                        @elseif ($thread->hand_raised)
                                            <button class="btn btn-sm btn-danger btn-labeled fa fa-hand-paper-o">Hand Raised</button>
                                        @endif

                                        {{-- @TODO: Use a jQuery handler here --}}
                                        <button class="btn btn-sm btn-success btn-labeled fa fa-pencil" onclick="$('#answer-thread-body').focus()">Answer this question</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>{{-- .question --}}

                @foreach ($thread->answers as $post)

                    <div class="answer">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="user-meta">
                                    <img src="http://www.gravatar.com/avatar/{{ md5($post->user->email) }}" class="img-circle img-sm" alt="Profile Picture">
                                    <div class="text-bold">{{ $post->user->fullName }}</div>
                                    <small class="text-muted">{{ $post->user->email }}</small>
                                    <div class="user-stats">
                                        <span class="label {{ $post->user->role == 'student' ? 'label-primary' : 'label-purple' }}">{{ ucfirst($post->user->role) }}</span><br>
                                        Answers: <b>{{ $post->user->answers->count() }}</b><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="message-well">
                                    <p class="mar-no"><small class="text-muted">{{ date('l d, M Y'), strtotime($post->created_at) }}</small></p>
                                    <div class="message-body">{{ $post->body }}</div>

                                        <div class="question-meta">
                                            @if (isset($shouldAppreciateAnswer))
                                                <button class="btn btn-sm btn-primary btn-labeled fa fa-thumbs-up">Appreciate answer</button>
                                            @endif
                                            @if (isset($shouldRaiseHand))
                                                <button class="btn btn-sm btn-warning btn-labeled fa fa-hand-paper-o">Raise hand</button>
                                            @endif

                                            @if (isset($shouldReplyMessage))
                                                <button class="btn btn-sm btn-success btn-labeled fa fa-pencil">Reply this message</button>
                                            @endif
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

                <div class="compose">
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="text-right">Compose answer</h4>
                            </div>
                            <div class="col-sm-9">
                                <div class="composer-well">
                                    <form method="post" action="{{ route($routePrefix . '.threads.reply', $routeParameters) }}">
                                        {!! csrf_field() !!}
                                        <textarea class="form-control" rows="10" name="body" id="answer-thread-body" placeholder="Write your answer here..."></textarea>
                                        <button type="submit" class="btn btn-lg btn-primary btn-labeled fa fa-paper-plane">Post answer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


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
