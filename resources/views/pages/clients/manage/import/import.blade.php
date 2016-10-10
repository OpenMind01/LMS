@extends('layouts.default')

@section('content')
    {!! Form::open(['class' => 'form form-horizontal', 'files' => true]) !!}

    @include('include.formpanel.begin', ['title' => 'Import users'])

    @foreach($columnsData as $i => $column)
        @include('include.inputs.begin', ['name' => 'column[' . $i . ']', 'caption' => 'Column ' . ($i + 1)])
        {!! Form::select('column[' . $i . ']', $columnTypes, Input::old('column[' . $i . ']'), ['class' => 'form-control']) !!}
        @include('include.inputs.end', ['hint' => 'Values: ' . join(',', $column['sample'])])
    @endforeach

    @include('include.inputs.checkbox', [
        'name' => 'remove_first',
        'caption' => 'Remove first(caption) row',
        'hint' => 'Mark this if your csv file contains first row with column captions',
    ])

    @include('include.formpanel.buttons')

    {!! Form::submit('Import', ['class' => 'btn btn-primary']) !!}
    <a href="{{action('Client\Management\UsersImportController@getCancel', [$client->slug, $import->id])}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop