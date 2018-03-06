<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject(){
        return $this->morphTo();
    }

   public static function feed($user){
          return $user->activity()->take(50)->with('subject')->latest()->get()->groupBy(function ($activity) {
           return $activity->created_at->format('Y-m-d');
       });
   }
}
