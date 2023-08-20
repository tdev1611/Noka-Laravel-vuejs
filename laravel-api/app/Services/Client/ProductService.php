<?php
namespace App\Services\Client;

use App\Models\Product;


class ProductService
{
    function getProducts()
    {
        // $products = Product::where('status', 1)->orderBy('name', 'ASC')->paginate(10);
        // return $products;
        $products = Product::where('status', 1)->orderBy('name', 'ASC')->paginate(10);
        $search = request()->search;
        if ($search) {
            $products = Product::where('status', 1)->where('name', 'like', '%' . $search . '%')
                ->orderByDesc('created_at')->paginate(10);
        }
        return $products;
    }
    public function getProductsWithSizesAndColors()
    {
        return $products = Product::with('sizes', 'colors')->paginate(10);

    }
    function find($slug)
    {
        $product = Product::where('slug', $slug);
        if (!$product) {
            throw new \Exception('Product not found');
        }
        return $product;
    }
    function detailProduct($slug)
    {
        $product = $this->find($slug);
        $product = $product->with('colors', 'sizes')->first();
        return $product;
    }


    function getCategory($slug)
    {
        $product = $this->find($slug);
        return $product->category;
    }

    function getColors($slug)
    {
        $product = $this->find($slug);
        return $product->colors;
    }
    function getSizes($slug)
    {
        $product = $this->find($slug);
        return $product->sizes;
    }
}


?>