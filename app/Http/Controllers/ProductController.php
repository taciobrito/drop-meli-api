<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $productRepository;
    private $productService;

    public function __construct(ProductRepository $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->list($request->all());

        return response()->json($products, 200);
    }

    public function store(ProductRequest $request)
    {
        $response = $this->productService->create($request->all());
        $response->throw()->json();

        $request['item_id'] = $response['id'];

        $result = $this->productRepository->create($request->all());

        if (is_string($result)) {
            return response()->json([
                'message' => $result
            ], 400);
        }

        return response()->json($result, 201);
    }
}
