@extends('layouts.app')

@section('content')
    {{--Thread Section--}}
    <thread-view :initial-replies-count="{{$thread->replies_count}}"inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{route('profile',$thread->creator)}}">
                                        {{$thread->creator->name}}
                                    </a> posted:<strong> {{$thread->title}}</strong>
                                </h4>
                                @can('update',$thread)
                                    <form action="{{$thread->path()}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-primary btn-xs">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="body">{{$thread->body}}</div>
                        </div>
                    </div>
                    <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

                    @if(auth()->check())
                        <br>
                        <form method="POST" action="{{$thread->path() . '/replies'}}">
                            {{csrf_field()}}
                            <div class="form-group">
                            <textarea name="body" id="body" class="form-control" rows="10"
                                      placeholder="Has Something to Say?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-dark btn-lg btn-block">REPLY</button>
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
                                has <span v-text="repliesCount"></span> {{str_plural('comment',$thread->favorite_count)}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>


@endsection
