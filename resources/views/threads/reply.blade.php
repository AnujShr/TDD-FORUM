<reply :attributes="{{$reply}}" inline-template v-cloak>
    <div id="reply-{{$reply->id}}" class="card">
        <div class="card-header">
            <div class="level">
                <h6 class="flex">
                    <a href="{{route('profile',$reply->owner)}}">
                        {{$reply->owner->name}}
                    </a>
                    said {{$reply->created_at->diffForHumans()}}
                </h6>
                @if(Auth::check())
                    <div>
                        <favorite :reply="{{$reply}}"></favorite>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="body">
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm" @click="update">Update</button>
                    <button class="btn btn-outline-danger btn-sm" @click="editing = false">Cancel</button>
                </div>
                <div v-else v-text="body">
                    {{$reply->body}}
                </div>
            </div>
            @can('update',$reply)
                <div class="card-footer level">
                    <button class="btn btn-outline-info btn-xs mr-1" @click="editing = true">Edit</button>
                    <button class="btn btn-outline-danger btn-xs mr-1" @click="destroy">DELETE</button>
                </div>
            @endcan
        </div>
    </div>
</reply>