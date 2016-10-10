@extends('layouts.default')

@section('content')
    @include('include.panel.begin', [
        'title' => 'Events',
        'buttons' => [[
            'url' => route('clients.manage.events.create', $client->slug),
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
                    <a href="{{ route('clients.manage.events.edit', [$client->slug, $event->id]) }}" class="btn btn-sm btn-info">
                        Edit
                    </a>

                    <a href="{{ action('Client\Management\ClientEventsController@getDelete', [$client->slug, $event->id]) }}" class="btn btn-sm btn-danger">
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