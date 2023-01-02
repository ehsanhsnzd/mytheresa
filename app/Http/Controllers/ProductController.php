<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetProductRequest;
use App\Services\ProductService;
use Exception;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
    public function __construct(
        private ProductService $service
    ){}

    /**
     * @param GetProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(GetProductRequest $request)
    {
        try {
            return response()->json($this->service->get($request));
        } catch (Exception $exception){
            return response()->json($exception->getMessage(), 500);
        }
    }
}
