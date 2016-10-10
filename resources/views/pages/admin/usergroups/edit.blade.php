@extends('layouts.default')

@section('content')
    {!! Form::model($usergroup, ['route' => ['admin.usergroups.update'
        , $usergroup->id]
        , 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => 'Edit User group'])

    @include('pages.admin.usergroups.form')

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <label class="form-checkbox form-normal form-primary form-text">
                {!! Form::checkbox('ready', 1, Input::old('ready', false)) !!} Open for clients
            </label>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('industries', 'Industries', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <select multiple="multiple" name="industries[]" id="industries" class="form-control">
                @foreach($industriesList as $industry)
                    <option value="{{$industry->id}}" @if(isset($currentIndustries[$industry->id]))selected="selected"@endif>{{$industry->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <hr>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="#" id="editor_modules_select_all" class="btn btn-success">Select all</a>

            <a href="#" id="editor_modules_deselect_all" class="btn btn-danger">Deselect all</a>
        </div>
    </div>

    @foreach($possibleModules as $possibleModule)
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <label class="form-checkbox form-normal form-primary form-text">
                    {!! Form::checkbox('modules[' . $possibleModule->id . ']',
                    1,
                    Input::old('modules[' . $possibleModule->id . ']', isset($currentModulesList[$possibleModule->id])),
                    ['class' => 'module_checkbox module_' . $possibleModule->id, 'data-id' => $possibleModule->id]) !!}
                    {{$possibleModule->name}}
                </label>

                <div class="editor_module_articles">
                    @foreach($possibleModule->articles as $article)
                        <div>
                            <label class="form-checkbox form-normal form-primary form-text">
                                {!! Form::checkbox('articles[' . $article->id . ']',
                                1,
                                Input::old('articles[' . $article->id . ']', isset($currentArticlesList[$article->id])),
                                ['class' => 'article_checkbox checkbox_module_' . $possibleModule->id, 'data-module' => $possibleModule->id]) !!}
                                {{$article->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    @include('include.formpanel.buttons')

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('admin.usergroups.index')}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
@stop

@section('inline-styles')
    <link rel="stylesheet" href="/assets/plugins/chosen/chosen.css"/>
@stop

@section('inline-scripts')
    <script src="/assets/plugins/chosen/chosen.jquery.min.js"></script>
    <script>
        $(function () {
            $('#industries').chosen({
                placeholder_text_multiple: 'Select industries'
            });

            $('.module_checkbox').click(function () {

                var id = $(this).data('id');
                $('.checkbox_module_' + id).prop('checked', this.checked)
                    .trigger('change');
            });

            $('.article_checkbox').click(function () {

                var id = $(this).data('module');

                if (this.checked) {
                    $('.module_' + id).prop('checked', true)
                        .trigger('change');
                } else {
                    if ($('.checkbox_module_' + id + ':checked').size() == 0) {
                        $('.module_' + id).prop('checked', false)
                            .trigger('change');
                    }
                }
            });

            $('#editor_modules_select_all').click(function () {
                $('.module_checkbox').prop('checked', true).trigger('change');
                $('.article_checkbox').prop('checked', true).trigger('change');

                return false;
            });

            $('#editor_modules_deselect_all').click(function () {
                $('.module_checkbox').prop('checked', false).trigger('change');
                $('.article_checkbox').prop('checked', false).trigger('change');

                return false;
            });
        });
    </script>
@stop