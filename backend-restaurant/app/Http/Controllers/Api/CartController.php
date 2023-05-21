<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Food;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('food')->where('costumer_id', auth()->guard('api')->user->id)->latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List Data Carts : ' . auth()->guard('api')->user()->name,
            'data' => $carts
        ], 200);
    }

    public function store(Request $request)
    {
        $food = Food::where('id', $request->id)->first();

        $cart = Cart::create([
            'food_id' => $food->id,
            'costumer_id' => auth()->guard('api')->user->id,
            'quantity' => $request->quantity
        ]);
    }
}
