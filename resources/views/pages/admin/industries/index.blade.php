@extends('layouts.default')

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('admin.industries.create') }}" class="btn btn-success">Create Industry</a>
            </div>
            <h3 class="panel-title">Industries</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Open</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($industries as $industry)
                    <tr>
                        <td>{{ $industry->title }}</td>
                        <td>{{ $industry->ready ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.industries.edit', ['id' => $industry->id]) }}" class="btn btn-sm btn-info">
                                Edit
                            </a>

                            <a href="{{ action('Admin\IndustriesController@getClone', $industry->id) }}" class="btn btn-sm btn-success">
                                Clone
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $industries->render() !!}
        </div>
    </div>


@stop