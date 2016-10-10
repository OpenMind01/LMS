{!! Form::hidden('client_id', $client->id) !!}

<div class="form-group">
    {!! Form::label('number', 'Number', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::text('number', Input::old('number'), ['class' => 'form-control', 'placeholder' => 'Number']) !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    </div>
</div>

@include('include.inputs.begin', [
    'name' => 'emergency_route',
    'caption' => 'Emergency route'
])
{!! Form::file('emergency_route', ['id' => 'emergency_route', 'class' => 'form-control']) !!}

@if(isset($room) && $room->hasEmergencyRoute())
    <br/>
    <img src="{{$room->getEmergencyRoute()->url()}}"/>
    <br/>
@endif

@include('include.inputs.end')