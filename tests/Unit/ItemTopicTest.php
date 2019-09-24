<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTopicTest extends TestCase
{
    use RefreshDatabase;


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRelationship()
    {
        $topic = factory(\App\Models\Topic::class)->create();
        $topic->items()->createMany(
            factory(\App\Models\Item::class, 2)->make()->toArray()
        );

        $this->assertCount(2, $topic->items);
        $this->assertEquals(0, $topic->items[0]->pivot->order);
        $this->assertEquals(1, $topic->items[1]->pivot->order);
    }
}
