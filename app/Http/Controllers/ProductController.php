<?php

namespace App\Http\Controllers;

use App\Actions\GetFilteredProductsAction;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(ProductSearchRequest $request, GetFilteredProductsAction $action): AnonymousResourceCollection
    {
        $query = $action->execute($request->validated());

        return ProductResource::collection(
            $query->paginate(10)->withQueryString()
        );
    }
}
