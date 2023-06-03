@extends('layouts.app', ['title' => 'Transaction - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">

        <form action="{{ route('admin.transaction.filter') }}" method="GET">
            <div class="flex gap-6">

                <div class="flex-auto">
                    <label for="status" class="text-gray-700">
                        STATUS
                    </label>
                    <select name="status" class="form-input w-full mt-2 rounded-md bg-white p-3 shadow-md" id="status">
                        <option disabled selected value="">Please Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="success">Completed</option>
                    </select>
                </div>
                <div class="flex-auto">

                    <label class="text-gray-700" for="name">TANGGAL AWAL</label>
                    <input class="form-input w-full mt-2 rounded-md bg-white p-3 shadow-md" type="date"
                        name="order_placed_at"
                        value="{{ old('order_placed_at') ?? request()->query('order_placed_at') }}">
                    @error('order_placed_at')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
                </div>


                <div class="flex-1">
                    <button type="submit"
                        class="mt-8 w-full p-3 bg-gray-600 text-gray-200 rounded-md shadow-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">FILTER</button>
                </div>

            </div>
        </form>


        @if($transactions ?? '')
        @if(count($transactions) > 0)

        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block w-full shadow-sm rounded-lg overflow-hidden">
                <table class="w-full tablecostumerauto ">
                    <thead class="justify-between">
                        <tr class="bg-gray-600 w-full">
                            <th class="px-16 transaction-food">
                                <span class="text-white">NAMA COSTUMER</span>
                            </th>
                            <th class="px-16 py-2 transaction-left">
                                <span class="text-white">FOODS</span>
                            </th>
                            <th class="px-16 py-2 text-left">
                                <span class="text-white">TANGGAL</span>
                            </th>
                            <th class="px-16 py-2 text-center">
                                <span class="text-white">JUMLAH TRANSAKSI</span>

                            </th>
                            <th class="px-16 py-2 text-center">
                                <span class="text-white">ACTIONS</span>

                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-200">
                        @forelse($transactions as $transaction)
                        @foreach ($transaction->food as $food)

                        @endforeach
                        <tr class="border bg-white ">

                            <td class="px-16 py-2 flex justify-center">
                                {{ $transaction->invoice }}
                            </td>
                            <td class="px-16 py-2">
                                {{ $transaction->costumer->name }}
                            </td>
                            <td class="px-16 py-2">
                                {{ $transaction->created_at }}
                            </td>
                            <td class="px-5 py-2 text-center ">
                                {{ moneyFormat($transaction->amount) }}
                            </td>
                            <td class="text-center p-5">
                                <a href="{{ route('admin.transaction.show', $transaction->invoice) }}"
                                    class="bg-gray-600 p-3 px-6 text-sm rounded-lg text-white uppercase">View</a>
                            </td>
                        </tr>

                        @empty
                        <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                            Data Belum Tersedia!
                        </div>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        @endif

        @endif

    </div>

</main>
@endsection