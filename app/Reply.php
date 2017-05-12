<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	protected $guarded = [];

	public function owner() 
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function thread()
	{
		return $this->belongsTo('App\Thread');
	}

	public function favorites()
	{
		return $this->morphMany(Favorite::class, 'favorited');
	}

	public function favorite($user_id)
	{
		$attributes = ['user_id' => $user_id];
		if( ! $this->favorites()->where($attributes)->exists() )
			return $this->favorites()->create($attributes);
	}
}
