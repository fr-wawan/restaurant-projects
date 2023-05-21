<?php

namespace App\Http\Controllers\Admin;

use App\Models\Food;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::latest()->when(request()->q, function ($foods) {
            $foods = $foods->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.foods.index', compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.foods.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validation

        $this->validate($request, [
            'image' => 'required | image | mimes:jpeg,jpg,png|max:2000',
            'title' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/foods', $image->hashName());

        $food = Food::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
            'image' => $image->hashName()
        ]);

        if ($food) {
            return redirect()->route('admin.foods.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.foods.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        $categories = Category::latest()->get();
        return view('admin.foods.edit', compact('food', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Food $food)
    {
        $this->validate($request, [
            'title' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        if ($request->file('image') == '') {
            $food->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
            ]);
        } else {
            Storage::disk('local')->delete('public/foods/' . basename($food->image));

            $image = $request->file('image');
            $image->storeAs('public/foods', $image->hashName());


            $food->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'price' => $request->price,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
                'image' => $image->hashName()
            ]);
        }



        if ($food) {
            return redirect()->route('admin.foods.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.foods.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        Storage::disk('local')->delete('public/foods/' . basename($food->image));

        $food->delete();

        if ($food) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
