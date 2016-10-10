<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('clients.manage.courses.modules.articles.actions.create', [$client->slug, $course->slug, $module->slug, $article->id]) }}" class="btn btn-success pull-right">Add Watch / Listen Action</a>
    </div>
    <div class="col-sm-6">
        <h4>Watch</h4>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Title</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($article->watchActions as $action)
                <tr>
                    <td>{{ $action->title }}</td>
                    <td>
                        {!! Form::open(['route' => ['clients.manage.courses.modules.articles.actions.destroy', $client->slug, $course->slug, $module->slug, $article->id, $action->id], 'method' => 'DELETE']) !!}
                        <a href="{{ $action->url }}" class="btn btn-xs btn-success"><i class="fa fa-search"></i> Preview</a>
                        <a href="{{ route('clients.manage.courses.modules.articles.actions.edit', [$client->slug, $course->slug, $module->slug, $article->id, $action->id]) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
                        <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <h4>Listen</h4>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Title</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($article->listenActions as $action)
                <tr>
                    <td>{{ $action->title }}</td>
                    <td>
                        {!! Form::open(['route' => ['clients.manage.courses.modules.articles.actions.destroy', $client->slug, $course->slug, $module->slug, $article->id, $action->id], 'method' => 'DELETE']) !!}
                        <a href="{{ $action->url }}" class="btn btn-xs btn-success"><i class="fa fa-search"></i> Preview</a>
                        <a href="{{ route('clients.manage.courses.modules.articles.actions.edit', [$client->slug, $course->slug, $module->slug, $article->id, $action->id]) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
                        <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>