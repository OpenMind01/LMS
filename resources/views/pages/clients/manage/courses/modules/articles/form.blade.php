{!! Form::hidden('client_id', $client->id) !!}

<div class="form-group">
    {!! Form::label('number', 'Number', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('number', Input::old('number'), ['disabled' => '', 'class' => 'form-control', 'placeholder' => 'Number']) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    </div>
</div>

