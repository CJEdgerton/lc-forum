@component('profiles.activities.activity')

	@slot('heading')
		<span class="glyphicon glyphicon-bullhorn"></span>&nbsp; 
		{{ $profileUser->name }} 
		published:
		<a href="{{ $activity->subject->path() }}">
			{{ $activity->subject->title }}
		</a>
	@endslot

	@slot('time')
		{{ $activity->subject->created_at->diffForHumans() }}
	@endslot

	@slot('body')
		{{ $activity->subject->body }}
	@endslot

@endcomponent
