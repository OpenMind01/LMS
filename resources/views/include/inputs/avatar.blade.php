<div class="form-group" id="{{$name or ''}}-form-group">
    <div class="col-sm-2 text-right">
        @if (!empty($user->avatar->url('thumb')))
    	    <span class="text-center" style="display: inline-block;">
    		    <img class="img-circle img-md" src="{{ $user->avatar->url('thumb') }}" />
    		    <a href="#" class="text-danger text-center pad-ver" style="display:block;">Remove Avatar</a>
    	    </span>
        @endif
    </div>
    <div class="col-sm-10">
    	<p class="pad-top">Use the input below to upload a new image to use as your avatar.</p>
		{!! Form::file($name, Input::old($name, isset($default) ? $default : null), [
		    'class' => 'form-control',
		    'id' => $name,
		    'placeholder' => isset($placeholder) ? $placeholder : (isset($caption) ? $caption : '')])
		    !!}

@if(isset($hint))
    <span class="small">{{$hint}}</span>
@endif

</div>
</div>