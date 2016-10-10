<div class="form-group">
    <label for="{{ $quizElement->input_name }}" class="control-label">{!! $quizElement->label !!}</label>
        @foreach($quizElement->options as $option)
            <div class="checkbox">
                <label class="form-checkbox form-normal form-primary form-text">
                    {!! Form::checkbox($quizElement->input_name.'['.$option->value.']', $option->value, Input::old($quizElement->input_name.'['.$option->value.']', false), ['class' => 'form-control']) !!}
                    {{ $option->label }}
                </label>
            </div>
        @endforeach
</div>