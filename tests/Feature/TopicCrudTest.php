<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Admin\TopicCrudController;
use App\Models\Topic;
use App\User;

class TopicCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testsSetsPreviousTopicOnNextTopic()
    {
        $user = factory(User::class)->create();
        $topic1 = factory(Topic::class)->create();
        $topic2 = factory(Topic::class)->create();

        $controller = new TopicCrudController();
        $controller->setup();

        $response = $this->actingAs($user, 'backpack')
                         ->followingRedirects()
                         ->patch(url($controller->crud->getRoute(), $topic1->id), ['id' => $topic1->id, 'next_topic_id' => $topic2->id]);

        $response->assertStatus(200);

        $topic1->refresh();
        $topic2->refresh();

        $this->assertEquals($topic2->id, $topic1->nextTopic->id);
        $this->assertEquals($topic1->id, $topic2->previousTopic->id);
    }
}
