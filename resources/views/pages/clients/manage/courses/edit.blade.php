@extends('layouts.default')

@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">Client: {{ $client->name }}</a></li>
    <li><a href="#">Manage</a></li>
    <li class="active">Edit Course: {{ $course->name }}</li>
@stop

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Edit Course</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($course, ['route' => ['clients.manage.courses.update', $client->slug, $course->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.courses.form')

            {!! Form::submit('Update Course', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.courses.users.index', ['clientSlug' => $client->slug, $course->slug]) }}" class="btn btn-success">Manage Students</a>
                <a href="{{ route('clients.manage.courses.modules.create', ['clientSlug' => $client->slug, $course->slug]) }}" class="btn btn-success">Create Module</a>
                <a href="{{ route('clients.manage.courses.structure', ['clientSlug' => $client->slug, $course->slug]) }}" class="btn btn-success">Edit Course Structure</a>

            </div>
            <h3 class="panel-title">Modules</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover" id="module-table">
                <thead>
                <tr>
                    <th class="col-sm-1">Number</th>
                    <th class="col-sm-5">Module</th>
                    <th class="col-sm-4">Slug</th>
                    <th class="col-sm-2">
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($course->modules as $module)

                    <tr class="module-row" data-module-id="{{ $module->id }}">
                        <td>
                            <span style="cursor: pointer; margin-right: 10px;">
                                <i class="fa fa-arrows"></i>
                            </span>
                            {{ $module->number }}
                        </td>
                        <td>
                            {{ Snippet::process($module->name, $viewData) }}
                        </td>
                        <td>{{ $module->slug }}</td>
                        <td>
                            {!! Form::open(['route' => ['clients.manage.courses.modules.destroy', $client->slug, $course->slug, $module->id],'id' => 'delete-form', 'method' => 'delete', 'class' => 'pull-right']) !!}
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            {!! Form::close() !!}
                            <a href="{{ route('clients.manage.courses.modules.edit', ['clientSlug' => $client->slug, 'courseSlug' => $course->slug, 'moduleSlug' => $module->slug]) }}" class="btn btn-sm btn-info pull-right">
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
    <script src="/assets/plugins/jquery-bpopup/jquery.bpopup.min.js"></script>
    <script src="/assets/plugins/jquery-sortable/jquery-sortable.js"></script>
    <script>
        (function ($) {
            $("#delete-form").submit(function() {
                var $form = $(this);
                bootbox.confirm('Are you sure you want to delete this module?  This action is irreversible and will delete all associated lessons.', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                });
                return false;
            });
            $("#module-table").sortable({
                containerSelector: 'table',
                itemPath: '> tbody',
                itemSelector: 'tr',
                placeholder: '<tr class="placeholder" style="height: 20px;"><td colspan="3" style="border: 3px dashed #bbb;"></td></tr>',
                onDrop: function($item, container, _super)
                {
                    var $rows = $("#module-table").find('tr.module-row');
                    var rowOrder = []
                    $rows.each(function() {
                        rowOrder.push($(this).data('moduleId'));
                    });

                    $.ajax({
                        url: '{{ route('clients.manage.courses.module-order', ['clientSlug' => $client->slug, 'id' => $course->id]) }}',
                        type: 'post',
                        data: {
                            _token: window.Pi._token,
                            order: rowOrder
                        },
                        success: function(response) {
                            window.location.reload();
                        }
                    })
                }
            });
            

        })(jQuery);
    </script>
@stop

@section('inline-styles')
    @parent
	<style type="text/css">
		#import_dialog {
			border: 1px solid grey;
			background-color: white;
			width: 600px;
			display: none;
		}
	</style>
@stop