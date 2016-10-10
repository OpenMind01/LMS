@extends('layouts.default')

@section('content')
    {{--Page Title--}}
    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
    <div id="page-title">
        <h1 class="page-header text-overflow">Creating a Discussion Board</h1>
    </div>
    {{--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--}}
    {{--End page title--}}

    {{--Page content--}}
    {{--===================================================--}}
    <div id="page-content">

        {{-- Discussion Boards --}}
        {{--===================================================--}}
        <div class="panel panel-default panel-left">
            <form class="form-horizontal" action="{{ route($routePrefix . '.store', $routeParameters) }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="title" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea id="description" name="description" rows="10" cols="100" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Create</button>
                    </div>
                </div>
            </form>
        </div>
        {{--===================================================--}}
        {{-- End of discussion board --}}


    </div>
    {{--===================================================--}}
    {{--End page content--}}
@stop
