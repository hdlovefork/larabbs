<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicApiTest extends TestCase
{
    protected $user;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testStoreTopic(){
        $data=['category_id'=>1,'body'=>'test body','title'=>'test title'];

        $token = \Auth::guard('api')->fromUser($this->user);
        $response = $this->withHeader('Authorization','Bearer'.$token)
            ->json('POST','api/topics',$data);
        $assertData = [
            'category_id'=>1,
            'body'=>clean('test body','user_topic_body'),
            'title'=>'test title'
        ];
        $response->assertStatus(201)->assertJsonFragment($assertData);

    }
}
