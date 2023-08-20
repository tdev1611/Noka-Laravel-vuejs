<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Services\Client\CategoryService;
use App\Services\Client\ProductService;
use App\Services\Client\ColorService;
use App\Services\Client\SizeService;

class WelcomeController extends Controller
{

    protected $productService, $categoryService, $sizeService, $colorService;
    function __construct(ProductService $productService, CategoryService $categoryService, ColorService $colorService, SizeService $sizeService)
    {
        $this->categoryService = $categoryService;
        $this->colorService = $colorService;
        $this->sizeService = $sizeService;
        $this->productService = $productService;
    }
    function index()
    {

        $categories = $this->categoryService->getCategories();
        $colors = $this->colorService->getColors();
        $sizes = $this->sizeService->getSizes();
        //   $products = $this->productService->getProducts();
        $getProductsWithSizesAndColors = $this->productService->getProductsWithSizesAndColors();
        $categories = response()->json(
            [
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $categories,
            ]
        );
        $colors = response()->json(
            [
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $colors,
            ]
        );
        $sizes = response()->json(
            [
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $sizes,

            ]
        );
        $products = response()->json(
            [
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $getProductsWithSizesAndColors->items(),
                'meta' => [
                    'total' => $getProductsWithSizesAndColors->total(),
                    'perPage' => $getProductsWithSizesAndColors->perPage(),
                    'currentPage' => $getProductsWithSizesAndColors->currentPage()
                ],

            ]
        );
        return response()->json(
            [
                // sidebar
                'categories' => $categories,
                'colors' => $colors,
                'sizes' => $sizes,
                //view home
                'products' => $products,
            ],

        );

    }



    function searchClient()
    {
        $categories = $this->categoryService->getCategories();
        $colors = $this->colorService->getColors();
        $sizes = $this->sizeService->getSizes();
        $products = $this->productService->getProducts();
        $search = request()->search;
        return view('search', compact('categories', 'sizes', 'colors', 'products', 'search'));
    }
}