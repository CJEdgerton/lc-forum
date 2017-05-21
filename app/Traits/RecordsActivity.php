<?php

namespace App\Traits;

trait RecordsActivity
{

	protected static function bootRecordsActivity()
	{
		if( auth()->guest() ) return;
		
		foreach( static::getActivitiesToRecord() as $event) {
			static::$event(function ($model) use($event) {
				$model->recordActivity($event);
			});
		}
	}

	protected static function getActivitiesToRecord()
	{
		return ['created'];
	}

	function recordActivity($event)
	{
		$this->activity()->create([
			'user_id'      => auth()->id(),
			'type'         => $this->getActivityType($event),
		]);
	}

	public function activity()
	{
		return $this->morphMany('\App\Activity', 'subject');
	}

	function getActivityType($event)
	{
		$type = strtolower(class_basename($this));
		return "{$event}_{$type}";
	}
}