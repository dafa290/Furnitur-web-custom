<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::all());
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::find($id);
        if (! $product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        return response()->json($product);
    }

    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q', '');
        $products = Product::where('name', 'like', "%{$q}%")
            ->orWhere('category', 'like', "%{$q}%")
            ->orWhere('material', 'like', "%{$q}%")
            ->get();

        return response()->json($products);
    }

    public function filter(Request $request): JsonResponse
    {
        $query = Product::query();

        if ($request->filled('categories')) {
            $query->whereIn('category', $request->input('categories', []));
        }

        if ($request->filled('maxPrice')) {
            $query->where('price', '<=', $request->input('maxPrice'));
        }

        if ($request->filled('color')) {
            $query->where('color', $request->input('color'));
        }

        if ($request->filled('materials')) {
            $query->whereIn('material', $request->input('materials', []));
        }

        return response()->json($query->get());
    }
}
