<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => [
                'raw' => $this->price,
                'formatted' => '$' . number_format($this->price, 2),
            ],
            'in_stock' => (bool)$this->in_stock,
            'category' => $this->category_id,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
