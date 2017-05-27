<reply :attributes="{{ $reply }}" inline-template v-cloak>

	<div id="reply-{{ $reply->id }}" class="panel panel-default">
	    <div class="panel-heading">
			<div class="level">
				<h5 class="flex">
					<a href="{{ route('profile', $thread->creator) }}">
						{{ $reply->owner->name }}
					</a> said {{ $reply->created_at->diffForHumans() }} ...
				</h5>
				<div>

					{{-- Edit --}}
					@can('update', $reply )
						<button class="btn btn-sm btn-default pull-left" style="margin-right: 5px;" @click="toggleEditing">
							<span class="glyphicon glyphicon-edit" v-bind:class="classForEditingButton"></span>
						</button>
					@endcan

					{{-- Favorites --}}
					<form method="POST" action="/replies/{{$reply->id}}/favorites" class="pull-right">
						{{ csrf_field() }}
						<button type="submit" class="btn btn-default btn-sm" {{ $reply->isFavorited() ? 'disabled' : '' }}>
							<span class="glyphicon glyphicon-thumbs-up"></span> {{ $reply->favorites_count }} 
						</button>
					</form>
				</div>
			</div>
		</div>	

	    <div class="panel-body">
	    	<div v-if="editing">
	    		<div class="form-group">
		    		<textarea v-model="body" class="form-control" rows="3"></textarea>		
	    		</div>

	    		<button class="btn btn-sm btn-default" @click="update">Update</button>
	    		<button class="btn btn-sm btn-default" @click="editing = false">Cancel</button>

				@can('update', $reply )
					{{-- Delete --}}
					<form action="/replies/{{ $reply->id }}" method="POST" class="pull-right">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<button type="submit" class="btn btn-default btn-sm">
							<span class="glyphicon glyphicon-trash text-danger"></span>
						</button>
					</form>
				@endcan

	    	</div>
	    	<div v-else v-text="body"></div>


	        {{-- <p>{{ $reply->body }}</p> --}}
	    </div>
	</div>

</reply>