@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-control">
                <a href="{{ route('clients.manage.articles.create', ['clientSlug' => $client->slug]) }}" class="btn btn-success">Create Article</a>
            </div>
            <h3 class="panel-title">Articles for {{ $client->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th># of Articles</th>
                    <th class="col-sm-1">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>
                            {{ $article->name }}
                            <div style="color: #aaa">Slug: {{ $article->slug }}</div>
                        </td>
                        <td>{{ $article->articles->count() }}</td>
                        <td>
                            <a href="{{ route('clients.manage.articles.edit', ['clientSlug' => $client->slug, 'articleSlug' => $article->slug]) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop