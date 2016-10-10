@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.banners.create', ['clientSlug' => $client->slug]) }}" class="btn btn-success">Create Banner</a>
            </div>
            <h3 class="panel-title">Banners for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="col-sm-2">Created By</th>
                    <th class="col-sm-2">% Dismissed</th>
                    <th class="col-sm-7">Body</th>
                    <th class="col-sm-1">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banners as $banner)
                    <tr>
                        <td>
                            <div>{{ $banner->author->full_name }}</div>
                            <div style="color: #999; font-size: 90%;">{{ $banner->created_at->diffForHumans() }}</div>

                        </td>
                        <td>{{ $banner->seen_by_percent }}%</td>
                        <td>
                            <div class="alert alert-{{ $banner->style }}">
                                {{ Snippet::process($banner->body, $viewData) }}
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('clients.manage.banners.edit', ['clientSlug' => $client->slug, 'id' => $banner->id]) }}"
                               class="btn btn-sm btn-info">
                                Edit
                            </a>
                            {!! Form::open(['route' => ['clients.manage.banners.destroy', $client->slug, $banner->id], 'method' => 'DELETE', 'class' => 'form form-inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop