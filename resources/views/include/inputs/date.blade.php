@include('include.inputs.begin', compact('name', 'caption', 'required'))

<div class="input-group date">
    {!! Form::text($name, Input::old($name, isset($default) ? $default : null), [
        'class' => 'form-control',
        'id' => $name,
        'placeholder' => isset($placeholder) ? $placeholder : (isset($caption) ? $caption : '')])
        !!}

    <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
</div>

@include('include.inputs.end', compact('hint'))