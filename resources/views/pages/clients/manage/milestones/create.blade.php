@extends('layouts.default')

@section('inline-styles')
    <link href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">
@stop

@section('content')
    {!! Form::open(['route' => ['clients.manage.milestones.store', $client->slug], 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => $client->name . ': Create milestone'])

    @include('include.inputs.text', [
        'name' => 'title',
        'caption' => 'Title',
        'required' => true,
    ])

    @include('include.inputs.date', [
        'name' => 'finish_at',
        'caption' => 'Finish date',
        'required' => true,
    ])

    @include('include.inputs.begin', [
        'name' => 'assignable_type',
        'title' => 'Assign to'
    ])
        <div class="radio">
            <label class="form-radio form-normal form-text">
                {!! Form::radio('assignable_type', 'client', old('assignable_type', 'client') == 'client', [
                    'class' => 'form-control',
                    'id' => 'assignable_type_client']) !!}

                All client users
            </label>

            @if(count($usergroups))
                <label class="form-radio form-normal form-text">
                    {!! Form::radio('assignable_type', 'usergroup', old('assignable_type', 'client') == 'usergroup', [
                        'class' => 'form-control',
                        'id' => 'assignable_type_usergroup']) !!}

                    Usergroup users
                </label>
            @endif
        </div>
    @include('include.inputs.end')

    @if(count($usergroups))
        @include('include.inputs.select', [
            'name' => 'usergroup_id',
            'caption' => 'User group',
            'values' => $usergroups,
            'required' => true,
        ])
    @endif

    @include('include.formpanel.buttons')

    <input type="submit" class="btn btn-primary" value="Create"/>
    <a class="btn" href="{{route('clients.manage.milestones.index', $client->slug)}}">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop

@section('inline-scripts')
    <script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

    <script>
        $(function(){
            $('#finish_at').parent().datepicker({autoclose:true});

            function checkVisibility() {
@if(count($usergroups))
                $('#usergroup_id-form-group').toggle($('#assignable_type_usergroup').prop('checked'));
@endif
            }

            $('input[name=assignable_type]').change(function(){
                checkVisibility();
            });

            checkVisibility();
        });
    </script>
@stop