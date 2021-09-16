<?php

use App\Models\User;

beforeEach(function () {
    $this->foo = 'bar';
});

test('create page redirects to login page if the user is not logged in', function () {
    $response = $this->get(route('post.create'));

    $response->assertRedirect(route('login'));

    $this->assertEquals('bar', $this->foo);
});

test('create page shows when the user is logged in', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->get(route('post.create'));

    $response->assertSuccessful();
    $response->assertViewIs('create');
    $response->assertSee('Create Post');

    $this->assertEquals('bar', $this->foo);
});

test('the validation works when creating a post', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('post.store'), [
        'title' => '',
        'body' => '',
    ]);

    $response->assertSessionHasErrors(['title', 'body']);

    $response = $this->actingAs($user)->post(route('post.store'), [
        'title' => 'a',
        'body' => 'b',
    ]);

    $response->assertSessionHasErrors(['title', 'body']);
});

test('creating post works when user is logged in', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('post.store'), [
        'title' => 'My First Post',
        'body' => 'Content for my first post',
    ]);

    $response->assertRedirect(route('post.index'));
    $response->assertSessionHas('success_message', 'Post was added successfully!');

    $this->assertDatabaseHas('posts', [
        'title' => 'My First Post',
        'body' => 'Content for my first post',
    ]);
});
