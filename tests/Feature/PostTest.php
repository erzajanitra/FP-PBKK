<?php

namespace Tests\Feature;

use App\Modules\Post\Core\Domain\Model\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_article()
    {
        $response = $this->get('/article');

        $response->assertStatus(200);
    }
    public function test_aboutus()
    {
        $response = $this->get('/aboutus');

        $response->assertStatus(200);
    }
    public function test_timeline()
    {
        $response = $this->get('/timeline');

        $response->assertStatus(200);
    }
  
    
}
