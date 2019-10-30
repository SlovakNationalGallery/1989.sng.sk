<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalEntry extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'written_at' => $this->written_at->toDateString(),
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'transcription_pages_ids' => $this->transcriptionPages()->pluck('id')
        ];
    }
}
