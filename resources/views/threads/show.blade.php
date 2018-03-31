@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection
@section('content')
    {{--Thread Section--}}
    <thread-view :thread="{{$thread}}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <img src="{{$thread->creator->avatar_path}}" alt="" width="50"
                                     height="50" class="mr-3">
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
                    <replies @added = "repliesCount ++ " @removed="repliesCount--"></replies>


                </div>
                <div class="col-md-4">
                    <div class="card border-dark">
                        <div class="card-body">
                            <p>
                                This Thread was publised {{$thread->created_at->diffForHumans()}}
                                by <a href="">{{$thread->creator->name}}</a>
                                and currently
                                has <span
                                        v-text="repliesCount"></span> {{str_plural('comment',$thread->favorite_count)}}
                            </p>

                            <p>
                                <subscribe-button :active="{{json_encode($thread->isSubscribedTo)}}"
                                                  v-if="signedIn"></subscribe-button>
                                <button class="btn btn-default" v-if="authorize('isAdmin')" @click="togglelock"
                                        v-text="locked ? 'Unlock':  'Lock'">
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>


@endsection
