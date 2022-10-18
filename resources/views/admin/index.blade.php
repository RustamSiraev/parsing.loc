@extends('layouts.app', ['title' => 'Новости'])

@section('content')
    <div class="page-title">
        <h1>Новости</h1>
    </div>
    <div class="">
        <div class="row">
            @foreach($news as $item)
                <div class="col-lg-12">
                    <div class="card mb-2 border-primary">
                        <div class="card-header d-flex" >
                            <strong>{{ $item->title }}</strong>
                            <div style="margin-left: auto">{{ Date::parse($item->created_at)->format('j.m.Y') }}</div>
                        </div>
                        <div class="card-body">
                            {{ $item->body }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="paginator">
        {{ $news->links() }}
    </div>
@endsection
