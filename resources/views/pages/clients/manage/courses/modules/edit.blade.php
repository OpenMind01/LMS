@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Module</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($module, ['route' => ['clients.manage.courses.modules.update', $client->slug, $course->slug, $module->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.courses.modules.form')

            {!! Form::submit('Update Module', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.courses.modules.articles.create', ['clientSlug' => $client->slug, $course->slug, $module->slug]) }}" class="btn btn-success">Create Article</a>
            </div>
            <h3 class="panel-title">Articles</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover" id="article-table">
                <thead>
                <tr>
                    <th class="col-sm-1">Number</th>
                    <th class="col-sm-3">Title</th>
                    <th class="col-sm-6">Body</th>
                    <th class="col-sm-2">
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($module->articles as $article)

                    <tr class="article-row" data-article-id="{{ $article->id }}">
                        <td>
                            <span style="cursor: pointer; margin-right: 10px;">
                                <i class="fa fa-arrows"></i>
                            </span>
                            {{ $article->number }}
                        </td>
                        <td>
                            {{ $article->name }}
                        </td>
                        <td>
                            {!! Snippet::process(str_limit($article->body, 100), $viewData) !!}
                        </td>
                        <td>
                            {!! Form::open(['route' => ['clients.manage.courses.modules.articles.destroy', $client->slug, $course->slug, $module->slug, $article->id],'id' => 'delete-form', 'method' => 'delete', 'class' => 'pull-right']) !!}
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            {!! Form::close() !!}
                            <a href="{{ route('clients.courses.modules.articles.edit', ['clientSlug' => $client->slug, 'courseSlug' => $course->slug, 'moduleSlug' => $module->slug, 'articleId' => $article->number]) }}" class="btn btn-sm btn-info pull-right">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('inline-scripts')
    <script src="/assets/plugins/jquery-sortable/jquery-sortable.js"></script>
    <script>
        (function ($) {
            $("#delete-form").submit(function() {
                var $form = $(this);
                bootbox.confirm('Are you sure you want to delete this article?  This action is irreversible.', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                });
                return false;
            });

            $("#article-table").sortable({
                containerSelector: 'table',
                itemPath: '> tbody',
                itemSelector: 'tr',
                placeholder: '<tr class="placeholder" style="height: 20px;"><td colspan="3" style="border: 3px dashed #bbb;"></td></tr>',
                onDrop: function($item, container, _super)
                {
                    var $rows = $("#article-table").find('tr.article-row');
                    var rowOrder = []
                    $rows.each(function() {
                        rowOrder.push($(this).data('articleId'));
                    });
                    console.log(rowOrder);
                    var url = '{{ route('clients.manage.courses.modules.article-order', ['clientSlug' => $client->slug, 'courseId' => $course->id, 'id' => $module->id]) }}';
                    console.log(url);
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            _token: window.Pi._token,
                            order: rowOrder
                        },
                        success: function(response) {
                            console.log(response);

                            window.location.reload();
                        }
                    })
                }
            });
        })(jQuery);
    </script>
@stop