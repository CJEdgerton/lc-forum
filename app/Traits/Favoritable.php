<?php

namespace App\Traits;

use App\Favorite;

trait Favoritable {

	public function favorites()
	{
		return $this->morphMany(Favorite::class, 'favorited');
	}

	public function isFavoritedByCurrentUser()
	{
		return $this->favorites->where('user_id', auth()->id())->count();
	}

	public function favorite()
	{
		$attributes = ['user_id' => auth()->id()];
		if( ! $this->favorites()->where($attributes)->exists() )
			return $this->favorites()->create($attributes);
	}
	
	public function unfavorite($user_id)
	{
		$attributes = ['user_id' => $user_id];
		$this->favorites()->where($attributes)->delete();
	}

	public function getIsFavoritedByCurrentUserAttribute()
	{
		return $this->isFavoritedByCurrentUser();
	}

	public function getFavoritesCountAttribute()
	{
		return $this->favorites->count();
	}
	
}