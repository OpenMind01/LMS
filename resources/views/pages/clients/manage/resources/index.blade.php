@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.resources.create', ['clientSlug' => $client->slug]) }}" class="btn btn-success">Create Resource</a>
            </div>
            <h3 class="panel-title">Resources for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Preview</th>
                    <th class="col-sm-3">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($resources as $resource)
                    <tr>
                        <td>{{ $resource->name }}</td>
                        <td>{{ $resource->type_name }}</td>
                        <td>
                            <a href="{{ $resource->url }}" class="btn btn-info btn-sm" target="_preview">
                                <i class="fa fa-search"></i>
                                Preview
                            </a>
                        </td>
                        <td>

                            {!! Form::open(['route' => ['clients.manage.resources.destroy', $client->slug, $resource->id], 'method' => 'delete', 'class' => 'form form-inline pull-right']) !!}
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            {!! Form::close() !!}
                            <a href="{{ route('clients.manage.resources.edit', [$client->slug, $resource->id]) }}" class="btn btn-sm btn-info pull-right">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop