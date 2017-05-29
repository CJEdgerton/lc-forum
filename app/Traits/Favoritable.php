<?php

namespace App\Traits;

use App\Favorite;

trait Favoritable {

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

	public function isFavoritedByCurrentUser()
	{
		return $this->favorites->where('user_id', auth()->id())->count();
	}

	public function getFavoritesCountAttribute()
	{
		return $this->favorites->count();
	}
	
}