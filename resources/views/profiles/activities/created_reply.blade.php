@component('profiles.activities.activity')
    @slot('heading')
        {{$profileUser->name}} replited to <a href="{{$activity->subject->thread->path()}}"> {{$activity->subject->thread->title}}
    @endslot
    @slot('body')
        {{$activity->subject->body}}
    @endslot
@endcomponent