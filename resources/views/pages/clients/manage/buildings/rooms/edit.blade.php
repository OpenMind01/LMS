@extends('layouts.default')
@section('breadcrumbs')
    @parent
    <li><a href="{{ route('clients.show', [$client->slug]) }}">{{ $client->name }}</a></li>
    <li><a href="{{ route('clients.manage.buildings.index', [$client->slug]) }}">Manage Buildings</a></li>
    <li><a href="{{ route('clients.manage.buildings.edit', [$client->slug, $building->id]) }}">Building: {{ $building->name }}</a></li>
    <li class="active">Edit Room</li>
@stop
@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Edit Room</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($room, ['route' => ['clients.manage.buildings.rooms.update', $client->slug, $building->id, $room->id], 'method' => 'PUT', 'class' => 'form form-horizontal', 'files' => true]) !!}

            @include('pages.clients.manage.buildings.rooms.form')

            {!! Form::submit('Update Room', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a href="#" id="add-user-button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add User</a>
                    </div>
                    <h3 class="panel-title">Users in this room</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($room->users as $user)
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {!! Form::open(['route' => ['clients.manage.buildings.rooms.remove-user', $client->slug, $building->id, $room->id, $user->id], 'method' => 'DELETE']) !!}
                                    <button href="#" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
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
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a href="{{ route('clients.manage.buildings.room-attributes.index', [$client->slug, $building->id, $room->id]) }}" class="btn btn-info"><i class="fa fa-plus-circle"></i> Manage Client Room Attribute</a>
                        <a href="{{ route('clients.manage.buildings.rooms.attributes.create', [$client->slug, $building->id, $room->id]) }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Room Attribute</a>
                    </div>
                    <h3 class="panel-title">Room Attributes</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Snippet Key</th>
                            <th>Value</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($room->roomAttributes as $roomAttribute)
                            <tr>
                                <td>{{ $roomAttribute->name }}</td>
                                <td>{{ $roomAttribute->snippet_key }}</td>
                                <td>{{ $roomAttribute->value }}</td>
                                <td>
                                    {!! Form::open(['class' => 'remove-attribute-form', 'route' => ['clients.manage.buildings.rooms.attributes.destroy', $client->slug, $building->id, $room->id, $roomAttribute->id], 'method' => 'DELETE']) !!}
                                    <a href="{{ route('clients.manage.buildings.rooms.attributes.edit', [$client->slug, $building->id, $room->id, $roomAttribute->id]) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a>

                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                        Delete from Room
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
    <script src="/assets/plugins/bootform/dist/bootform-min.js"></script>
    <script>
        (function ($) {
            $("#add-user-button").click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/api/clients/{{$client->id}}',
                    type: 'get',
                    success: function(response)
                    {
                        if (response.success) {

                            var $form = $("<form class='form form-horiztonal'></form>");

                            var users = [];
                            for (var i in response.data.users) {
                                var user = response.data.users[i];
                                console.log(user);
                                users.push({value: user.id, text: user.last_name + ', ' + user.first_name});
                            }
                            bootform.select({
                                field: 'user_id',
                                label: 'User to Add',
                                options: users
                            }).appendTo($form);

                            bootbox.dialog({
                                title: 'Add a User to {{ $room->name }}:',
                                message: $form,
                                buttons: {
                                    cancel: {
                                        label: 'Cancel',
                                        className: 'btn btn-default'
                                    },
                                    ok: {
                                        label: 'Add User',
                                        className: 'btn btn-success',
                                        callback: function() {
                                            var userId = $form.find('select').val();
                                            $.ajax({
                                                url: '/c/{{$client->slug}}/manage/buildings/{{$building->id}}/rooms/{{$room->id}}/add-user/'+userId,
                                                type: 'PUT',
                                                success: function(response) {
                                                    if (response.success) {
                                                        window.location.reload();
                                                    }else {
                                                        bootbox.alert(response.message);
                                                    }
                                                }
                                            })
                                        }
                                    }
                                }
                            })
                        }
                    }
                })
            });

            $(".remove-attribute-form").click(function(e) {
                e.preventDefault();
                var $form = $(this);
                bootbox.confirm('Are you sure you wish to remove this room attribute?', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                });
            });
        })(jQuery);
    </script>
@stop