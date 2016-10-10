@include('include.inputs.text', [
    'name' => 'name',
    'caption' => 'Name',
    'required' => true
])

<div class="form-group">
    {!! Form::label('administrator_id', 'Administrator', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('administrator_id', $administrators, Input::old('administrator_id'), ['id' => 'administrator_id', 'class' => 'form-control'])  !!}
    </div>
</div>