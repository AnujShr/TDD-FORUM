@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                {{$profileUser->name}}
            </h1>
        </div>
    </div>
    <br>
    <div class="container">
        @foreach($activities as $date=> $activity)
            <h3 class="card-header">{{$date}}</h3>
            @foreach($activity as $record)
                @if(view()->exists("profiles.activities.{$record->type}"))
                    {{--Overide the variable $activity inside the partial by $record--}}
                    @include("profiles.activities.{$record->type}",['activity' => $record])
                @endif
            @endforeach
        @endforeach
        <br>
    </div>

@endsection
