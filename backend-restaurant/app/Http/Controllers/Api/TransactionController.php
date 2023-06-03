<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Costumer;
use App\Models\Food;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        $transactions = Transaction::with('food')->where('costumer_id', auth()->guard('api')->user()->id)->latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List Data Transactions : ' . auth()->guard('api')->user()->name,
            'data' => $transactions
        ], 200);
    }



    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $this->validate($request, [
                'name' => 'required',
                'phone' => 'required |numeric',
                'pin_code' => 'required|numeric',
                'address' => 'required',
            ]);

            $length = 10;
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            $no_invoice = 'TRX-' . Str::upper($random);
            $name = 'dsjgsg';


            $paymentMethod = $request->payment_method;

            if ($paymentMethod == 'cod') {
                $transaction = Transaction::create([
                    'invoice' => $no_invoice,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'pin_code' => $request->pin_code,
                    'address' => $request->address,
                    'costumer_id' => auth()->guard('api')->user()->id,
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'payment_method' => 'cod',
                    'status' => 'pending'
                ]);

                $costumer = Costumer::find(auth()->guard('api')->user()->id);
                $costumer->cart()->delete();
                $quantities = $request->input('quantity');
                $foodIds = $request->input('foodIds');

                foreach ($foodIds as $index => $foodId) {
                    $quantity = $quantities[$index];
                    $transaction->food()->attach($foodId, ['quantity' => $quantity]);
                }


                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi Berhasil Dibuat',
                    'data' => $transaction
                ]);
            } elseif ($paymentMethod == 'midtrans') {

                $transaction = Transaction::create([
                    'invoice' => $no_invoice,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'pin_code' => $request->pin_code,
                    'address' => $request->address,
                    'costumer_id' => auth()->guard('api')->user()->id,
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'payment_method' => 'midtrans',

                    'status' => 'pending'
                ]);

                $costumer = Costumer::find(auth()->guard('api')->user()->id);
                $costumer->cart()->delete();
                $quantities = $request->input('quantity');
                $foodIds = $request->input('foodIds');

                foreach ($foodIds as $index => $foodId) {
                    $quantity = $quantities[$index];
                    $transaction->food()->attach($foodId, ['quantity' => $quantity]);
                }



                $payload = [
                    'transaction_details' => [
                        'order_id' => $transaction->invoice,
                        'gross_amount' => $transaction->amount,
                    ],
                    'costumer_details' => [
                        'first_name' => auth()->guard('api')->user()->name,
                        'email' => auth()->guard('api')->user()->email,
                    ]
                ];

                $snapToken = Snap::getSnapToken($payload);
                $transaction->snap_token = $snapToken;
                $transaction->save();

                $this->response['snap_token'] = $snapToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi Berhasil Dibuat!',
                    $this->response
                ]);
            }
        });
    }

    public function notificationHandler(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid Signature!'], 403);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        $data_transaction = Transaction::where('invoice', $orderId)->first();

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $data_transaction->update([
                        'status' => 'pending'
                    ]);
                } else {
                    $data_transaction->update([
                        'status' => 'success'
                    ]);
                }
            }
        } elseif ($transaction == 'settlement') {
            $data_transaction->update([
                'status' => 'success'
            ]);
        } elseif ($transaction == 'pending') {
            $data_transaction->update([
                'status' => 'pending'
            ]);
        } elseif ($transaction == 'deny') {
            $data_transaction->update([
                'status' => 'failed'
            ]);
        } elseif ($transaction == 'expire') {
            $data_transaction->update([
                'status' => 'expired'
            ]);
        } elseif ($transaction == 'cancel') {
            $data_transaction->update([
                'status' => 'failed'
            ]);
        }
    }

    public function show($invoice)
    {
        $transaction = Transaction::with('food')->where('invoice', $invoice)->first();

        if ($transaction) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Transaksi : ' . $transaction->invoice,
                'data' => $transaction
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Data Transaksi Tidak Ditemukan"
        ], 404);
    }
}
