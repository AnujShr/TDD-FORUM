<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications;

class Thread extends Model
{
    use RecordActivity;
    protected $guarded = [];
    protected $with = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope('replyCount', function ($builder) {
//            $builder->withCount('replies');
//        });
        static::deleting(function ($thread) {
            $thread->replies()->delete();
        });

    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function scopeFilter($query, $filters)
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
        $reply = $this->replies()->create($reply);

        $this->subscriptions->where('user_id', '!=', $reply->user_id)->each->notify($reply);
        return $reply;
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create(['user_id' => $userId ?: auth()->id()]);

        return $this;
    }

    public function subscriptions()
    {

        return $this->hasMany(ThreadSubscription::class);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()->where('user_id', $userId ?: auth()->id())->delete();
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }

}
