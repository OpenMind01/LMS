@extends('layouts.auth')

@section('content')
    <style>
        .cls-content .cls-content-sm {
            border: thick solid #C99865;
        }
    </style>
    <div class="cls-content">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <p class="pad-btm">Sign In to your account</p>
                {!! Form::open(['route' => 'auth.doLogin']) !!}
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                            {!! Form::text('email', Input::old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 text-left checkbox">
                            <label class="form-checkbox form-icon">
                                <input name="remember" type="checkbox"> Remember me
                            </label>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group text-right">
                                <button class="btn btn-success text-uppercase" type="submit">Sign In</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="pad-ver">
            {{--<a href="pages-password-reminder.html" class="btn-link mar-rgt">Forgot password ?</a>--}}
            {{--<a href="pages-register.html" class="btn-link mar-lft">Create a new account</a>--}}
        </div>
    </div>
@stop