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
        $carts = Cart::with('food')->where('costumer_id', auth()->guard('api')->user()->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Carts : ' . auth()->guard('api')->user()->id,
            'data' => $carts,
        ], 200);
    }

    public function store(Request $request)
    {
        $food = Food::where('id', $request->id)->first();

        $existingCart = Cart::where('food_id', $food->id)->where('costumer_id', auth()->guard('api')->user()->id)->first();

        if ($existingCart) {
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
        } else {
            $cart = Cart::create([
                'food_id' => $food->id,
                'costumer_id' => auth()->guard('api')->user()->id,
                'quantity' => $request->quantity,
            ]);
        }
    }

    public function destroy($id)
    {

        $cart = Cart::findOrFail($id);

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data successfully deleted',
            'data' => $cart
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->input('quantity');
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated',
            'data' => $cart
        ]);
    }
}
