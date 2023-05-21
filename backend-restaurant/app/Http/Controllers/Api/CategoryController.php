<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'List Data Categories',
            'data' => $categories
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $category = Category::with('food.user', 'food.sumTransaction')->where('slug', $slug)->first();

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Makanan Berdasarkan Category : ' . $category->name,
                'data' => $category
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Category Tidak Ditemukan!'
        ], 404);
    }


    public function categoryHome()
    {
        $categories = Category::latest()->take(3)->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Category Home',
            'data' => $categories
        ], 200);
    }
}
