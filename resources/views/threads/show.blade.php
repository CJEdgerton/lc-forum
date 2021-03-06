@extends('layouts.app')


@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">        
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </span>            

                            {{-- you can use @can('update', $thread) as well once you're brave enough --}}
                            @can('update', $thread)
                                <span>
                                    <form action="{{ $thread->path() }}" method="POST">
                                        {{ csrf_field() }} 
                                        {{ method_field('DELETE') }} 
                                        <button type="submit" class="btn btn-default btn-sm">
                                            <span class="glyphicon glyphicon-trash text-danger"></span>
                                        </button>
                                    </form> 
                                </span>
                            @endcan
                        </div>
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>

                <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

                @if( auth()->check() )
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="body">Body:</label>     
                            <textarea 
                                name="body" 
                                id="body" 
                                class="form-control" 
                                placeholder="Have something to say?" 
                                rows="5"></textarea>    
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif

            </div>

            <div class="col-md-4">  
                <div class="panel panel-default">
                    <div class="panel-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="">{{ $thread->creator->name }}</a>, and currently has @{{ repliesCount }} {{ str_plural('reply', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>

    </div>
</thread-view>
@endsection
