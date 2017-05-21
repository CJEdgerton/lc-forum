<?php

namespace App\Traits;

trait RecordsActivity
{
	function recordActivity($event)
	{
			\App\Activity::create([
				'user_id'      => auth()->id(),
				'type'         => $this->getActivityType($event),
				'subject_id'   => $this->id,
				'subject_type' => get_class($this),
			]);
	}

	function getActivityType($event)
	{
		return $event . '_' . strtolower(class_basename($this));
	}
}