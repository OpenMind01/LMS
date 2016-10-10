@extends('layouts.default')

@section('content')
    <div class="panel">
        @include('pages.clients.activation.tabs', ['selected' => 'industries'])

        {!! Form::model($client, ['class' => 'form form-horizontal']) !!}

        <div class="panel-body">
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
        </div>

        <div class="panel-footer">
            <div class="form-group">
                <div class="col-sm-2">
                    <a href="{{action('Client\ActivationController@getMain', $client->slug)}}" class="btn btn-warning pull-right">Back</a>
                </div>
                <div class="col-sm-10">
                    {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
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