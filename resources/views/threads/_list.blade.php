@forelse($threads as $thread)
    <div class="card">
        <h4 class="card-header">
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
                    <h5>Posted by:<a href="{{route('profile',$thread->creator) }}" class="card-link">{{$thread->creator->name}} </a>
                    </h5>
                </div>
                <a href="{{$thread->path()}}" class="card-link">
                    <strong>{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</strong>
                </a>
            </div>
        </h4>

        <div class="card-body">
            <p class="card-text">{{$thread->body}}</p>
        </div>
    </div>
    <div class="card-footer">
        Visits: {{$thread->visits()}}
    </div>
    <br>
@empty
    <div class="row justify-content-center">
        <STRONG>NO THREADS AVAILABLE ASSOCIATED WITH THE CHANNEL!!!
            BE THE FIRST ONE TO MAKE ONE</STRONG>
    </div>
@endforelse