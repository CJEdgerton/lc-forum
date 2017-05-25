<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	use Traits\RecordsActivity;
	
	protected $guarded = [];

	protected $with = ['owner', 'favorites'];

	public function owner() 
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function thread()
	{
		return $this->belongsTo('App\Thread');
	}

	public function path()
	{
		return $this->thread->path() . '#reply-' . $this->id;
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

	public function isFavorited()
	{
		return $this->favorites->where('user_id', auth()->id())->count();
	}

	public function getFavoritesCountAttribute()
	{
		return $this->favorites->count();
	}
}
