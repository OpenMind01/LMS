<aside id="aside-container">
    <div id="aside">
        <div class="nano">
            <div class="nano-content">

                {{--Nav tabs--}}
                {{--================================--}}
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#resources-tab" data-toggle="tab">
                            <i class="fa fa-file"></i>
                            <span class="badge badge-purple">7</span>
                        </a>
                    </li>
                    <li>
                        <a href="#calendar-tab" data-toggle="tab">
                            <i class="fa fa-calendar"></i>
                            <span class="badge badge-primary">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="#discussion-boards-tab" data-toggle="tab">
                            <i class="fa fa-comments"></i>
                            <span class="badge badge-purple">5</span>
                        </a>
                    </li>
                </ul>
                {{--================================--}}
                {{--End nav tabs--}}



                {{-- Tabs Content --}}
                {{--================================--}}
                <div class="tab-content">

                    {{--Second tab (Custom layout)--}}
                    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
                    <div class="tab-pane fade in" id="calendar-tab">

                        <div class="pad-all">
                            <div id='demo-calendar'></div>
                        </div>

                    </div>
                    {{--End second tab (Custom layout)--}}
                    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}

                    {{--Second tab (Custom layout)--}}
                    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
                    <div class="tab-pane fade in active" id="resources-tab">

                        <h4 class="pad-hor text-thin">
                            <span class="pull-right badge badge-primary">5</span> <b>Resources</b>
                        </h4>

                        <div class="pad-hor">
                            <p>This is your list of resources for the present module. Feel free to download them at any time to help you go through the lessons.</p>
                        </div>

                        <hr>
                        @foreach($currentClient->resources->getTypes() as $key => $value)
                            @if(count($currentClient->resources->ofType($key)) > 0)
                            <div class="clearfix pad-hor">
                                <h5>{{ $currentClient->resources->nameForType($key) }}s</h5>
                            </div>
                            @endif
                            @foreach($currentClient->resources->ofType($key) as $resource)
                                <a href="{{ $resource->url }}" target="_blank" class="list-group-item border-ver">
                                    <div class="media-left">
                                        <span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
				                            <i class="fa fa-2x {{ $resource->type_icon }}"></i>
			                            </span>
                                    </div>
                                    <div class="media-body">
                                        <span class="text-muted">{{ $resource->type_name }}</span>
                                        <div class="text-lg">{{ $resource->name }}</div>
                                        @if($resource->file_size)
                                        <span class="text-muted">{{ $resource->file_size }}</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                            <hr>
                        @endforeach

                    </div>
                    {{--End second tab (Custom layout)--}}
                    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}

                    {{--First tab (Contact list)--}}
                    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
                    <div class="tab-pane fade in" id="discussion-boards-tab">
                        <h4 class="pad-hor text-thin">
                            <b>Discussion Boards</b>
                        </h4>

                        <p class="pad-hor">This is your list of available discussion boards for the course {{-- $course->name --}}.</p>

                        {{--Family--}}
                        <ul class="list-group">
                            <li class="list-group-item bord-ver"><span class="badge badge-primary">20</span><a href="#">Cras justo odio</a></li>
                            <li class="list-group-item bord-ver"><a href="#">Dapibus ac facilisis in</a></li>
                            <li class="list-group-item bord-ver"><a href="#">Morbi leo risus</a></li>
                            <li class="list-group-item bord-ver"><span class="badge badge-success">11</span><a href="#">Porta ac consectetur ac</a></li>
                            <l class="list-group-item bord-ver"><a href="#">Vestibulum at eros</a></l
                        </ul>


                        <hr>
                        <h4 class="pad-hor text-thin">
                            <span class="pull-right badge badge-info">4</span> <b>Recent Board Activity</b>
                        </h4>

                        {{--Friends--}}
                        <div class="list-group bg-trans">
                            <a href="#" class="list-group-item">
                                <div class="media-left">
                                    <img class="img-circle img-xs" src="/assets/img/av5.png" alt="Profile Picture">
                                </div>
                                <div class="media-body">
                                    <span class="text-muted">Betty Murphy</span>
                                    <div class="text-lg">Added a new comment on Vestibulum at eros.</div>
                                    <span class="text-muted">2 minutes ago</span>
                                </div>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="media-left">
                                    <img class="img-circle img-xs" src="/assets/img/av6.png" alt="Profile Picture">
                                </div>
                                <div class="media-body">
                                    <span class="text-muted">Mike Ross</span>
                                    <div class="text-lg">Added a new comment on Dapibus ac facilisis in.</div>
                                    <span class="text-muted">39 minutes ago</span>
                                </div>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="media-left">
                                    <img class="img-circle img-xs" src="/assets/img/av4.png" alt="Profile Picture">
                                </div>
                                <div class="media-body">
                                    <span class="text-muted">Sarah Ruiz</span>
                                    <div class="text-lg">Shared a file in Dapibus ac facilisis in.</div>
                                    <span class="text-muted">1 hour ago</span>
                                </div>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="media-left">
                                    <img class="img-circle img-xs" src="/assets/img/av3.png" alt="Profile Picture">
                                </div>
                                <div class="media-body">
                                    <span class="text-muted">Paul Aguilar</span>
                                    <div class="text-lg">Added a new comment on Dapibus ac facilisis in.</div>
                                    <span class="text-muted">2 hours ago</span>
                                </div>
                            </a>
                        </div>

                    </div>
                    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}

                </div>
            </div>
        </div>
    </div>
</aside>
