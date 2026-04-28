<?php

namespace App\Actions;

use App\Models\Product;

class GetFilteredProductsAction
{
    public function execute(array $filters)
    {
        $query = Product::query()->with('category');

        return $query
            ->when($filters['q'] ?? null, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($filters['price_from'] ?? null, fn($q, $p) => $q->where('price', '>=', $p))
            ->when($filters['price_to'] ?? null, fn($q, $p) => $q->where('price', '<=', $p))
            ->when($filters['category_id'] ?? null, fn($q, $ids) => $q->whereIn('category_id', $ids))
            ->when($filters['in_stock'] ?? null, fn($q, $s) => $q->where('in_stock', $s))
            ->tap(function ($query) use ($filters) {
                if (!empty($filters['sort'])) {
                    foreach ($filters['sort'] as $option) {
                        match ($option) {
                            'price_asc'  => $query->orderBy('price', 'asc'),
                            'price_desc' => $query->orderBy('price', 'desc'),
                            'newest'     => $query->latest(),
                            default      => null,
                        };
                    }
                } else {
                    $query->latest();
                }
            });
    }
}
