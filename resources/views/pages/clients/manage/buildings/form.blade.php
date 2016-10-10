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


<div class="form-group">
    {!! Form::label('address_1', 'Street Address', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('address_1', Input::old('address_1'), ['class' => 'form-control', 'placeholder' => 'Street Address']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('address_2', 'Street Address 2', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('address_2', Input::old('address_2'), ['class' => 'form-control', 'placeholder' => 'Street Address 2']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('city', 'City/State/Zip', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('city', Input::old('city'), ['class' => 'form-control', 'placeholder' => 'City']) !!}
    </div>
    <div class="col-sm-2">
        {!! Form::text('state', Input::old('state'), ['class' => 'form-control', 'placeholder' => 'State']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::text('zip', Input::old('zip'), ['class' => 'form-control', 'placeholder' => 'Zip']) !!}
    </div>
</div>

@include('include.inputs.begin', [
    'name' => 'emergency_route',
    'caption' => 'Emergency route'
])
{!! Form::file('emergency_route', ['id' => 'emergency_route', 'class' => 'form-control']) !!}

@if(isset($building) && $building->hasEmergencyRoute())
    <br/>
    <img src="{{$building->getEmergencyRoute()->url()}}"/>
    <br/>
@endif

@include('include.inputs.end', [
    'hint' => 'This emergency will be used for rooms which don\'t have own emergency route'
])
