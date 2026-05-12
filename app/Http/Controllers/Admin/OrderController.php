<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pathau;
use App\Models\Product;
use App\Models\Redx;
use App\Models\Setting;
use App\Models\StredFast;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view order')->only('index');
        $this->middleware('permission:create order')->only(['create', 'store']);
        $this->middleware('permission:edit order')->only(['edit', 'update']);
        $this->middleware('permission:delete order')->only('destroy');

        $this->middleware('permission:view pending-order')->only('index');
        $this->middleware('permission:create pending-order')->only(['create', 'store']);
        $this->middleware('permission:edit pending-order')->only(['edit', 'update']);
        $this->middleware('permission:delete pending-order')->only('destroy');

        $this->middleware('permission:view processing-order')->only('index');
        $this->middleware('permission:create processing-order')->only(['create', 'store']);
        $this->middleware('permission:edit processing-order')->only(['edit', 'update']);
        $this->middleware('permission:delete processing-order')->only('destroy');

        $this->middleware('permission:view on-the-way')->only('index');
        $this->middleware('permission:create on-the-way')->only(['create', 'store']);
        $this->middleware('permission:edit on-the-way')->only(['edit', 'update']);
        $this->middleware('permission:delete on-the-way')->only('destroy');

        $this->middleware('permission:view hold')->only('index');
        $this->middleware('permission:create hold')->only(['create', 'store']);
        $this->middleware('permission:edit hold')->only(['edit', 'update']);
        $this->middleware('permission:delete hold')->only('destroy');

        $this->middleware('permission:view couriers')->only('index');
        $this->middleware('permission:create couriers')->only(['create', 'store']);
        $this->middleware('permission:edit couriers')->only(['edit', 'update']);
        $this->middleware('permission:delete couriers')->only('destroy');

        $this->middleware('permission:view complete')->only('index');
        $this->middleware('permission:create complete')->only(['create', 'store']);
        $this->middleware('permission:edit complete')->only(['edit', 'update']);
        $this->middleware('permission:delete complete')->only('destroy');

        $this->middleware('permission:view cancelled')->only('index');
        $this->middleware('permission:create cancelled')->only(['create', 'store']);
        $this->middleware('permission:edit cancelled')->only(['edit', 'update']);
        $this->middleware('permission:delete cancelled')->only('destroy');
    }


       public function allOrders()
    {
        $orders = Order::with(['user', 'orderItems.product.vendor'])->latest()->get();
        return view('admin.orders.all', compact('orders'));
    }
    
    
    public function create()
    {
        $users = User::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('admin.orders.create', compact('users', 'products'));
    }
    
   
   
   
   public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'products'   => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ]);
    
        $items = [];
        $total = 0;
    
        foreach ($request->products as $productId) {
            $qty     = $request->quantities[$productId] ?? 1;
            $product = Product::findOrFail($productId);
            $price   = $product->sale_price;
            $total  += $price * $qty;
    
            $items[] = [
                'product_id' => $productId,
                'quantity'   => $qty,
                'price'      => $price,
            ];
        }
    
        // manual customer হলে
        if ($request->filled('manual_name')) {
            $user = User::create([
                'name'     => $request->manual_name,
                'phone'    => $request->manual_phone,
                'email'    => $request->manual_email ?? null,
                'address'  => $request->manual_address ?? null,
                'password' => bcrypt('password123'),
            ]);
            $userId = $user->id;
        } else {
            $userId = $request->user_id;
        }
    
        $order = Order::create([
            'order_id'        => 'ORD-' . strtoupper(uniqid()),
            'user_id'         => $userId,
            'total'           => $total + ($request->delivery_charge ?? 0),
            'delivery_charge' => $request->delivery_charge ?? 0,
            'paid'            => $request->paid ?? 0,
            'payment_method'  => $request->payment_method ?? 'cod',
            'transaction_id'  => $request->transaction_id ?? null,
            'payment_number'  => $request->payment_number ?? null,
            'payment_status'  => 'unpaid',
            'status'          => 'pending',
            'notes'           => $request->notes,
        ]);
    
        foreach ($items as $item) {
            $order->orderItems()->create($item);
    
            // ✅ Stock deduct
            Product::where('id', $item['product_id'])
                   ->where('stock', '>=', $item['quantity'])
                   ->decrement('stock', $item['quantity']);
        }
    
        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Order created successfully!');
    }
   
   
   
   
    
    public function edit($id)
    {
        $order    = Order::with('orderItems.product', 'user')->findOrFail($id);
        $users    = User::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('admin.orders.edit', compact('order', 'users', 'products'));
    }
    
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
    
        $total = 0;
        $items = [];
    
        foreach ($request->products as $productId) {
            $qty     = $request->quantities[$productId] ?? 1;
            $product = Product::findOrFail($productId);
            $price   = $product->sale_price;
            $total  += $price * $qty;
    
            $items[] = [
                'product_id' => $productId,
                'quantity'   => $qty,
                'price'      => $price,
            ];
        }
    
        $order->update([
            'user_id'        => $request->user_id,
            'total'          => $total + ($request->delivery_charge ?? 0),
            'delivery_charge'=> $request->delivery_charge ?? 0,
            'paid'           => $request->paid ?? 0,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'payment_number' => $request->payment_number,
            'notes'           => $request->notes,
        ]);
    
        // পুরনো items delete করে নতুন add
        $order->orderItems()->delete();
        foreach ($items as $item) {
            $order->orderItems()->create($item);
        }
    
        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Order updated successfully!');
    }

    // SteadFast

    public function sendToSteadfast($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        
        $sf = StredFast::first();

        if (!$order->user) {
            return back()->with('error', 'Order user not found!');
        }

        if ($order->orderItems->isEmpty()) {
            return back()->with('error', 'Order has no items!');
        }

        $item_description = $order->orderItems->map(function ($item) {
            $productName = $item->product->name ?? 'N/A';
            return $productName . ' x ' . $item->quantity;
        })->implode(', ');

        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' => $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->post($sf->url . '/create_order', [
            'invoice'           => $order->order_id,
            'recipient_name'    => $order->user->name,
            'recipient_phone'   => $order->user->phone,
            'recipient_address' => $order->address ?? 'N/A',
            'cod_amount'        => $order->total,
            'note'              => $order->note ?? '',
            'item_description'  => $item_description,
            'delivery_type'     => 0,
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['consignment']['tracking_code'])) {
            $order->update([
                'steadfast_tracking' => $data['consignment']['tracking_code'],
                'steadfast_cid'     => $data['consignment']['consignment_id'],
                'status'     => 'steadfast',
            ]);

            return back()->with('success', 'Order sent to Steadfast successfully!');
        }

        return back()->with('error', 'Steadfast Error: ' . ($data['message'] ?? 'Invalid API response'));
    }


    public function steadfastStatus($invoice)
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' => $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->get( $sf->url . '/status_by_invoice/' . $invoice);

        return $response->json();
    }

    public function steadfastBalance()
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' =>  $sf->secret_key,
        ])->get( $sf->url . '/get_balance');

        return $response->json();
    }

    public function steadfastReturn($consignment_id)
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' =>  $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->post( $sf->url . '/create_return_request', [
            'consignment_id' => $consignment_id,
            'reason' => 'Customer Requested Return'
        ]);

        return $response->json();
    }

    // Pathao
    
    
    public function getPathaoStores()
    {
        $pathao = Pathau::first();
    
        // Token নিন
        $tokenResponse = Http::post($pathao->api_key . '/aladdin/api/v1/issue-token', [
            "client_id"     => "7N1aMJQbWm",
            "client_secret" => "wRcaibZkUdSNz2EI9ZyuXLlNrnAv0TdPUPXMnD39",
            "grant_type"    => "password",
            "username"      => "test@pathao.com",
            "password"      => "lovePathao",
        ]);
    
        $accessToken = $tokenResponse->json()['access_token'];
    
        // Store list আনুন
        $storeResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://courier-api-sandbox.pathao.com/aladdin/api/v1/stores');
    
        dd($storeResponse->json());
    }
    
    
    public function sendToPathao($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        $pathao = Pathau::first();
    
        // Step 1: Token
        $tokenResponse = Http::post($pathao->api_key . '/aladdin/api/v1/issue-token', [
            "client_id"     => $pathao->client_id,
            "client_secret" => $pathao->secret_key,
            "grant_type"    => "password",
            "username"      => $pathao->client_email,
            "password"      => $pathao->client_password,
        ]);
    
        if (!$tokenResponse->successful()) {
            return back()->with('error', 'Token Error: ' . $tokenResponse->body());
        }
    
        $accessToken = $tokenResponse->json()['access_token'];
    
        // Step 2: Order Create
        $orderResponse = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post($pathao->api_key . '/aladdin/api/v1/orders', [
            "store_id"            => (int) $pathao->store_id,
            "merchant_order_id"   => (string) $order->order_id,
            "recipient_name"      => $order->user->name ?? 'Guest',
            "recipient_phone"     => $order->user->phone ?? '01700000000',
            "recipient_address"   => $order->user->address ?? 'N/A',
            "delivery_type"       => 48,
            "item_type"           => 2,
            "special_instruction" => $order->notes ?? '',
            "item_quantity"       => (int) $order->orderItems->sum('quantity'),
            "item_weight"         => 0.5,
            "item_description"    => $order->orderItems
                                        ->map(fn($i) => $i->product->name . ' x ' . $i->quantity)
                                        ->implode(', '),
            "amount_to_collect"   => (int) round($order->total),
        ]);
    
        $data = $orderResponse->json();
    
        // ✅ consignment_id দিয়ে save
        $consignmentId = $data['data']['consignment_id'] ?? null;
    
        if ($consignmentId) {
            $order->update([
                'pathao_tracking' => $consignmentId,
                'pathao_order_id' => $consignmentId,
                'status'          => 'pathao',
            ]);
            return back()->with('success', 'Pathao তে Order পাঠানো সফল হয়েছে! Tracking: ' . $consignmentId);
        }
    
        return back()->with('error', 'Pathao Error: ' . json_encode($data));
    }

    // Redx
    public function sendToRedX($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        $redx = Redx::first();

        $jwtToken = $redx->api_token; // JWT token from RedX
        $storeId = $redx->store_id; // Pickup store id

        $parcelDetails = $order->orderItems->map(function ($item) {
            return [
                'name' => $item->product->name ?? 'N/A',
                'qty' => $item->quantity ?? 'N/A',
                'value' => (float) $item->price,
            ];
        });

        $payload = [
            'customer_name' => $order->user->name ?? 'Guest',
            'customer_phone' => $order->user->phone,
            'delivery_area' => $order->address ?? 'N/A',
            'delivery_area_id' => 1,
            'customer_address' => $order->address ?? 'N/A',
            'merchant_invoice_id' => $order->order_id,
            'cash_collection_amount' => (int) round($order->total),
            'parcel_weight' => 0.5,
            'instruction' => $order->notes ?? '',
            'value' => (float) $order->total,
            'is_closed_box' => true, // boolean type now
            'pickup_store_id' => $storeId,
            'parcel_details_json' => $parcelDetails,
        ];


        $response = Http::withHeaders([
            'API-ACCESS-TOKEN' => 'Bearer ' . $jwtToken,
            'Content-Type' => 'application/json'
        ])->post('https://sandbox.redx.com.bd/v1.0.0-beta/parcel', $payload);

        $data = $response->json();
        // dd($data);

        if ($response->successful() && isset($data['tracking_id'])) {
            $order->update([
                'redx_tracking' => $data['tracking_id'] ?? null,
                'status' => 'redx'
            ]);

            return back()->with('success', 'Order sent to RedX successfully! Tracking ID: ' . ($data['tracking_id'] ?? 'N/A'));
        } else {
            return back()->with('error', 'RedX Error: ' . ($data['message'] ?? 'Unknown error'));
        }
    }








    public function show($id)
    {
        $order = Order::with('orderItems.product', 'user')->findOrFail($id);
        $setting = Setting::first();
        return view('admin.orders.show', compact('order', 'setting'));
    }
    
    // public function updateStatus(Request $request, Order $order)
    // {
    //     $field = $request->field;
    //     $value = $request->value;

    //     if (in_array($field, ['status', 'payment_status'])) {

           
    //         if ($field === 'payment_status' && $value === 'paid') {
    //             $order->paid = $order->total;
    //         }

    //         $order->$field = $value;
    //         $order->save();

    //         return response()->json(['success' => true]);
    //     }

    //     return response()->json(['success' => false], 400);
    // }
    
    
    public function updateStatus(Request $request, Order $order)
    {
        $field = $request->field;
        $value = $request->value;
    
        if (in_array($field, ['status', 'payment_status'])) {
    
            // Payment paid হলে paid amount update
            if ($field === 'payment_status' && $value === 'paid') {
                $order->paid = $order->total;
            }
    
            // ✅ Cancel হলে stock ফেরত দাও
            if ($field === 'status' && $value === 'cancelled' && $order->status !== 'cancelled') {
                foreach ($order->orderItems as $item) {
                    Product::where('id', $item->product_id)
                           ->increment('stock', $item->quantity);
                }
            }
    
            // ✅ আগে cancelled ছিল, এখন অন্য status হলে stock আবার কাটো
            if ($field === 'status' && $order->status === 'cancelled' && $value !== 'cancelled') {
                foreach ($order->orderItems as $item) {
                    Product::where('id', $item->product_id)
                           ->decrement('stock', $item->quantity);
                }
            }
    
            $order->$field = $value;
            $order->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 400);
    }



    public function pendingOrders()
    {
        $orders = Order::where('status', 'pending')->latest()->get();
        return view('admin.orders.pending', compact('orders'));
    }

    public function processingOrders()
    {
        $orders = Order::where('status', 'processing')->latest()->get();
        return view('admin.orders.processing', compact('orders'));
    }

    public function onTheWayOrders()
    {
        $orders = Order::where('status', 'on the way')->latest()->get();
        return view('admin.orders.on-the-way', compact('orders'));
    }

    public function holdOrders()
    {
        $orders = Order::where('status', 'on hold')->latest()->get();
        return view('admin.orders.hold', compact('orders'));
    }

    public function courierOrders()
    {
        $orders = Order::where('status', 'pathao')->orWhere('status','redx')->orWhere('status','steadfast')->latest()->get();
        return view('admin.orders.courier', compact('orders'));
    }

    public function completeOrders()
    {
        $orders = Order::where('status', 'completed')->latest()->get();
        return view('admin.orders.complete', compact('orders'));
    }

    public function cancelledOrders()
    {
        $orders = Order::where('status', 'cancelled')->latest()->get();
        return view('admin.orders.cancelled', compact('orders'));
    }

    // Report
    public function stock_report(Request $request)
    {
        $products = Product::select('id', 'name', 'sale_price', 'stock')
            ->where('status', 1);
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category_id) {
            $products = $products->where('category_id', $request->category_id);
        }
        if ($request->start_date && $request->end_date) {
            $products = $products->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }
        $total_purchase = $products->sum(\DB::raw('purchase_price * stock'));
        $total_stock = $products->sum('stock');
        $total_price = $products->sum(\DB::raw('sale_price * stock'));
        $products = $products->paginate(10);
        $categories = Category::where('status', 1)->get();
        return view('admin.reports.stock', compact('products', 'categories', 'total_purchase', 'total_stock', 'total_price'));
    }


  public function order_report(Request $request)
{
    $users = User::where('status', 1)->get();
    $products = Product::where('status', 1)->orderBy('name')->get();

    $ordersQuery = OrderItem::with(['order', 'order.user', 'product'])
        ->whereHas('order', function ($q) {
            $q->where('status', 'completed');
        });

    // Filter: keyword (order_id)
    if ($request->keyword) {
        $ordersQuery->whereHas('order', function ($q) use ($request) {
            $q->where('order_id', 'LIKE', '%' . $request->keyword . '%');
        });
    }

    // Filter: user
    if ($request->user_id) {
        $ordersQuery->whereHas('order', function ($q) use ($request) {
            $q->where('user_id', $request->user_id);
        });
    }

    // Filter: product
    if ($request->product_id) {
        $ordersQuery->where('product_id', $request->product_id);
    }

    // Filter: date range
    if ($request->start_date && $request->end_date) {
        $ordersQuery->whereHas('order', function ($q) use ($request) {
            $q->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date   . ' 23:59:59',
            ]);
        });
    }

    $allOrders = (clone $ordersQuery)->get();

    $total_purchase = $allOrders->sum(fn($i) => ($i->product->purchase_price ?? 0) * $i->quantity);
    $total_item     = $allOrders->sum('quantity');
    $total_sales    = $allOrders->sum(fn($i) => ($i->price ?? 0) * $i->quantity);

    // Daily summary
    $dailySummary = $allOrders->groupBy(function ($i) {
        return optional($i->order)->created_at?->format('Y-m-d') ?? 'N/A';
    })->map(function ($group, $date) {
        return [
            'date'     => $date,
            'qty'      => $group->sum('quantity'),
            'orders'   => $group->pluck('order_id')->unique()->count(),
            'revenue'  => $group->sum(fn($i) => ($i->price ?? 0) * $i->quantity),
            'purchase' => $group->sum(fn($i) => ($i->product->purchase_price ?? 0) * $i->quantity),
        ];
    })->sortKeys();

    $orders = $ordersQuery->paginate(15);

    return view('admin.reports.order', compact(
        'orders', 'users', 'products',
        'total_purchase', 'total_item', 'total_sales',
        'dailySummary'
    ));
}
}
