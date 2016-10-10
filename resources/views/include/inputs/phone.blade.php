@include('include.inputs.begin', compact('name', 'caption', 'required'))

{!! Form::text($name, Input::old($name, isset($default) ? $default : null), [
    'class' => 'form-control',
    'id' => $name,
    'placeholder' => isset($placeholder) ? $placeholder : (isset($caption) ? $caption : '')])
    !!}

@include('include.inputs.end', compact('hint'))