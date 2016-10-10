<div class="panel draggable yes-drop">
    <div class="panel-heading dragzone">
        @if(isset($buttons))
            <div class="panel-control">
                @foreach($buttons as $button)
                    <a href="{{ $button['url'] }}" class="btn btn-{{$button['class']}}">{{$button['title']}}</a>
                @endforeach
            </div>
        @endif
        <h3 class="panel-title">{{$title}}</h3>
    </div>
    <div class="panel-body form-body">