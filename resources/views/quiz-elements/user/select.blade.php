<div class="form-group">
    <label for="{{ $quizElement->input_name }}" class="control-label">{!! $quizElement->label !!}</label>
    {!! Form::select($quizElement->input_name, [null => 'Choose an Answer'] + $quizElement->options->lists('label', 'value')->toArray(),   Input::old($quizElement->input_name), ['class' => 'form-control']) !!}

</div>
