@extends('layouts.default')

@section('content')
    {!! Form::open(['route' => [$routePrefix . 'store', $client->slug], 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => $client->name . ': Theme'])

    @include('include.inputs.begin', ['name' => 'industries', 'caption' => 'Industries'])

    <select multiple="multiple" name="industries[]" id="industries" class="form-control">
        @foreach($industriesList as $industry)
            <option value="{{$industry->id}}" @if(isset($currentIndustries[$industry->id]))selected="selected"@endif>{{$industry->title}}</option>
        @endforeach
    </select>

    @include('include.inputs.end')

    @include('include.formpanel.buttons')

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('clients.show', $client->slug)}}" class="btn">Cancel</a>

    @include('include.formpanel.end')
@stop

@section('inline-styles')
    <link rel="stylesheet" href="/assets/plugins/chosen/chosen.css"/>
@stop

@section('inline-scripts')
    <script src="/assets/plugins/chosen/chosen.jquery.min.js"></script>
    <script>
        $('#industries').chosen({
            placeholder_text_multiple: 'Select industries'
        });
    </script>
@stop