@extends('layouts.app')

@section('content')
    <div class="container">
        {{--Thread Section--}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$thread->title}}</div>
                    <div class="card-body">
                        <a href="#">{{$thread->creator->name}}</a> posted
                        <h4>{{$thread->title}}</h4>
                        <div class="body">{{$thread->body}}</div>
                    </div>

                </div>
                {{--Reply Section--}}
                @php
                    $replies = $thread->replies()->paginate(1);
                @endphp
                @foreach($replies as $reply)
                    <br>
                    @include('threads.reply')
                @endforeach
                {{$replies->links()}}
                @if(auth()->check())
                    <br>
                    <form method="POST" action="{{$thread->path() . '/replies'}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" rows="10"
                                      placeholder="Has Something to Say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">REPLY</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">SignIn</a> to reply.</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This Thread was publised {{$thread->created_at->diffForHumans()}}
                            by <a href="">{{$thread->creator->name}}</a>
                            and currently
                            has {{$thread->replies_count}} {{str_plural('comment',$thread->replies_count)}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
