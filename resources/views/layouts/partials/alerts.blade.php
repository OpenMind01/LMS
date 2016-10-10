{{-- Show Messages --}}
@if($errors->count())
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-block alert-danger">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>

                @foreach($errors->getMessages() as $errors)
                    @foreach($errors as $error)
                        <div>
                            <!-- <i class="ace-icon fa fa-warning red"></i> -->
                            {!! nl2br(e($error)) !!}
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endif
@if(Session::get('error'))

    @if(is_array(Session::get('error')))
        <div class='row'>
            <div class="col-sm-12">
                <div class="alert alert-block alert-danger">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    @foreach(Session::get('error') as $error)
                        <div>
                            <!-- <i class="ace-icon fa fa-warning-sign red"></i> -->
                            {!! nl2br(e($error)) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class='row'>
            <div class="col-sm-12">
                <div class="alert alert-block alert-danger">

                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>

                    <!-- <i class="ace-icon fa fa-warning-sign red"></i> -->

                    {!! nl2br(e(Session::get('error'))) !!}

                </div>
            </div>
        </div>
    @endif
@endif
@if(Session::get('message'))
    <div class='row'>
        <div class="col-sm-12">
            <div class="alert alert-block alert-{{ Session::get('message')[0] }}">

                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>

                <!--

                @if(Session::get('message')[0] == 'success')
                    <i class="ace-icon fa fa-check green"></i>
                @endif

                @if(Session::get('message')[0] == 'warning')
                    <i class="ace-icon fa fa-exclamation-sign orange"></i>
                @endif

                @if(Session::get('message')[0] == 'info')
                    <i class="ace-icon fa fa-bullhorn blue bigger-130"></i>
                @endif

                @if(Session::get('message')[0] == 'error')
                    <i class="ace-icon fa fa-warning-sign red"></i>
                @endif

                -->

                {!! nl2br(e(Session::get('message')[1])) !!}

            </div>
        </div>

    </div>
@endif
{{-- End Messages --}}