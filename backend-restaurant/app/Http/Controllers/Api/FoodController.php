<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('user')->with('sumTransaction')->when(request()->q, function ($foods) {
            $foods = $foods->where('title', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List Data Makanan',
            'data' => $foods
        ], 200);
    }

    public function show($slug)
    {
        $food = Food::with('user')->with('sumTransaction')->where('slug', $slug)->first();

        $transactions = Transaction::with('costumer')->where('food_id', $food->id)->where('status', 'success')->latest()->get();

        if ($food) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Campaign : ' . $food->title,
                'data' => $food,
                'transactions' => $transactions
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Campaign Tidak Ditemukan!',
        ], 404);
    }
}