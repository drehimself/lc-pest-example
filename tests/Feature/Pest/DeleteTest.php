<?php

use App\Models\Post;
use App\Models\User;

test('delete button shows on single post page if logged in user has authorization', function () {
    $post = Post::factory()->create();

    $response = $this->actingAs($post->user)->get(route('post.show', $post));

    $response->assertSuccessful();
    $response->assertSee('Delete Post');
});

test('delete button does not show on single post page if logged in user does not have authorization', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('post.show', $post));

    $response->assertSuccessful();
    $response->assertDontSee('Delete Post');
});

test('delete post works if logged in user has authorization', function () {
    $post = Post::factory()->create([
        'title' => 'My First Post'
    ]);

    $response = $this->actingAs($post->user)->delete(route('post.destroy', $post));

    $response->assertRedirect(route('post.index'));
    $response->assertSessionHas('success_message', 'Post was deleted successfully!');

    $this->assertDatabaseMissing('posts', [
        'title' => 'My First Post',
    ]);
});

test('delete post does not work if logged in user does not have authorization', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'title' => 'My First Post',
    ]);

    $response = $this->actingAs($user)->delete(route('post.destroy', $post));

    $response->assertStatus(401);

    $this->assertDatabaseHas('posts', [
        'title' => 'My First Post',
    ]);
});
