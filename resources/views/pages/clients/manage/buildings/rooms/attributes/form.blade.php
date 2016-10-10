{!! Form::hidden('pivot[client_id]', $client->id) !!}

<div class="form-group">
    {!! Form::label('pivot[room_attribute_id]', 'Room Attribute', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('pivot[room_attribute_id]', $roomAttributes->lists('name', 'id')->toArray(), Input::old('pivot[room_attribute_id'), ['class' => 'form-control']) !!}

    </div>
</div>


<div class="form-group">
    {!! Form::label('pivot[value]', 'Value', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('pivot[value]', Input::old('pivot[value]'), ['class' => 'form-control', 'placeholder' => 'Value']) !!}
    </div>
</div>




