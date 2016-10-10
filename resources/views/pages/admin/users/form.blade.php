@include('include.inputs.text', [
    'name' => 'first_name',
    'caption' => 'First Name',
    'required' => true
])

@include('include.inputs.text', [
    'name' => 'last_name',
    'caption' => 'Last Name',
    'required' => true
])

@include('include.inputs.text', [
    'name' => 'email',
    'caption' => 'Email',
    'required' => true
])

@include('include.inputs.password', [
    'name' => 'password',
    'caption' => 'Password',
    'required' => false,
])


@include('include.inputs.password', [
    'name' => 'repeat_password',
    'caption' => 'Repeat password',
    'required' => false,
])

<!--
@include('include.inputs.select', [
    'name' => 'role',
    'caption' => 'Role',
    'values' => $roles
])
-->

@include('include.inputs.text', [
    'name' => 'phone_mobile',
    'caption' => 'Phone (Mobile)'
])

@include('include.inputs.text', [
    'name' => 'phone_work',
    'caption' => 'Phone (Work)'
])

@include('include.inputs.text', [
    'name' => 'phone_home',
    'caption' => 'Phone (Home)'
])

@include('include.inputs.text', [
    'name' => 'address_street',
    'caption' => 'Street Address'
])

@include('include.inputs.text', [
    'name' => 'address_street_2',
    'caption' => ' '
])

<div class="form-group">
    {!! Form::label('address_city', ' ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        {!! Form::text('address_city', Input::old('address_city'), ['class' => 'form-control', 'placeholder' => 'City']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::text('address_state', Input::old('address_state'), ['class' => 'form-control', 'placeholder' => 'State']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::text('address_postal', Input::old('address_postal'), ['class' => 'form-control', 'placeholder' => 'Zip']) !!}
    </div>
</div>

@if(!empty($rooms))
<div class="form-group">
    {!! Form::label('room_id', 'Room', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('room_id', $rooms, Input::old('room_id'), ['class' => 'form-control', 'placeholder' => 'Room']) !!}
    </div>
</div>
@endif


<div class="form-group">
    {!! Form::label('avatar', 'Avatar', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::file('avatar') !!}
    </div>
</div>

<div class="form-group">
    {!!Form::select('role', $roles ,isset($user->role)?$user->role : old('role') ,array('onchange'=>''))!!}
</div>


<div class="form-group">
    {!!Form::select('client', $clients ,old('client'),array('onchange'=>'updateClient(this)'))!!}
    {!!Form::select('course', [] ,old('course'),array('id' => 'courses-select'))!!}
</div>


<script type="text/javascript">
    window.onload = function() {
        updateClient($('select[name="client"]'));
    };

    function updateClient(clientSelect) {
        var url = '{{ route("api.client.courses", ":id") }}';
        url = url.replace(':id', $(clientSelect).val());
        $('select[name="course"]').empty();
        $.ajax({
            url: url,
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            type: 'GET',
            success: function( json ){
                $.each(json, function(i, value){
                    $('select[name="course"]').append($('<option>').text(value.name).attr('value', value.id));
                });
            }
        });




    };

</script>

