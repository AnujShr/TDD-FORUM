<div class="card">
    <a href="{{$activity->subject->path()}}">
    <div class="card-header">
            <div class="level">
            <span class="flex">
                <strong> {{$profileUser->name}} created {{$activity->subject->title}}</strong>
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