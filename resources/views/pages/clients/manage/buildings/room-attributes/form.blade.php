{!! Form::hidden('client_id', $client->id) !!}

<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('snippet_key', 'Snippet Key', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('snippet_key', Input::old('snippet_key'), ['class' => 'form-control', 'placeholder' => 'Snippet Key']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('default_value', 'Default Value', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('default_value', Input::old('default_value'), ['class' => 'form-control', 'placeholder' => 'Default Value']) !!}
    </div>
</div>
{!! Form::hidden('is_required', '0') !!}
<div class="form-group">
    {!! Form::label('is_required', 'Required for every room?', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <div class="checkbox">
            <label class="form-checkbox form-normal form-primary active form-text">

                {!! Form::checkbox('is_required', '1', Input::old('is_required'), ['class' => 'form-control', 'placeholder' => 'Required for every room?']) !!}
                Yes, this is required for all rooms.
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('parent_room_attribute_id', 'Parent Attribute', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('parent_room_attribute_id', [null => 'Select a parent attribute'] + $roomAttributes->lists('name', 'id')->toArray(), Input::old('parent_room_attribute_id'), ['class' => 'form-control', 'placeholder' => 'Parent Attribute']) !!}
    </div>
</div>




