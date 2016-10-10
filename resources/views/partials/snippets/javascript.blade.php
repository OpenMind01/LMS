<script>
    if ( ! window.Pi ) window.Pi = {};
    window.Pi.snippets = {!! $availableSnippets->toJson() !!};
    window.Pi._token = '{{ csrf_token() }}';
    window.Pi.userId = '{{ Auth::id() }}';

    (function($) {
        $.ajaxSetup({
            data: {
                _token: window.Pi._token
            }
        });
    })(jQuery);

    @if(!App::environment('production'))
    console.log(window.Pi);
    @endif



</script>