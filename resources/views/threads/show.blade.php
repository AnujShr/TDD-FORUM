@extends('layouts.app')

@section('content')
    <div class="container">
        {{--Thread Section--}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$thread->title}}</div>
                    <div class="card-body">
                        <a href="#">{{$thread->creator->name}}</a> posted
                        <h4>{{$thread->title}}</h4>
                        <div class="body">{{$thread->body}}</div>
                    </div>

                </div>
            </div>
        </div>
        {{--Reply Section--}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                    <br>
                @endforeach
            </div>
        </div>

        @if(auth()->check())

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="POST" action ="{{$thread->path() . '/replies'}}">
                        {{csrf_field()}}
                    <div class="form-group">
                      <textarea name="body" id="body" class="form-control" placeholder="Has Something to Say?"></textarea>
                    </div>
                        <button type="submit" class="btn btn-default">REPLY</button>
                    </form>
                </div>
            </div>
            @else
            <p class="text-center">Please <a href="{{ route('login') }}">SignIn</a> to reply.</p>
        @endif
    </div>
@endsection
