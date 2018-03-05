<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show',[
            'profileUser' => $user,
            'activities' => $this->getActivity($user)
        ]);
    }

    /**
     * @param User $user
     * @return mixed
     */
    protected function getActivity(User $user)
    {
        return $user->activity()->take(50)->with('subject')->latest()->get()->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
