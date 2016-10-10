<div class="form-group drag-drop-group">
    <div class="img-drop">
	   <img src="/assets/uploads/animal.png" class="img-question" height="250" />
       <div class="qv-block-area">
           <div class="qv-block" data-id="1" draggable="true"></div>
           <div class="qv-block" data-id="2" draggable="true"></div>
           <div class="qv-block" data-id="3" draggable="true"></div>
           <div class="qv-block" data-id="4" draggable="true"></div>
        </div>
    </div>
    <label for="{{ $quizElement->input_name }}" class="control-label dd-label">{!! $quizElement->label !!}</label>
        @foreach($quizElement->options as $index => $option)
            <div class="dragdrop">
                <label class="form-text drag-drop-label" draggable="true">
                    <p data-order="{{$option->value}}" name="{{$quizElement->input_name}}" class="dragdrop-order">
                        <span class="q-order">Q{{$index++}}</span> : <span class="q-des">{{ $option->label }}</span>
                    </p>
                </label>
            </div>
        @endforeach
</div>