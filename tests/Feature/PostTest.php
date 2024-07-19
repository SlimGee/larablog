<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_can_list_all_posts()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('posts.index'))
            ->assertStatus(200)
            ->assertViewIs('posts.index');
    }

    public function test_can_list_all_posts_via_an_api()
    {
        $user = User::factory()->create();

        Post::factory(20)->create();

        $this
            ->actingAs($user, 'sanctum')
            ->getJson(route('posts.index'))
            ->assertStatus(200);
    }

    public function test_can_create_a_post()
    {
        $user = User::factory()->create();

        $count = Post::count();

        $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'My First Post',
                'content' => 'This is my first post content.',
                'status' => 'draft',
            ])
            ->assertRedirect();

        $this->assertEquals($count + 1, Post::count());
    }

    public function test_can_create_a_post_via_an_api()
    {
        $user = User::factory()->create();

        $count = Post::count();

        $this
            ->actingAs($user, 'sanctum')
            ->postJson(route('posts.store'), [
                'title' => 'My First Post',
                'content' => 'This is my first post content.',
                'status' => 'draft',
            ])
            ->assertStatus(201);

        $this->assertEquals($count + 1, Post::count());
    }

    public function test_can_show_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('posts.show', $post))
            ->assertStatus(200)
            ->assertViewIs('posts.show')
            ->assertSee($post->title);
    }

    public function test_can_show_a_post_via_an_api()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this
            ->actingAs($user, 'sanctum')
            ->getJson(route('posts.show', $post))
            ->assertSee($post->title)
            ->assertStatus(200);
    }

    public function test_can_update_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this
            ->actingAs($user)
            ->put(route('posts.update', $post), [
                'title' => 'My Updated Post',
                'content' => 'This is my updated post content.',
                'status' => 'published',
            ])
            ->assertRedirect();

        $this->assertEquals('My Updated Post', $post->fresh()->title);
    }

    public function test_can_only_update_post_that_user_owns()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this
            ->actingAs($user)
            ->put(route('posts.update', $post), [
                'title' => 'My Updated Post',
                'content' => 'This is my updated post content.',
                'status' => 'published',
            ])
            ->assertForbidden();

        $this->assertNotEquals('My Updated Post', $post->fresh()->title);
    }

    public function test_can_update_a_post_via_an_api()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this
            ->actingAs($user, 'sanctum')
            ->putJson(route('posts.update', $post), [
                'title' => 'My Updated Post',
                'content' => 'This is my updated post content.',
                'status' => 'published',
            ])
            ->assertStatus(200);

        $this->assertEquals('My Updated Post', $post->fresh()->title);
    }

    public function test_can_only_update_post_that_user_owns_via_an_api()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this
            ->actingAs($user, 'sanctum')
            ->putJson(route('posts.update', $post), [
                'title' => 'My Updated Post',
                'content' => 'This is my updated post content.',
                'status' => 'published',
            ])
            ->assertStatus(403);

        $this->assertNotEquals('My Updated Post', $post->fresh()->title);
    }

    public function test_can_delete_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this
            ->actingAs($user)
            ->delete(route('posts.destroy', $post))
            ->assertRedirect();

        $this->assertModelMissing($post);
    }

    public function test_can_only_delete_post_that_user_owns()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this
            ->actingAs($user)
            ->delete(route('posts.destroy', $post))
            ->assertForbidden();

        $this->assertModelExists($post);
    }

    public function test_can_delete_a_post_via_an_api()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this
            ->actingAs($user, 'sanctum')
            ->deleteJson(route('posts.destroy', $post))
            ->assertStatus(204);

        $this->assertModelMissing($post);
    }

    public function test_can_only_delete_post_that_user_owns_via_an_api()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this
            ->actingAs($user, 'sanctum')
            ->deleteJson(route('posts.destroy', $post))
            ->assertStatus(403);

        $this->assertModelExists($post);
    }
}
