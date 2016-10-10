<div class="form-group" id="{{$name or ''}}-form-group">
    <label class="col-sm-2 control-label" for="{{$name or ''}}">{{$caption or ''}}
        @if(isset($required) && $required)
            <span class="red">*</span>
        @endif
    </label>
    <div class="col-sm-10">