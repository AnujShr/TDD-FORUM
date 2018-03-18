@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <avatar-form :user="{{$profileUser}}"></avatar-form>
        </div>
    </div>
    <br>

    <div class="container">
        @forelse($activities as $date=> $activity)
            <h3 class="card-header">{{$date}}</h3>
            @foreach($activity as $record)
                @if(view()->exists("profiles.activities.{$record->type}"))
                    {{--Overide the variable $activity inside the partial by $record--}}
                    @include("profiles.activities.{$record->type}",['activity' => $record])
                @endif
            @endforeach

        @empty
            <P><strong>No activities for this User Yet!!!</strong></P>
        @endforelse
        <br>
    </div>

@endsection
