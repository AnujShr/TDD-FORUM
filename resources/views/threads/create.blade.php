@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Threads</div>

                    <div class="card-body">
                        <form method="POST" action="/threads">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="channel_id">Choose A Channel</label>
                                <select required id="channel_id" name="channel_id" class="form-control">
                                    <option value="">Choose One</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? ' selected': ''}}>{{$channel->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input name="title" id="title" type="text" class="form-control"
                                       value="{{old('title')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Content</label>
                                <textarea required id="body" name="body" class="form-control">{{old('body')}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publish</button>
                            <br>
                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
