<?php

use App\Models\Post;
use App\Models\User;

test('edit page shows error if logged in user is unauthorized', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $response = $this->actingAs($user)->get(route('post.edit', $post));

    $response->assertStatus(401);
});

test('edit page shows if logged in user is authorized', function () {
    $post = Post::factory()->create();

    $response = $this->actingAs($post->user)->get(route('post.edit', $post));

    $response->assertSuccessful();
});

test('edit button shows on single post page if logged in user is authorized', function () {
    $post = Post::factory()->create();

    $response = $this->actingAs($post->user)->get(route('post.show', $post));

    $response->assertSuccessful();
    $response->assertSee('Edit Post');
});

test('edit button does not show on single post page if logged in user is unauthorized', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('post.show', $post));

    $response->assertSuccessful();
    $response->assertDontSee('Edit Post');
});

test('edit post validation works', function () {
    $post = Post::factory()->create();

    $response = $this->actingAs($post->user)->patch(route('post.update', $post), [
        'title' => '',
        'body' => '',
    ]);

    $response->assertSessionHasErrors(['title', 'body']);

    $response = $this->actingAs($post->user)->patch(route('post.update', $post), [
        'title' => 'a',
        'body' => 'b',
    ]);

    $response->assertSessionHasErrors(['title', 'body']);
});

test('edit post works if user has authorization', function () {
    $post = Post::factory()->create();

    $response = $this->actingAs($post->user)->patch(route('post.update', $post), [
        'title' => 'My First Post updated',
        'body' => 'Content for my first post updated',
    ]);

    $response->assertRedirect(route('post.index'));
    $response->assertSessionHas('success_message', 'Post was updated successfully!');

    $this->assertDatabaseHas('posts', [
        'title' => 'My First Post updated',
        'body' => 'Content for my first post updated',
    ]);
});

test('edit post does not work if user does not have authorization', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $response = $this->actingAs($user)->patch(route('post.update', $post), [
        'title' => 'My First Post updated',
        'body' => 'Content for my first post updated',
    ]);

    $response->assertStatus(401);
});
