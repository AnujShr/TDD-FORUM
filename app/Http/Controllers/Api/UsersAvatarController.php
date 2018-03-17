<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersAvatarController extends Controller
{
    /**
     * UsersAvatarController constructor.
     */


    public function store()
    {
        request()->validate(['avatar' => ['required', 'image']]);
        auth()->user()->update(['avatar_path' => request()->file('avatar')->store('avatars', 'public')]);

        return back();
    }
}
