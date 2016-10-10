@extends('layouts.default')

@section('content')
<div class="row">
<div class="col-sm-8"> 
    {!! Form::model($client->theme, ['route' => [$routePrefix . 'store', $client->slug], 'files' => true, 'class' => 'form form-horizontal']) !!}

    @include('include.formpanel.begin', ['title' => $client->name . ': Theme'])

    @include('include.inputs.begin', ['name' => 'font', 'caption' => 'Font'])
        <select name="font" id="font" class="form-control">
            @foreach($fonts as $font => $caption)
                <option value="{{$font}}" style="font-family: {{$font}}, sans-serif;"@if(Input::old('font', $client->theme->font) == $font) selected @endif >{{$caption}}</option>
            @endforeach
        </select>
    @include('include.inputs.end')

    @include('include.inputs.begin', ['name' => 'style_name', 'caption' => 'Theme'])
    {!! Form::select('style_name', $styleNames, Input::old('style_name', $client->theme->style_name), ['id' => 'templateSwitcher', 'class' => 'form-control']) !!}
    @include('include.inputs.end')

    @include('include.inputs.begin', ['name' => 'style_type', 'caption' => 'Theme Variant'])

    @foreach($styleTypes as $styleType => $caption)
        <div class="radio">
            <label class="form-radio form-normal form-text">
                {!! Form::radio('style_type', $styleType, Input::old('style_type', $client->theme->style_type) == $styleType) !!}
                {{$caption}}
            </label>
        </div>
    @endforeach

    @include('include.inputs.end')

    @include('include.inputs.begin', ['name' => 'indi-color', 'caption' => 'Individual Colors'])
    {!! Form::input('color', 'color_primary', '#5FA2DD', ['id' => 'color_primary', 'class' => 'add-tooltip', 'data-original-title' => 'Primary Color', 'data-target' => '#interface-example']) !!}
    {!! Form::input('color', 'color_success', '#9CC96B', ['id' => 'color_success', 'class' => 'add-tooltip', 'data-original-title' => 'Success Color', 'data-target' => '#interface-example']) !!}
    {!! Form::input('color', 'color_info', '#4EBCDA', ['id' => 'color_info', 'class' => 'add-tooltip', 'data-original-title' => 'Information Color', 'data-target' => '#interface-example']) !!}
    {!! Form::input('color', 'color_warning', '#EBAA4B', ['id' => 'color_warning', 'class' => 'add-tooltip', 'data-original-title' => 'Warning Color', 'data-target' => '#interface-example']) !!}
    {!! Form::input('color', 'color_danger', '#F76C51', ['id' => 'color_danger', 'class' => 'add-tooltip', 'data-original-title' => 'Danger Color', 'data-target' => '#interface-example']) !!}
    {!! Form::input('color', 'color_dark', '#3B4146', ['id' => 'color_dark', 'class' => 'add-tooltip', 'data-original-title' => 'Dark Color', 'data-target' => '#interface-example']) !!}
    {!! Form::input('color', 'color_mint', '#50C7A7', ['id' => 'color_mint', 'class' => 'add-tooltip', 'data-original-title' => 'Mint Color', 'data-target' => '#interface-example']) !!}
    {!! Form::input('color', 'color_purple', '#986291', ['id' => 'color_purple', 'class' => 'add-tooltip', 'data-original-title' => 'Purple Color', 'data-target' => '#interface-example']) !!}
    {!! Form::input('color', 'color_pink', '#E17CA7', ['id' => 'color_pink', 'class' => 'add-tooltip', 'data-original-title' => 'Pink Color', 'data-target' => '#interface-example']) !!}
    @include('include.inputs.end')

    @include('include.inputs.begin', ['name' => 'logo', 'caption' => 'Logo'])
    {!! Form::file('logo', ['id' => 'logo', 'class' => 'form-control']) !!}
    @if($client->theme->hasLogo())
        <br/>
        <img class="edit-theme-img" src="{{$client->theme->logo->url('medium')}}"/>
    @endif
    @include('include.inputs.end')

    @include('include.inputs.begin', ['name' => 'background', 'caption' => 'Background image'])
    {!! Form::file('background', ['id' => 'background', 'class' => 'form-control']) !!}
    {!! Form::hidden('background_offset', 0, ['id' => 'background_offset']) !!}
    @if($client->theme->hasBackground())
        <br/>
        <div class="hero-image-edit hero-responsive">
            <div class="hero-image-edit-wrapper">
                <img class="edit-theme-img" id="hero-image" src="{{$client->theme->background->url()}}" />
            </div>
        </div>
    @endif
    @include('include.inputs.end')

    @include('include.formpanel.buttons')

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    <a href="{{route('clients.show', $client->slug)}}" class="btn">Cancel</a>

    @include('include.formpanel.end')

    {!! Form::close() !!}
</div>
<div class="col-sm-4">
    <div id="interface-example">
        <h4>Interface styling for: <b><span id="color-name">success</span></b></h4>

        <div class="panel panel-success panel-colorful">
            <div class="pad-all media">
                <div class="media-left">
                    <span class="icon-wrap icon-wrap-xs">
                        <i class="fa fa-users fa-2x"></i>
                    </span>
                </div>
                <div class="media-body">
                    <p class="h3 text-thin media-heading">314,675</p>
                    <small class="text-uppercase">Demo colorful background</small>
                </div>
            </div>
            <div class="progress progress-xs progress-dark-base mar-no">
                <div style="width: 30%" class="progress-bar progress-bar-light" aria-valuemax="100" aria-valuemin="0" aria-valuenow="30" role="progressbar"></div>
            </div>
            <div class="pad-all text-right">
                <small><span class="text-semibold">30%</span> Demo light font</small>
            </div>
        </div>

        <div class="panel media pad-all">
            <div class="media-left">
                <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
                <i class="fa fa-user fa-2x"></i>
                </span>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-thin">241</p>
                <p class="text-muted mar-no">Demo icon with background</p>
            </div>
        </div>

        <div class="panel text-center">
            <div class="panel-body">
                <img alt="Avatar" class="img-md img-circle img-border mar-btm" src="/assets/img/av6.png">
                <h4 class="mar-no text-success">Brenda Fuller</h4>
                <p class="text-success">Project manager</p>
            </div>
            <div class="pad-hor">
                <p class="text-muted text-success">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                </p>
                <div class="pad-btm">
                    <button class="btn btn-success disabled">Button Disabled</button>
                    <button class="btn btn-success">Button Normal</button>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

@stop

@section('inline-scripts')
    {{--<script src="/assets/js/p4.js"></script>--}}
@stop