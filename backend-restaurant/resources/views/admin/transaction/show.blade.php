@extends('layouts.app', ['title' => 'Transaction - Admin'])

@section('content')
<div class="mx-10  mt-5">
    <div class="container mx-auto mt-10 bg-white p-10 rounded-lg shadowmd">
        <div class="flex gap-10">

            <div>
                <div>
                    <label for="name">Name : </label>
                    <input type="text" id="name"
                        class="block border border-gray-500 placeholder:text-sm rounded p-2 w-full mt-3" disabled
                        value="{{ $transaction->name }}" placeholder="Name..." />



                </div>
                <div class="flex gap-5 mt-5">
                    <div>
                        <label for="phone">Phone : </label>
                        <input type="text" id="phone"
                            class="block border border-gray-500 placeholder:text-sm rounded mt-3 p-2 w-96"
                            value="{{ $transaction->phone}}" placeholder="Phone Number..." />
                    </div>
                    <div>
                        <label for="phone">Pin Code : </label>
                        <input type="text" id="phone"
                            class="block border border-gray-500 placeholder:text-sm rounded mt-3 p-2 w-96"
                            value="{{ $transaction->pin_code }}" placeholder="Pin Code..." />
                    </div>
                </div>
                <div class="mt-5">
                    <label for="address">Address : </label>
                    <input type="text" id="phone"
                        class="block border border-gray-500 placeholder:text-sm rounded mt-3 p-2 w-full"
                        value="{{ $transaction->address }}" placeholder="Pin Code..." />
                </div>
                <div class="mt-5">
                    <label for="message">User Message : </label>
                    <input type="text" id="phone"
                        class="block border border-gray-500 placeholder:text-sm rounded mt-3 p-2 w-full" disabled
                        value="{{ 'No User Message' ??$transaction->description }}" placeholder="Pin Code..." />

                </div>
            </div>
            <div>
                <table>
                    <tr>
                        <th class="p-4 border-b border-black">Image</th>
                        <th class="p-4 border-b border-black">Food Title</th>
                        <th class="p-4 border-b border-black">Price</th>
                        <th class="p-4 border-b border-black">Quantity</th>
                    </tr>
                    @foreach ($transaction->food as $food)
                    <tr class="mx-5">

                        <td class="text-center mx-5 border-b border-b-gray-300">
                            <img src="{{ $food->image }}" class="inline text-center " width="100" alt="" />
                        </td>
                        <td class="p-10 border-b border-b-gray-300">{{ $food->title }}</td>
                        <td class="border-b border-b-gray-200">{{ moneyFormat($food->price) }}
                        </td>
                        <td class="px-3 text-center border-b border-b-gray-300">{{ $food->pivot->quantity }}</td>
                    </tr>
                    @endforeach
                </table>
                <div class="">
                    <p class="text-lg my-5 text-right">Grand Total : {{ moneyFormat($amount) }}</p>
                    <p class="my-3">
                        Tracking Number : {{ $transaction->invoice }}
                    </p>
                    <p>
                        Order Status :
                        <span class="p-1 px-3 w-28 text-center text-sm text-white rounded-md bg-yellow-500">
                            In Progress
                        </span>
                    </p>
                    <p class="my-3">
                        Payment Mode : <span class="uppercase">{{ $transaction->payment_method }}</span>
                    </p>
                    <p class="my-3">
                        Order Placed At : <span>
                            {{ $transaction->order_placed_at }}
                        </span>
                    </p>
                    <div class=" border-b border-b-gray-300 w"></div>

                    <div>
                        <form action="{{ route('admin.transaction.update',$transaction->id) }}" method="post">
                            @method('put')
                            @csrf
                            <label>Update Order Status</label>
                            <select name="status" class="form-input w-full mt-2 rounded-md bg-white p-3 shadow-md"
                                id="status">
                                <option disabled selected value="">Please Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="success">Completed</option>
                            </select>

                            <button class="bg-gray-600 p-2 px-5 mt-5 text-white rounded-lg"
                                type="submit">Update</button>
                        </form>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection