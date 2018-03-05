<div class="card">
    <a href="{{$activity->subject->thread->path()}}">
        <div class="card-header">
            <div class="level">
            <span class="flex">
                <strong> {{$profileUser->name}} replied to {{$activity->subject->thread->title}}</strong>
            </span>
            </div>
        </div>
    </a>
    <div class="card-body">
        <div class="body">
            {{$activity->subject->body}}
        </div>
    </div>
</div>
<br>