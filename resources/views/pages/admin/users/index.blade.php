@extends('layouts.default')

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">Create User</a>
            </div>
            <h3 class="panel-title">Users</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Client</th>
                    <th>Role</th>
                    <th>&nbsp;</th>

                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->active)
                                {{ $user->full_name }}</td>
                            @else
                                (Unactivated)
                            @endif
                        <td>
                            <div>{{ $user->hasClient() ? $user->client->name : '' }}</div>
                        </td>
                        <td>
                            <div>{{ $user->role }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" class="btn btn-sm btn-info">
                                Edit
                            </a>
                            <a href="{{ route('admin.users.impersonate', ['id' => $user->id]) }}" class="btn btn-sm btn-dark">
                                Impersonate
                            </a>
                            {!! Form::open(['route' => ['admin.users.destroy', $user->id], 'method' => 'DELETE', 'class' => 'form form-inline']) !!}
                            {!! Form::submit('Disable', ['class' => 'btn btn-sm btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $users->render() !!}
        </div>
    </div>


@stop