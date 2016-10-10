@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li class="active">Manage Buildings</li>
@stop
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.buildings.create', ['clientSlug' => $client->slug]) }}" class="btn btn-success">Create Building</a>
            </div>

            <div class="panel-control">
                <a href="{{ route('clients.manage.buildings.room-attributes.index', ['clientSlug' => $client->slug]) }}" class="btn btn-info">Manage Room Attributes</a>
            </div>
            <h3 class="panel-title">Buildings for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Rooms</th>
                    <th>Users</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($buildings as $building)
                    <tr>
                        <td>{{ $building->number }}</td>
                        <td>{{ $building->name }}</td>
                        <td>{{ $building->rooms->count() }}</td>
                        <td>{{ $building->users->count() }}</td>
                        <td>
                            {!! Form::open(['route' => ['clients.manage.buildings.destroy', $client->slug, $building->id], 'method' => 'DELETE', 'class' => 'delete-building-form']) !!}
                            <a href="{{ route('clients.manage.buildings.edit', [$client->slug, $building->id]) }}" class="btn btn-info">Edit</a>
                            <button class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                                Delete
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('inline-scripts')
    <script>
        (function ($) {
            $(".delete-building-form").submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                bootbox.confirm('Are you sure you wish to delete this building? All rooms will be deleted and users will no longer be assigned a room.', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                })
            });
        })(jQuery);
    </script>
@stop