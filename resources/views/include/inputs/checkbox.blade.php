<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <label class="form-checkbox form-normal form-primary form-text">
            {!! Form::checkbox($name, 1, Input::old($name)) !!} {{$caption}}
        </label>
        @if(isset($hint))
            <br/>
            <span class="small">{{$hint}}</span>
        @endif
    </div>
</div>