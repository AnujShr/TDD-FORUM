@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-success text-white card-header">
                    Threads
                </div>
                <br>

                @include('threads._list')
                {{$threads->render()}}
            </div>
            @if(count($trending))
                <div class="col md-4">
                    <div class="card">
                        <div class="card bg-primary text-white card-header">
                            Trending Threads
                        </div>
                        <div class="card-body">
                            <ul class="list-group ">
                                @foreach($trending as $thread)
                                    <li class="list-group-item">
                                        <a href="{{$thread->path}}">
                                            <div class="card-text">{{$thread->title}}</div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
@endsection
