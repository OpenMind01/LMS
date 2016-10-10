<aside id="aside-container">
    <div id="aside">
        <div class="nano">
            <div class="nano-content">

                {{--Nav tabs--}}
                {{--================================--}}
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#resources-tab" data-toggle="tab">
                            <i class="fa fa-gear"></i> Lesson Styles Settings
                        </a>
                    </li>
                </ul>
                {{--================================--}}
                {{--End nav tabs--}}



                {{-- Tabs Content --}}
                {{--================================--}}

                <!-- Refer to public/assets/js/app/controllers/ClientLessonStyle/ClientLessonStyle.controller.js -->
                <div class="tab-content" ng-controller="ClientLessonStyleController as widget">

                    {{--Second tab (Custom layout)--}}
                    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
                    <div class="tab-pane fade in active" id="resources-tab">

                        <div class="pad-hor">
                            <p>Edit below the <b>base font size</b> and the <b>base font color shade</b>. You can also enable or disable the <b>sidebar toggler</b>, and the <b>distraction free</b> feature.</p>
                        </div>

                        <div class="pad-all">
                            <p>
                                Default Font Size<br>
                                <div id="font-size"></div>
                                <input id="font-size-val" type="text" ng-model="global.Client.client_settings.widget_settings.lesson_styles.font_size">
                            </p>
                            <hr>
                            <p>
                                Default Font Color<br>
                                <div id="font-color"></div>
                                <input id="font-color-val" type="text" ng-model="global.Client.client_settings.widget_settings.lesson_styles.font_color" style="display: none;">
                                <div id="font-color-render" style="height: 20px; background: rgb(60,60,60);"></div>
                            </p>
                            <hr>
                            <p>
                                <div class="box-inline mar-rgt">
                                    <input type="text" ng-model="global.Client.client_settings.widget_settings.lesson_styles.sidebars_hidden" style="display: none;">
                                    <input class="sw" type="checkbox"
                                        ng-checked="global.Client.client_settings.widget_settings.lesson_styles.sidebars_hidden == '1'"
                                        onchange="$(this).prev().val($(this).prop('checked')?1:0).change();"
                                    >
                                </div> Hide sidebars by default
                            </p>
                            <p>
                                <div class="box-inline mar-rgt">
                                    <input type="text" ng-model="global.Client.client_settings.widget_settings.lesson_styles.distraction_free" style="display: none;">
                                    <input class="sw" type="checkbox"
                                        onchange="$(this).prev().val($(this).prop('checked')?1:0).change();"
                                        ng-checked="global.Client.client_settings.widget_settings.lesson_styles.distraction_free == '1'"
                                    >
                                </div> Enable distraction free mode
                            </p>
                        </div>

                    </div>
                    {{--End second tab (Custom layout)--}}
                    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}

                </div>
            </div>
        </div>
    </div>
</aside>
