<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Costumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Profile',
            'data' => auth()->guard('api')->user()
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $costumer = Costumer::whereId(auth()->guard('api')->user()->id)->first();

        if ($request->file('avatar')) {
            Storage::disk('local')->delete('public/costumers/' . basename($costumer->avatar));

            $image = $request->file('avatar');
            $image->storeAs('public/costumers', $image->hashName());

            $costumer->update([
                'name' => $request->name,
                'avatar' => $image->hashName()
            ]);
        }

        $costumer->update([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Profile Berhasil Diupdate!',
            'data' => $costumer
        ], 201);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $costumer = Costumer::whereId(auth()->guard('api')->user()->id)->first();
        $costumer->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password Berhasil Diupdate!',
            'data' => $costumer
        ], 201);
    }
}
