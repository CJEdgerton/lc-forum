<div id="reply-{{ $reply->id }}" class="panel panel-default">
    <div class="panel-heading">
		<div class="level">
			<h5 class="flex">
				<a href="{{ route('profile', $thread->creator) }}">
					{{ $reply->owner->name }}
				</a> said {{ $reply->created_at->diffForHumans() }} ...
			</h5>
			<div>
				{{-- Favorites --}}
				<form method="POST" action="/replies/{{$reply->id}}/favorites" class="pull-left">
					{{ csrf_field() }}
					<button type="submit" class="btn btn-default btn-sm" {{ $reply->isFavorited() ? 'disabled' : '' }}>
						<span class="glyphicon glyphicon-thumbs-up"></span> {{ $reply->favorites_count }} 
					</button>
				</form>

				{{-- Delete --}}

				<form action="/replies/{{ $reply->id }}" method="POST" class="pull-right" style="margin-left: 5px;">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button type="submit" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-trash text-danger"></span>
					</button>
				</form>
			</div>
		</div>
	</div>	

    <div class="panel-body">
        <p>{{ $reply->body }}</p>
    </div>

	@can('update', $reply )
		<div class="panel-footer">
		</div>
	@endcan
</div>