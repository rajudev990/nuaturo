@extends('admin.layouts.app')

@section('title', 'Edit Order #{{ $order->order_id }}')

@section('content')
<section class="py-4 min-vh-100" style="background:#f4f0ff;">
<div class="container-fluid px-3 px-md-4">
<div class="card border-0 overflow-hidden" style="border-radius:16px;box-shadow:0 8px 40px rgba(109,40,217,0.13);">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center py-3 px-4"
        style="background:linear-gradient(135deg,#6d28d9 0%,#4c1d95 100%);border:none;">
        <h5 class="mb-0 text-white fw-semibold d-flex align-items-center gap-2">
            <span style="width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,0.15);
                         display:flex;align-items:center;justify-content:center;">
                <i class="fa fa-edit" style="font-size:15px;"></i>
            </span>
            Edit Order &nbsp;<span style="opacity:.7;font-size:13px;">#{{ $order->order_id }}</span>
        </h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm fw-semibold px-3"
                style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:8px;">
                <i class="fa fa-eye me-1"></i> View
            </a>
            <a href="{{ route('admin.all-orders') }}" class="btn btn-sm fw-semibold px-3"
                style="background:#fff;color:#6d28d9;border:none;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body p-4" style="background:#fff;">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" id="orderForm">
            @csrf
            @method('PUT')

            <div class="row g-4">

                <!-- LEFT COLUMN -->
                <div class="col-lg-8">

                    <!-- Customer -->
                    <div class="section-box mb-4">
                        <div class="section-title"><i class="fa fa-user me-2"></i>Customer Info</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="flabel">Select Customer <span class="text-danger">*</span></label>
                                <select name="user_id" class="form-select purple-input" required id="customerSelect">
                                    <option value="">-- Select Customer --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            data-phone="{{ $user->phone }}"
                                            data-address="{{ $user->address }}"
                                            {{ $order->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} — {{ $user->phone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="flabel">Phone</label>
                                <input type="text" id="customerPhone" class="form-control purple-input" readonly
                                    value="{{ $order->user->phone ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="flabel">Address</label>
                                <input type="text" id="customerAddress" class="form-control purple-input" readonly
                                    value="{{ $order->user->address ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="section-box mb-4">
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-box me-2"></i>Order Items</span>
                            <button type="button" id="addProductBtn" class="btn btn-sm"
                                style="background:#ede9fe;color:#6d28d9;border:none;border-radius:8px;font-weight:600;">
                                <i class="fa fa-plus me-1"></i> Add Product
                            </button>
                        </div>

                        <div id="productRows">
                            @foreach($order->orderItems as $item)
                            <div class="product-row row g-2 align-items-end mb-3 p-3"
                                style="background:#faf7ff;border-radius:12px;border:1px solid #ede9fe;">
                                <div class="col-md-5">
                                    <label class="flabel">Product <span class="text-danger">*</span></label>
                                    <select name="products[]" class="form-select purple-input product-select" required>
                                        <option value="">-- Select Product --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-price="{{ $product->sale_price }}"
                                                data-stock="{{ $product->stock }}"
                                                {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} — {{ currency() }}{{ number_format($product->sale_price,2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Price</label>
                                    <input type="text" class="form-control purple-input product-price"
                                        readonly value="{{ number_format($item->price, 2) }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Qty <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control purple-input product-qty"
                                        name="quantities[{{ $item->product_id }}]"
                                        min="1" value="{{ $item->quantity }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Subtotal</label>
                                    <input type="text" class="form-control purple-input product-subtotal"
                                        readonly value="{{ number_format($item->quantity * $item->price, 2) }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm remove-row-btn w-100"
                                        style="background:#fde8e8;color:#dc2626;border:none;border-radius:8px;height:38px;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <template id="productRowTemplate">
                            <div class="product-row row g-2 align-items-end mb-3 p-3"
                                style="background:#faf7ff;border-radius:12px;border:1px solid #ede9fe;">
                                <div class="col-md-5">
                                    <label class="flabel">Product <span class="text-danger">*</span></label>
                                    <select name="products[]" class="form-select purple-input product-select" required>
                                        <option value="">-- Select Product --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-price="{{ $product->sale_price }}"
                                                data-stock="{{ $product->stock }}">
                                                {{ $product->name }} — {{ currency() }}{{ number_format($product->sale_price,2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Price</label>
                                    <input type="text" class="form-control purple-input product-price" readonly placeholder="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Qty <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control purple-input product-qty" min="1" value="1" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Subtotal</label>
                                    <input type="text" class="form-control purple-input product-subtotal" readonly placeholder="0.00">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm remove-row-btn w-100"
                                        style="background:#fde8e8;color:#dc2626;border:none;border-radius:8px;height:38px;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <div id="noProductMsg" class="text-center py-4"
                            style="color:#9ca3af;font-size:13px;{{ $order->orderItems->count() ? 'display:none;' : '' }}">
                            <i class="fa fa-box-open mb-2" style="font-size:28px;color:#ddd6fe;display:block;"></i>
                            Click "Add Product" to add items
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="section-box">
                        <div class="section-title"><i class="fa fa-sticky-note me-2"></i>Note</div>
                        <textarea name="notes" class="form-control purple-input" rows="3"
                            placeholder="Any special instructions...">{{ $order->notes }}</textarea>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">

                    <!-- Payment -->
                    <div class="section-box mb-4">
                        <div class="section-title"><i class="fa fa-credit-card me-2"></i>Payment Info</div>

                        <div class="mb-3">
                            <label class="flabel">Payment Method</label>
                            <select name="payment_method" class="form-select purple-input">
                                <option value="cash"  {{ $order->payment_method=='cod'  ?'selected':'' }}>Cash on Delivery</option>
                                <option value="bkash" {{ $order->payment_method=='bkash' ?'selected':'' }}>bKash</option>
                                <option value="nagad" {{ $order->payment_method=='nagad' ?'selected':'' }}>Nagad</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="flabel">Delivery Charge</label>
                            <input type="number" name="delivery_charge" id="deliveryCharge"
                                class="form-control purple-input" min="0"
                                value="{{ $order->delivery_charge ?? 0 }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="flabel">Transaction Number</label>
                            <input type="text" name="transaction_id" id="transaction_id"
                                class="form-control purple-input" min="0"
                                value="{{ $order->transaction_id ?? 0 }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="flabel">Payment Number</label>
                            <input type="text" name="payment_number" id="payment_number"
                                class="form-control purple-input" min="0"
                                value="{{ $order->payment_number ?? 0 }}">
                        </div>
                

                        <div class="mb-3">
                            <label class="flabel">Paid Amount</label>
                            <input type="number" name="paid" class="form-control purple-input"
                                min="0" value="{{ $order->paid ?? 0 }}">
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="section-box" style="background:#faf7ff;">
                        <div class="section-title"><i class="fa fa-calculator me-2"></i>Order Summary</div>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="summarySubtotal">{{ currency() }}0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery Charge</span>
                            <span id="summaryDelivery">{{ currency() }}{{ number_format($order->delivery_charge ?? 0, 2) }}</span>
                        </div>
                        <div class="summary-row" style="border-top:2px solid #ddd6fe;margin-top:10px;padding-top:12px;">
                            <strong>Grand Total</strong>
                            <strong id="summaryTotal" style="color:#6d28d9;font-size:16px;">
                                {{ currency() }}{{ number_format($order->total, 2) }}
                            </strong>
                        </div>

                        <button type="submit" class="btn w-100 mt-4 fw-bold"
                            style="background:linear-gradient(135deg,#6d28d9,#4c1d95);color:#fff;
                                   border:none;border-radius:10px;padding:12px;font-size:15px;
                                   box-shadow:0 4px 16px rgba(109,40,217,0.3);">
                            <i class="fa fa-save me-2"></i> Update Order
                        </button>
                    </div>

                </div>
            </div><!-- /row -->
        </form>
    </div>
</div>
</div>
</section>
@endsection

@section('script')
<style>
    .flabel { display:block;font-size:12px;font-weight:600;color:#5b21b6;margin-bottom:4px;letter-spacing:0.3px; }
    .purple-input { border-color:#ddd6fe !important;border-radius:8px !important; }
    .purple-input:focus { border-color:#7c3aed !important;box-shadow:0 0 0 3px rgba(124,58,237,0.12) !important; }
    .section-box { background:#fff;border:1px solid #ede9fe;border-radius:14px;padding:20px; }
    .section-title { font-size:14px;font-weight:700;color:#4c1d95;margin-bottom:16px;padding-bottom:10px;border-bottom:1px solid #ede9fe; }
    .summary-row { display:flex;justify-content:space-between;align-items:center;font-size:13.5px;padding:6px 0;color:#374151; }
</style>

<script>
// Customer auto-fill
document.getElementById('customerSelect').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    document.getElementById('customerPhone').value   = opt.dataset.phone   || '';
    document.getElementById('customerAddress').value = opt.dataset.address || '';
});

// Bind existing rows on load
document.querySelectorAll('#productRows .product-row').forEach(row => bindRowEvents(row));

// Calc summary on load
calcSummary();

// Add product row
document.getElementById('addProductBtn').addEventListener('click', function() {
    const template = document.getElementById('productRowTemplate');
    const clone    = template.content.cloneNode(true);
    document.getElementById('productRows').appendChild(clone);
    document.getElementById('noProductMsg').style.display = 'none';
    bindRowEvents(document.querySelector('#productRows .product-row:last-child'));
    updateQuantityNames();
});

function bindRowEvents(row) {
    const select    = row.querySelector('.product-select');
    const priceEl   = row.querySelector('.product-price');
    const qtyEl     = row.querySelector('.product-qty');
    const subEl     = row.querySelector('.product-subtotal');
    const removeBtn = row.querySelector('.remove-row-btn');

    select.addEventListener('change', function() {
        const opt   = this.options[this.selectedIndex];
        const price = parseFloat(opt.dataset.price || 0);
        priceEl.value = price.toFixed(2);
        subEl.value   = (price * parseInt(qtyEl.value || 1)).toFixed(2);
        updateQuantityNames();
        calcSummary();
    });

    qtyEl.addEventListener('input', function() {
        const price = parseFloat(priceEl.value || 0);
        subEl.value = (price * parseInt(this.value || 1)).toFixed(2);
        calcSummary();
    });

    removeBtn.addEventListener('click', function() {
        row.remove();
        const rows = document.querySelectorAll('#productRows .product-row');
        if (rows.length === 0) document.getElementById('noProductMsg').style.display = '';
        updateQuantityNames();
        calcSummary();
    });
}

function updateQuantityNames() {
    document.querySelectorAll('#productRows .product-row').forEach(row => {
        const select = row.querySelector('.product-select');
        const qty    = row.querySelector('.product-qty');
        const pid    = select.value;
        if (pid) qty.name = `quantities[${pid}]`;
    });
}

function calcSummary() {
    let subtotal = 0;
    document.querySelectorAll('#productRows .product-subtotal').forEach(el => {
        // comma remove করে parse করো
        const val = parseFloat(el.value.replace(/,/g, '') || 0);
        subtotal += val;
    });
    const delivery = parseFloat(document.getElementById('deliveryCharge').value || 0);
    const sym      = '{{ currency() }}';
    document.getElementById('summarySubtotal').textContent = sym + subtotal.toFixed(2);
    document.getElementById('summaryDelivery').textContent = sym + delivery.toFixed(2);
    document.getElementById('summaryTotal').textContent    = sym + (subtotal + delivery).toFixed(2);
}

document.getElementById('deliveryCharge').addEventListener('input', calcSummary);
</script>
@endsection