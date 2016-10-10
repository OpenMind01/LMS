@extends('layouts.default')

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('admin.clients.create') }}" class="btn btn-success">Create Client</a>
            </div>
            <h3 class="panel-title">Clients</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Url</th>
                    <th>Users</th>
                    <th>&nbsp;</th>

                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->name }}</td>
                        <td>
                            <a href="{{ route('clients.show', ['slug' => $client->slug]) }}">{{ route('clients.show', ['slug' => $client->slug]) }}</a>
                        </td>
                        <td>{{ $client->users->count() }}</td>
                        <td>
                            <a href="{{ route('admin.clients.edit', ['id' => $client->id]) }}" class="btn btn-sm btn-info">Edit</a>
                            {!! Form::open(['route' => ['admin.clients.destroy', $client->id], 'method' => 'DELETE', 'class' => 'form form-inline']) !!}
                            {!! Form::submit('Disable', ['class' => 'btn btn-sm btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@stop