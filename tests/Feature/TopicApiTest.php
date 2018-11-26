<?php

namespace Tests\Feature;

use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{
    use ActingJWTUser;

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

    public function testStoreTopic()
    {
        $data = ['category_id' => 1, 'body' => 'test body', 'title' => 'test title'];


        $response = $this->JWTActingAS($this->user)
            ->json('POST', 'api/topics', $data);
        $assertData = [
            'category_id' => 1,
            'body' => clean('test body', 'user_topic_body'),
            'title' => 'test title'
        ];
        $response->assertStatus(201)->assertJsonFragment($assertData);

    }

    public function testUpdateTopic()
    {
        $topic = $this->makeTopic();
        $editData = ['category_id' => 2, 'body' => 'edit body', 'title' => 'edit title'];
        $response = $this->JWTActingAS($this->user)
            ->json('PATCH', '/api/topics/' . $topic->id, $editData);
        $assertData = [
            'category_id' => 2,
            'body' => clean('edit body', 'user_topic_body'),
            'title' => 'edit title'
        ];
        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    public function testShowTopic(){
        $topic= $this->makeTopic();
        $response = $this->json('GET','/api/topics/'.$topic->id);
        $assertData = [
            'category_id'=>$topic->category_id,
            'user_id'=>$topic->user_id,
            'body'=>$topic->body,
            'title'=>$topic->title
        ];
        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    public function testIndexTopic(){
        $response = $this->json('GET', '/api/topics');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'meta']);
    }

    public function testDeleteTopic(){
        $topic=$this->makeTopic();
        $response = $this->JWTActingAS($this->user)
            ->json('DELETE','/api/topics/'.$topic->id);
        $response->assertStatus(204);

        $response = $this->json('GET', '/api/topics/'.$topic->id);
        $response->assertStatus(404);
    }

    protected function makeTopic()
    {
        return factory(Topic::class)->create([
            'category_id' => 1,
            'user_id' => $this->user->id,
        ]);
    }
}
