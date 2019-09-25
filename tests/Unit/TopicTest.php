<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    public function testSlugAutomaticallyGeneratedIfEmpty()
    {
        $topic = factory(\App\Models\Topic::class)->make();
        $topic->slug = '';
        $topic->save();

        $this->assertEquals($topic->slug, Str::slug($topic->name, '-'));
    }

    public function testSlugCanBeCustomized()
    {
        $topic = factory(\App\Models\Topic::class)->make();
        $topic->slug = 'custom-slug';
        $topic->save();

        $this->assertEquals($topic->slug, 'custom-slug');
    }
}
