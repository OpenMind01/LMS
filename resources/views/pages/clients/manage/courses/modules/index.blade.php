@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.modules.create', ['clientSlug' => $client->slug]) }}" class="btn btn-success">Create Module</a>
            </div>
            <h3 class="panel-title">Modules for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th># of Modules</th>
                    <th class="col-sm-1">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($modules as $module)
                    <tr>
                        <td>
                            {{ Snippet::process($module->name) }}
                            <div style="color: #aaa">Slug: {{ $module->slug }}</div>
                        </td>
                        <td>{{ $module->modules->count() }}</td>
                        <td>
                            <a href="{{ route('clients.manage.modules.edit', ['clientSlug' => $client->slug, 'moduleSlug' => $module->slug]) }}" class="btn btn-sm btn-info">
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