@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="{{ route('clients.manage.buildings.index', [$client->slug]) }}">Manage Buildings</a></li>
    <li class="active">Room attributes for {{ $client->name }}</li>
@stop
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.buildings.room-attributes.create', ['clientSlug' => $client->slug]) }}" class="btn btn-success">Create Room Attribute</a>
            </div>
            <h3 class="panel-title">Room Attributes for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Room</th>
                    @foreach($roomAttributes as $attribute)
                        <th>{{ $attribute->name }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($buildings as $building)
                    <tr>
                        <td colspan="{{ $roomAttributes->count()+1 }}">Building: <strong>{{ $building->name }}</strong></td>
                    </tr>
                    @foreach($building->rooms as $room)
                    <tr>
                        <td>{{ $room->name }}</td>
                        @foreach($roomAttributes as $attribute)
                            <td>
                                <div class="editable"
                                    data-pk="{{ $room->id }}"
                                >
                                    {{ $room->roomAttributes->getValueForAttributeId($attribute->id) }}
                                </div>

                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop