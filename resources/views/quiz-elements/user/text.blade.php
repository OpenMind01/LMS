<div class="form-group pad-ver">
    <label for="{{ $quizElement->input_name }}" class="control-label">{!! $quizElement->label !!}</label>
    {!! Form::text($quizElement->input_name,   Input::old($quizElement->input_name), ['class' => 'form-control', 'placeholder' => 'Answer here.']) !!}
</div>
