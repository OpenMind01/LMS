<div class="widget" data-widget="resources"> 
@include('include.panel.begin', ['title' => 'Resources'])
<h5 class="text-thin">
    <b>Course 1 documents</b>
</h5>

<div class="list-group bg-trans">
    <a href="#" class="list-group-item">
        <div class="media-left">
            <span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
				<i class="fa fa-file-pdf-o fa-2x"></i>
			</span>
        </div>
        <div class="media-body">
            <span class="text-muted">PDF</span>
            <div class="text-lg">Course briefing</div>
            <span class="text-muted btn-link">Download</span>
        </div>
    </a>
    <a href="#" class="list-group-item">
        <div class="media-left">
            <span class="icon-wrap icon-wrap-sm icon-circle bg-primary">
				<i class="fa fa-file-word-o fa-2x"></i>
			</span>
        </div>
        <div class="media-body">
            <span class="text-muted">Microsoft Word</span>
            <div class="text-lg">Introduction to lesson</div>
            <span class="text-muted btn-link">Download</span>
        </div>
    </a>
</div>
@include('include.panel.end')
</div>