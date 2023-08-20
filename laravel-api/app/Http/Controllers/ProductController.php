<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Client\ProductService;
use App\Services\Client\CategoryService;
use App\Services\Client\ColorService;
use App\Services\Client\SizeService;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Color;
use App\Models\Category;
use App\Models\Size;

class ProductController extends Controller
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

    }
    function detail($slug)
    {
        try {
            $productService = new ProductService();
            $product = $productService->detailProduct($slug);
            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => [
                    'product' => $product,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'data' => [
                    'product' => 'not found',
                ],
            ]);
        }

    }
    function productByCategory($slug)
    {

        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'data' => 'not found',
            ]);
        }
        $products = $category->products()->with('colors', 'sizes')->paginate(12);
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'name' => $slug,
            'data' => $products->items(),
            'meta' => [
                'total' => $products->total(),
                'perPage' => $products->perPage(),
                'currentPage' => $products->currentPage()
            ],
        ]);

    }


    function productByColor($slug)
    {

        // $products = $this->colorService->getProduct($slug);
        $color = Color::where('slug', $slug)->first();
        if (!$color) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'data' => 'not found',
            ]);
        }
        $products = $color->products()->with('colors', 'sizes')->paginate(12);
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'name' => $slug,
            'data' => $products->items(),
            'meta' => [
                'total' => $products->total(),
                'perPage' => $products->perPage(),
                'currentPage' => $products->currentPage()
            ],
        ]);

    }

    function productBySize($slug)
    {
        $size = Size::where('slug', $slug)->first();
        if (!$size) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'data' => 'not found',
            ]);
        }
        $products = $size->products()->with('colors','sizes')->paginate(12);
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'name' => $slug,
            'data' => $products->items(),
            'meta' => [
                'total' => $products->total(),
                'perPage' => $products->perPage(),
                'currentPage' => $products->currentPage()
            ],
        ]);


    }





}