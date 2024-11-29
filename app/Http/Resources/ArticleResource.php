<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Article */
class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'author'      => $this->resource->author->name,
            'description' => $this->description,
            'status'      => $this->status,
            'created_at'  => [
                'human'     => $this->created_at->diffForHumans(),
                'raw'       => $this->created_at,
                'formatted' => $this->created_at->format('d.m.Y H:i'),
            ],
            'can'         => [
                'update' => auth()->user()->can('update', $this->resource),
                'delete' => auth()->user()->can('delete', $this->resource),
            ],
        ];
    }
}
