@extends('layouts.default')

@section('page-title') Create Client @stop

@section('content')

    {!! Form::model($client, ['route' => ['admin.clients.update', $client->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Edit client'])

    @include('pages.admin.clients.form', compact('administrators'))

    @include('include.inputs.text', [
        'name' => 'slug',
        'caption' => 'Slug',
        'required' => true
    ])

    <div class="form-group">
        {!! Form::label('industries', 'Industries', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <select multiple="multiple" name="industries[]" id="industries" class="form-control">
                @foreach($industriesList as $industry)
                    <option value="{{$industry->id}}" @if(isset($currentIndustries[$industry->id]))selected="selected"@endif>{{$industry->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    @include('include.formpanel.buttons')

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.clients.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
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