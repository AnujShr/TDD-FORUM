<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
//        return '/threads/' . $this->channel->slug.'/'.$this->id;
    }

    public function scopeFilter($query,$filters)
    {
        return $filters->apply($query);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }


}
