@extends('layouts.app')
@section('title', 'Order Success')
@section('content')

<div id="content">
    <section class="py-8 md:py-12">
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="w-full md:w-2/3 lg:w-2/3">
                    <!-- Success Image -->
                    <div class="flex justify-center mb-6">
                        <img src="https://www.bag.nexabyteit.com/public/frontEnd/images/order-success.png" 
                             alt="Order Success" 
                             class="w-full max-w-md">
                    </div>
                    
                    <!-- Success Title -->
                    <div class="text-center mb-8">
                        <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                            আপনার অর্ডারটি আমাদের কাছে সফলভাবে পৌঁছেছে, কিছুক্ষনের মধ্যে আমাদের একজন প্রতিনিধি আপনার নাম্বারে কল করবেন
                        </h2>
                    </div>

                    <!-- Order Details Heading -->
                    <h5 class="text-lg font-semibold mb-4 mt-6">Your Order Details</h5>
                    
                    <!-- Order Summary Table -->
                    <div class="mb-6">
                        <table class="w-full border border-gray-300">
                            <tbody>
                                <tr class="border-b border-gray-300">
                                    <td class="p-3 border-r border-gray-300">
                                        <p class="text-sm text-gray-600">Invoice ID</p>
                                        <p class="font-semibold">{{ $data->order_id }}</p>
                                    </td>
                                    <td class="p-3 border-r border-gray-300">
                                        <p class="text-sm text-gray-600">Date</p>
                                        <p class="font-semibold">{{ $data->payment_date }}</p>
                                    </td>
                                    <td class="p-3 border-r border-gray-300">
                                        <p class="text-sm text-gray-600">Phone</p>
                                        <p class="font-semibold">{{ $data->user->phone }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="text-sm text-gray-600">Total</p>
                                        <p class="font-semibold">{{ currency() }}{{ number_format($data->total,2) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="p-3">
                                        <p class="text-sm text-gray-600">Payment Method</p>
                                        <p class="font-semibold">{{ $data->payment_method }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Method Heading -->
                    <h5 class="text-lg font-semibold mb-6 mt-8">Pay with cash upon delivery</h5>
                    
                    <!-- Order Items Section -->
                    <div class="mb-6">
                        <h6 class="text-base font-semibold mb-4">Order Delivery</h6>
                        <table class="w-full border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr class="border-b border-gray-300">
                                    <th class="p-3 text-left font-semibold">Product</th>
                                    <th class="p-3 text-left font-semibold">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                $net_total = 0;
                                @endphp

                                @foreach($data->orderItems as $item)
                                <tr class="border-b border-gray-300">
                                    <td class="p-3">
                                        <p>{{ $item->product->name }} –  x {{ $item->quantity }}</p>
                                    </td>
                                    <td class="p-3">
                                        <p class="font-semibold">{{ currency() }}{{ number_format($item->price,2) }}</p>
                                    </td>
                                </tr>

                                @php 
                                    $net_total += $item->quantity * $item->price;
                                @endphp
                                @endforeach

                                <tr class="border-b border-gray-300 bg-gray-50">
                                    <th class="p-3 text-right px-4">Net Total</th>
                                    <td class="p-3">
                                        <strong id="net_total">{{ currency() }}{{ number_format($net_total,2) }}</strong>
                                    </td>
                                </tr>

                                <tr class="border-b border-gray-300 bg-gray-50">
                                    <th class="p-3 text-right px-4">Shipping Cost</th>
                                    <td class="p-3">
                                        <strong id="cart_shipping_cost">{{ currency() }}{{ number_format($data->delivery_charge,2) }}</strong>
                                    </td>
                                </tr>
                                
                                <tr class="bg-gray-50">
                                    <th class="p-3 text-right px-4">Grand Total</th>
                                    <td class="p-3">
                                        <strong id="grand_total">{{ currency() }}{{ number_format($data->total,2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Billing Address -->
                        <table class="w-full border border-gray-300 mt-4">
                            <tbody>
                                <tr>
                                    <td class="p-4">
                                        <h5 class="text-lg font-semibold mb-4">Billing Address</h5>
                                        <p class="mb-1">{{ $data->user->name }}</p>
                                        <p class="mb-1">{{ $data->user->phone }}</p>
                                        <p>{{ $data->user->address }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Go to Home Button -->
                    <a href="/" class="inline-block my-8 px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition duration-200">
                        Go To Home
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- content end -->

@endsection