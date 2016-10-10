@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">

            <h3 class="panel-title">Edit Banner</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($banner, ['route' => ['clients.manage.banners.update', $client->slug, $banner->id], 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

            @include('pages.clients.manage.banners.form')

            {!! Form::submit('Update Banners', ['class' => 'btn btn-info pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">

                    <h3 class="panel-title">Users who have viewed this banner</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Dismissed</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($banner->dismissedUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->pivot->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop