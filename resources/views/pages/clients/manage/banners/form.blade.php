{!! Form::hidden('client_id', $client->id) !!}
{!! Form::hidden('created_by', Auth::id()) !!}

<div class="form-group">
    {!! Form::label('style', 'Style', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('style', Pi\Banners\Banner::$styles, Input::old('style'), ['class' => 'form-control', 'placeholder' => 'Select a Style']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('icon', 'Icon', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::hidden('icon', null, ['id' => 'icon-input']) !!}
        <div class="btn-group">
            <button type="button" class="btn btn-primary iconpicker-component"><i class="fa fa-fw fa-check"></i></button>
            <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fa-check" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu"></div>
        </div>
    </div>
</div>


<div class="form-group">
    {!! Form::label('title', 'Title', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10 ">

        {!! Form::text('title', Input::old('title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('body', 'Body', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::textarea('body', Input::old('body'), ['class' => 'form-control', 'placeholder' => 'Body (500 characters max)']) !!}
    </div>
</div>

@section('inline-scripts')
    @parent
    <script src="/assets/plugins/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.js"></script>
    <link rel="stylesheet" href="/assets/plugins/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css">
    <script>
        (function ($) {
//            $('.action-destroy').on('click', function() {
//                $.iconpicker.batch('.icp.iconpicker-element', 'destroy');
//            });
//            // Live binding of buttons
//            $(document).on('click', '.action-placement', function(e) {
//                $('.action-placement').removeClass('active');
//                $(this).addClass('active');
//                $('.icp-opts').data('iconpicker').updatePlacement($(this).text());
//                e.preventDefault();
//                return false;
//            });

                $('.dropdown-toggle').dropdown();

                $('.icp-dd').iconpicker({
                    hideOnSelect: true,
                    icons: [
                        'fa-android', 'fa-heart', 'fa-check', 'fa-calendar', 'fa-bolt', 'fa-compass', 'fa-book',
                            'fa-quote-right', 'fa-support', 'fa-warning', 'fa-gear', 'fa-bar-chart'
                    ]
                });

                $('.icp').on('iconpickerSelected', function(e) {
                    $("#icon-input").val(e.iconpickerInstance.iconpickerValue)
                });

        })(jQuery);
    </script>
@stop
