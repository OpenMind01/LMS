@extends('layouts.default')

@section('content')
    @include('include.panel.begin', [
        'title' => 'Schedule a meeting'
    ])

    @if(count($meetings))
        @include('include.inputs.begin')

        <div class="mar-btm">
            <h5>Already arranged meetings:</h5>
            @foreach($meetings as $meeting)
                {{$meeting->start_at->format(\Pi\Constants::getDateTimeFormat())}} - {{$meeting->reason}} <br/>
            @endforeach
        </div>

        @include('include.inputs.end')
    @endif


    {!! Form::open(['method' => 'get', 'id' => 'date-choose-form', 'class' => 'form form-horizontal']) !!}

    @include('include.inputs.begin', ['name' => 'date', 'caption' => 'Meeting date'])

    {!! Form::input('text', 'date', $date->format(\Pi\Constants::getDateFormat()), ['id' => 'date', 'class' => 'input-sm']) !!}

    @include('include.inputs.end')

    {!! Form::close() !!}

    @if(count($times) == 0)
        Sorry, there is no available meeting times for this date.
    @else
        {!! Form::open(['class' => 'form form-horizontal']) !!}

        {!! Form::hidden('meeting_date', $date->format(\Pi\Constants::getDateFormat())) !!}

        @include('include.inputs.begin', ['caption' => 'Meeting time'])

        @foreach($times as $time)
            <?php $startTime = $time->getStartDateTime()->format(\Pi\Constants::getTimeFormat()); ?>

            <div class="radio">
                <label class="form-radio form-normal active form-text">
                    {!! Form::radio('meeting_time', $startTime, Input::old('meeting_time') == $startTime, ['class' => 'form-control']) !!}
                    {{$startTime}}
                </label>
            </div>
        @endforeach

        @include('include.inputs.end')

        @include('include.inputs.begin', ['caption' => 'Meeting type'])

        <?php $reasons = ['Pre-Assesment',
        'Post-Assessment',
        'Identify LMS administrator and moderators',
        'Generic']; ?>
        {!! Form::select('reason', array_combine($reasons, $reasons), Input::old('reason'), ['class' => 'form-control']) !!}

        @include('include.inputs.end')


        <div class="col-sm-10 col-sm-offset-2 mar-top">

        {!! Form::submit('Arrange', ['class' => 'btn btn-primary']) !!}
        <a href="{{route('clients.show', $client->slug)}}" class="btn">Cancel</a>

        </div>

        {!! Form::close() !!}
    @endif

    @include('include.panel.end')
@stop

@section('inline-styles')
    <link href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">
@stop


@section('inline-scripts')
    <script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

    <script>
        $(function(){
            $('#date').datepicker({
                autoclose:true,
                daysOfWeekDisabled: [0,6],
                startDate: new Date()
            }).on('changeDate', function(e) {
                $('#date-choose-form').submit();
                return false;
            });;
        });
    </script>
@stop