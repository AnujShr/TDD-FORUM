@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                {{$profileUser->name}}
                <small>Since {{$profileUser->created_at->diffForHumans()}}</small>
            </h1>
        </div>
    </div>
    <br>
    <div class="container">
        @foreach($threads as $thread)
            <div class="card">
                <a href="{{$thread->path()}}">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                 <strong> {{$thread->title}}</strong>
                              </span>
                            <span class=>{{$thread->created_at->diffForHumans()}}</span>
                        </div>
                    </div>
                </a>
                <div class="card-body">
                    <div class="body">{{$thread->body}}</div>
                </div>
            </div>
            <br>
        @endforeach
        {{$threads->links()}}
    </div>

@endsection
