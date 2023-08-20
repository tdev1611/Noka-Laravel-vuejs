<?php
namespace App\Services\Client;

use App\Models\Color;
use Symfony\Component\HttpFoundation\Response;

class ColorService
{
    function getColors()
    {
        return Color::where('status', 1)->orderBy('name', 'asc')->get();
    }

    function find($slug)
    {
        $color = Color::where('slug', $slug)->first();
        if (!$color) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'data' => 'not found',
            ]);
        }
        return $color;
    }
    function getProduct($slug)
    {

        // $color = $this->find($slug);
        $color = Color::where('slug', $slug)->first();
        if (!$color) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_FOUND,
                'data' => 'not found',
            ]);
        }
        $products = $color->products()->with('colors', 'sizes')->paginate(12);
        return $products;
    }

}


?>