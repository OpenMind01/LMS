@extends('layouts.default')

@section('content')
    <div class="panel">
        @include('pages.clients.activation.tabs', ['selected' => 'usergroups'])

        {!! Form::model($client, ['class' => 'form form-horizontal']) !!}

        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('usergroups', 'User groups', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <select multiple="multiple" name="usergroups[]" id="usergroups" class="form-control">
                        @foreach($usergroupsList as $usergroup)
                            <option value="{{$usergroup->id}}" @if(isset($currentUsergroups[$usergroup->id]))selected="selected"@endif>{{$usergroup->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <div class="form-group">
                <div class="col-sm-2">
                    <a href="{{action('Client\ActivationController@getIndustries', $client->slug)}}" class="btn btn-warning pull-right">Back</a>
                </div>
                <div class="col-sm-10">
                    {!! Form::submit('Finish', ['class' => 'btn btn-primary']) !!}
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
        $('#usergroups').chosen({
            placeholder_text_multiple: 'Select user groups'
        });
    </script>
@stop