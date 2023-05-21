<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Costumer;
use Illuminate\Http\Request;

class CostumerController extends Controller
{
    public function index()
    {
        $costumers = Costumer::latest()->when(request()->q, function ($costumers) {
            $costumers = $costumers->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.costumer.index', compact('costumers'));
    }
}
