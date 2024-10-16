<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Get all products with their categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Define how many items per page
        $perPage = 5;

        // Fetch products with category, paginated
        $products = Products::with('categorie')->paginate($perPage);

        // Prepare the response
        return response()->json([
            'status' => 'success',
            'message' => 'List all products',
            'data' => $products
        ], 200);
    }
}
