<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_may_not_make_threads()
	{
        $this->withExceptionHandling();

		$this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
	}

    /** @test */
    public function an_authenticate_user_can_create_forum_threads()
    {
    	$this->signIn();

    	$thread = make('App\Thread');

    	$response = $this->post('/threads', $thread->toArray() );

    	$this->get($response->headers->get('Location'))
			->assertSee($thread->title)
			->assertSee($thread->body);
    }

    /** @test */
    function a_thread_requires_a_title()
   { 
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999]) // we know that 999 won't exists yet
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();
        $thread   = create('App\Thread');
        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())
            ->assertStatus(403);

    }

    /** @test */
    public function authorized_users_can_delete_a_thread()
    {
        $this->signIn();

        $thread   = create('App\Thread', ['user_id' => auth()->id() ]);
        $reply    = create('App\Reply', ['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, \App\Activity::count());
    }

    // Helper function
    protected function publishThread(array $overides=[])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', $overides);
        return $this->post( '/threads', $thread->toArray() );
    }


}
