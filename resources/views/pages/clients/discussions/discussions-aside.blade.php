@section('aside')
    {{--ASIDE--}}
    {{--===================================================--}}
    <aside id="aside-container">
        <div id="aside">
            <div class="nano">
                <div class="nano-content">

                    <div class="pad-hor">
                        <h4 class="text-thin">Discussion Boards</h4>

                        {{-- Compose button --}}
                        <a href="{{ route($routePrefix . '.create', $routeParameters) }}" class="btn btn-block btn-success">
                            Add a new board
                        </a>
                    </div>
                    <hr>
                    <div class="list-group bg-trans bord-no">
                        @foreach($discussionGroups as $discussionGroup)
                            <a href="{{ route($routePrefix . '.show', array_merge($routeParameters, [$discussionGroup->slug])) }}" class="list-group-item">
                                <span class="badge badge-success pull-right">{{ $discussionGroup->threads->count() }}</span><i class="fa fa-angle-double-left fa-fw"></i> {{ $discussionGroup->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </aside>
    {{--===================================================--}}
    {{--END ASIDE--}}
@stop

@section('containerClasses', 'aside-in aside-right aside-bright')
