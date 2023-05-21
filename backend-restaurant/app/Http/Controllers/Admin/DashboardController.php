<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Costumer;
use App\Models\Food;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $costumers = Costumer::count();
        $foods = Food::count();
        $transactions = Transaction::where('status', 'success')->sum('amount');

        return view('admin.dashboard.index', compact('costumers', 'foods', 'transactions'));
    }
}
