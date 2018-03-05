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
        @foreach($activities as $activity)
               @include("profiles.activities.{$activity->type}")
        @endforeach
{{--        {{$threads->links()}}--}}
    </div>

@endsection
