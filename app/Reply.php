<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	use Traits\RecordsActivity, Traits\Favoritable;
	
	protected $guarded = [];

	protected $with = ['owner', 'favorites'];

	// Whenever Reply is cast to json or an array, append these properties	
	protected $appends = ['favoritesCount', 'isFavoritedByCurrentUser'];

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
}
