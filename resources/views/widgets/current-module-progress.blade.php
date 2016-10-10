<div class="widget" data-widget="current-module-progress">
@include('include.panel.begin', ['title' => 'Current Module Progress'])
<h5 class="text-thin">
    <b>Your progress</b>
</h5>

<div class="">
    <div class="progress">
        <div style="width: 75%;" class="progress-bar progress-bar-info">75%</div>
    </div>
</div>

<p class="">This is your list of available lessons for this module.</p>

<!--Family-->
<ul class="list-group lessons-list">
    <li class="list-group-item bord-ver">
        <a href="#">
            <div class="lesson-list">1. Cras justo odio <span class="label label-success">Completed</span></div>
            <div class="progress progress-xs"><div style="width: 100%;" class="progress-bar progress-bar-success"></div></div>
        </a>
    </li>
    <li class="list-group-item bord-ver">
        <a href="#">
            <div class="lesson-list">2. Dapibus ac facilisis in <span class="label label-primary">In progress</span></div>
            <div class="progress progress-xs"><div style="width: 75%;" class="progress-bar"></div></div>
        </a>
    </li>
    <li class="list-group-item bord-ver">
        <a href="#">
            <div class="lesson-list">3. Morbi leo risus</div>
            <div class="progress progress-xs"><div style="width: 0%;" class="progress-bar"></div></div>
        </a>
    </li>
    <li class="list-group-item bord-ver">
        <a href="#">
            <div class="lesson-list">4. Porta ac consectetur ac</div>
            <div class="progress progress-xs"><div style="width: 0%;" class="progress-bar"></div></div>
        </a>
    </li>
    <li class="list-group-item bord-ver">
        <a href="#">
            <div class="lesson-list">5. Vestibulum at eros</div>
            <div class="progress progress-xs"><div style="width: 0%;" class="progress-bar"></div></div>
        </a>
    </li>
    <li class="list-group-item bord-ver">
        <a href="#">
            <div class="lesson-list">6. Dolor sit amet</div>
            <div class="progress progress-xs"><div style="width: 0%;" class="progress-bar"></div></div>
        </a>
    </li>
    <li class="list-group-item bord-ver">
        <a href="#">
            <div class="lesson-list">7. My cat is cool</div>
            <div class="progress progress-xs"><div style="width: 0%;" class="progress-bar"></div></div>
        </a>
    </li>
</ul>
@include('include.panel.end')
</div>