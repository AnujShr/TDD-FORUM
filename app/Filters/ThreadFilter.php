<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilter extends Filters
{

    protected $filters = ['by'];
    /**
     * Filter the query by given username
     * @param $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

}