@extends('layouts.default')

@section('content')
    @include('include.panel.begin', [
        'title' => $client->name . ': Milestones',
        'buttons' => [[
            'url' => route('clients.manage.milestones.create', $client->slug),
            'class' => 'success',
            'title' => 'Create milestone'
        ]]
    ])

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Milestone</th>
            <th>Finish date</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($milestones as $milestone)
            <tr>
                <td>{{ $milestone->title }}</td>
                <td>{{ $milestone->string_finish_datetime }}</td>
                <td>
                    {!! Form::open(['route' => ['clients.manage.milestones.destroy', $client->slug, $milestone->id], 'method' => 'DELETE', 'class' => 'delete-form']) !!}
                    <a href="{{route('clients.manage.milestones.edit', [$client->slug, $milestone->id])}}" class="btn btn-primary btn-sm">Edit</a>

                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                        Delete
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('include.panel.end')
@stop

@section('inline-scripts')
    <script>
        (function ($) {
            $(".delete-form").submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                bootbox.confirm('Are you sure you wish to delete this milestone?', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                })
            });
        })(jQuery);
    </script>
@stop