<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(ProductSearchRequest $request): AnonymousResourceCollection
    {
        $filters = $request->validated();

        $query = Product::query()
            ->with('category')
            ->when($filters['q'] ?? null, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->when($filters['price_from'] ?? null, fn($q, $price) => $q->where('price', '>=', $price))
            ->when($filters['price_to'] ?? null, fn($q, $price) => $q->where('price', '<=', $price))
            ->when($filters['category_id'] ?? null, fn($q, $ids) => $q->whereIn('category_id', $ids))
            ->when($filters['in_stock'] ?? null, fn($q, $stock) => $q->where('in_stock', $stock));

        if (!empty($filters['sort'])) {
            foreach ($filters['sort'] as $sortOption) {
                match ($sortOption) {
                    'price_asc' => $query->orderBy('price', 'asc'),
                    'price_desc' => $query->orderBy('price', 'desc'),
                    'newest' => $query->latest(),
                    'rating_desc' => $query->orderBy('rating', 'desc'),
                    default => null,
                };
            }
        } else {
            $query->latest(); // default sorting
        }

        return ProductResource::collection($query->paginate(10)->withQueryString());
    }
}
