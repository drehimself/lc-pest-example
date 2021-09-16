<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function main_page_lists_all_posts()
    {
        Post::factory()->create(['title' => 'My First Post', 'created_at' => now()->subDay()]);
        Post::factory()->create(['title' => 'My Second Post', 'created_at' => now()]);

        $response = $this->get(route('post.index'));

        $response->assertSuccessful();
        $response->assertSee('My First Post');
        $response->assertSee('My Second Post');
        $response->assertSeeInOrder(['My Second Post', 'My First Post']);
    }

    /** @test */
    public function single_post_page_shows_correct_info()
    {
        $post = Post::factory()->create([
            'title' => 'My First Post',
            'body' => 'Content for this post'
        ]);

        $response = $this->get(route('post.show', $post));

        $response->assertSuccessful();
        $response->assertSee('My First Post');
        $response->assertSee('Content for this post');
    }
}
