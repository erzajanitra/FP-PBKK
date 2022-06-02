<?php

namespace Tests\Unit\Post;

use PHPUnit\Framework\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    // public function testStoreDataSuccessfullyPost()
    // {
    //     $repo = Mockery::mock(MySQLPostRepository::class);

    //     $repo->shouldReceive('store')->once();
    //     app()->instance(PostRepository::class, $repo);
    //     $response = $this->post('/post', [
    //         '_token' => csrf_token(),
    //         'title' => 'test',
    //         'description' => 'description'
    //     ]);
    //     $response->assertStatus(302);
    //     $response->assertRedirect('/post');
    // }
}
