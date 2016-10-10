@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="{{ route('clients.manage.buildings.index', [$client->slug]) }}">Manage Buildings</a></li>
    <li class="active">Edit Building</li>
@stop
@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Edit Building</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($building, ['route' => ['clients.manage.buildings.update', $client->slug, $building->id], 'method' => 'PUT', 'class' => 'form form-horizontal', 'files' => true]) !!}

            @include('pages.clients.manage.buildings.form')

            {!! Form::submit('Update Building', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a href="{{ route('clients.manage.buildings.rooms.create', [$client->slug, $building->id]) }}" class="btn btn-success">Create Room</a>
                    </div>
                    <h3 class="panel-title">Rooms in this building</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Users</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($building->rooms as $room)
                        <tr>
                            <td>{{ $room->number }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->users->count() }}</td>
                            <td>
                                {!! Form::open(['route' => ['clients.manage.buildings.rooms.destroy', $client->slug, $building->id, $room->id], 'method' => 'DELETE', 'class' => 'delete-room-form']) !!}
                                <a href="{{ route('clients.manage.buildings.rooms.edit', [$client->slug, $building->id, $room->id]) }}"
                                   class="btn btn-info btn-sm">
                                    <i class="fa fa-pencil"></i>
                                    Edit Room
                                </a>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                    Delete Room
                                </button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('inline-scripts')
    <script>
        (function ($) {
            $('.delete-room-form').submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                bootbox.confirm('Are you sure you want to delete this room? If there are any users in this room, they will no longer be assigned a room.', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                })
            });
        })(jQuery);
    </script>
@stop