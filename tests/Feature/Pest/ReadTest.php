<?php

use App\Models\Post;

it('lists all posts on the main page', function () {
    Post::factory()->create(['title' => 'My First Post', 'created_at' => now()->subDay()]);
    Post::factory()->create(['title' => 'My Second Post', 'created_at' => now()]);

    $response = $this->get(route('post.index'));

    $response->assertSuccessful();
    $response->assertSee('My First Post');
    $response->assertSee('My Second Post');
    $response->assertSeeInOrder(['My Second Post', 'My First Post']);
});

it('shows correct info on a single post page', function () {
    $post = Post::factory()->create([
        'title' => 'My First Post',
        'body' => 'Content for this post'
    ]);

    $response = $this->get(route('post.show', $post));

    $response->assertSuccessful();
    $response->assertSee('My First Post');
    $response->assertSee('Content for this post');
});
