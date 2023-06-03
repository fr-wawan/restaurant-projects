<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {

        return view('admin.transaction.index');
    }

    public function show($invoice)
    {
        $transaction = Transaction::with('food')->where('invoice', $invoice)->first();

        $amount = Transaction::where('invoice', $invoice)->sum('amount');

        return view('admin.transaction.show', compact('transaction', 'amount'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $this->validate($request, [
            'status' => 'required'
        ]);

        $transaction->update([
            'status' => $request->status,
        ]);
        if ($transaction) {
            return redirect()->route('admin.transaction.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.transaction.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function filter(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'order_placed_at' => 'required',

        ]);

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $transactions = Transaction::where('status', $request->status)->with('food')->whereDate('created_at', '>=', $request->order_placed_at)->get();



        return view('admin.transaction.index', compact('transactions'));
    }
}
