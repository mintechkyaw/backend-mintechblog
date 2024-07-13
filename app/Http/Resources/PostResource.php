<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'published_at' => $this->published_at,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'likecount' => $this->reactions->where('react_type', 'like')->count(),
            'lovecount' => $this->reactions->where('react_type', 'love')->count(),
            'commentcount' => $this->comments->count(),
            'userReaction' => $this->reactions
        ->where('user_id', Auth::id())
        ->first()
        ?->react_type,
        ];
    }
}
