@extends('layouts.default')

@section('content')
    @include('include.panel.begin', [
        'title' => 'Events',
        'buttons' => [[
            'url' => route('admin.events.create'),
            'title' => 'Create Event',
            'class' => 'success'
        ]]])

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->period_string }}</td>
                <td>
                    <a href="{{ route('admin.events.edit', ['id' => $event->id]) }}" class="btn btn-sm btn-info">
                        Edit
                    </a>

                    <a href="{{ action('Admin\EventsController@getDelete', ['id' => $event->id]) }}" class="btn btn-sm btn-danger">
                        Delete
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $events->render() !!}

    @include('include.panel.end')
@stop