@forelse($threads as $thread)
    <div class="card">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="{{$thread->path()}}">
                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>

                    </h4>
                    <h5>Posted by:<a href="{{route('profile',$thread->creator) }}">{{$thread->creator->name}} </a></h5>
                </div>

                <a href="{{$thread->path()}}">
                    <strong>{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</strong>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="body">{{$thread->body}}</div>
        </div>
    </div>
    <br>
@empty
    <div class="row justify-content-center">
        <STRONG>NO THREADS AVAILABLE ASSOCIATED WITH THE CHANNEL!!!
            BE THE FIRST ONE TO MAKE ONE</STRONG>
    </div>
@endforelse