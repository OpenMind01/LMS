@extends('layouts.default')

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('admin.usergroups.create') }}" class="btn btn-success">Create user group</a>
            </div>
            <h3 class="panel-title">User groups</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Open</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($usergroups as $usergroup)
                    <tr>
                        <td>{{ $usergroup->title }}</td>
                        <td>{{ $usergroup->ready ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.usergroups.edit', ['id' => $usergroup->id]) }}" class="btn btn-sm btn-info">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $usergroups->render() !!}
        </div>
    </div>
@stop