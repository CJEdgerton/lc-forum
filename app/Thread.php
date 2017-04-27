<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $guarded = [];
	public function path()
	{
		return "/threads/{$this->channel->slug}/{$this->id}";
	}

	public function channel()
	{
		return $this->belongsTo('App\Channel');
	}

	public function creator()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function replies()
	{
		return $this->hasMany('App\Reply');
	}

	public function addReply($reply)
	{
		$this->replies()->create($reply);
	}

	public function scopeFilter($query, $filters)
	{
		return $filters->apply($query);
	}
}
