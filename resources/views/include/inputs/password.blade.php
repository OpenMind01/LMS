@include('include.inputs.begin', compact('name', 'caption', 'required'))

{!! Form::password($name, [
    'class' => 'form-control',
    'id' => $name,
    'placeholder' => isset($placeholder) ? $placeholder : (isset($caption) ? $caption : '')])
    !!}

@include('include.inputs.end', compact('hint'))