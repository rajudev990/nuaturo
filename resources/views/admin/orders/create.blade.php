@extends('admin.layouts.app')
@section('title', 'Create Order')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap');
:root{ --p1:#5b21b6;--p2:#7c3aed;--p3:#ede9fe;--p4:#4c1d95;--ink:#0f0e17;--muted:#6b6b8a;--border:#e4e1f5;--surf:#f4f2ff;--green:#059669;--red:#dc2626;--r:12px; }
*{ font-family:'Sora',sans-serif;box-sizing:border-box; }
.mono{ font-family:'JetBrains Mono',monospace; }

.cpg{ background:var(--surf);min-height:100vh;padding:28px 16px; }
.cwrap{ max-width:1100px;margin:0 auto;display:flex;flex-direction:column;gap:20px; }

/* top bar */
.cbar{ display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px; }
.cbar-title{ font-size:21px;font-weight:700;color:var(--ink);display:flex;align-items:center;gap:10px; }
.btn-back{ background:#fff;border:1.5px solid var(--border);color:var(--ink);border-radius:10px;padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .15s; }
.btn-back:hover{ border-color:var(--p2);color:var(--p2);background:var(--p3); }

/* section box */
.sbox{ background:#fff;border:1px solid var(--border);border-radius:18px;overflow:hidden;box-shadow:0 2px 20px rgba(91,33,182,.06); }
.shead{ background:linear-gradient(120deg,#f5f3ff,#ede9fe);padding:14px 22px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center; }
.shead-title{ font-size:13px;font-weight:700;color:var(--p4);display:flex;align-items:center;gap:8px; }
.shead-icon{ width:28px;height:28px;border-radius:8px;background:var(--p2);display:flex;align-items:center;justify-content:center;font-size:12px;color:#fff; }
.sbody{ padding:22px; }

/* form */
.flabel{ display:block;font-size:11.5px;font-weight:700;color:var(--muted);margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px; }
.finput{ width:100%;border:1.5px solid var(--border);border-radius:10px;padding:10px 14px;font-size:13.5px;color:var(--ink);outline:none;transition:border .15s,box-shadow .15s;background:#fff;font-family:'Sora',sans-serif; }
.finput:focus{ border-color:var(--p2);box-shadow:0 0 0 3px rgba(124,58,237,.1); }
.finput::placeholder{ color:#c4b5fd; }

/* customer toggle */
.ctab{ display:flex;gap:0;border:1.5px solid var(--border);border-radius:10px;overflow:hidden;margin-bottom:20px; }
.ctab-btn{ flex:1;padding:10px;font-size:13px;font-weight:600;border:none;cursor:pointer;background:#fff;color:var(--muted);transition:all .15s; }
.ctab-btn.active{ background:linear-gradient(135deg,var(--p2),var(--p4));color:#fff; }

/* product row */
.prod-row{ background:#faf7ff;border:1px solid var(--border);border-radius:var(--r);padding:16px;margin-bottom:12px;transition:box-shadow .15s; }
.prod-row:hover{ box-shadow:0 2px 12px rgba(124,58,237,.1); }
.btn-add-prod{ background:var(--p3);color:var(--p2);border:none;border-radius:9px;padding:9px 16px;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .15s; }
.btn-add-prod:hover{ background:var(--p2);color:#fff; }
.btn-remove{ background:#fde8e8;color:var(--red);border:none;border-radius:8px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .15s;flex-shrink:0; }
.btn-remove:hover{ background:var(--red);color:#fff; }

/* summary */
.sum-row{ display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);font-size:13px; }
.sum-row:last-child{ border-bottom:none; }
.sum-lbl{ color:var(--muted);font-weight:600; }
.sum-val{ font-family:'JetBrains Mono',monospace;font-weight:700;color:var(--ink); }
.sum-row.grand{ background:linear-gradient(135deg,var(--p2),var(--p4));margin:10px -22px -22px;padding:16px 22px;border-radius:0 0 18px 18px; }
.sum-row.grand .sum-lbl, .sum-row.grand .sum-val{ color:#fff;font-size:15px; }

/* submit */
.btn-submit{ width:100%;background:linear-gradient(135deg,var(--p2),var(--p4));color:#fff;border:none;border-radius:12px;padding:14px;font-size:15px;font-weight:700;cursor:pointer;margin-top:14px;box-shadow:0 4px 16px rgba(124,58,237,.35);transition:all .15s;display:flex;align-items:center;justify-content:center;gap:8px; }
.btn-submit:hover{ transform:translateY(-1px);box-shadow:0 6px 22px rgba(124,58,237,.4); }

.no-prod{ text-align:center;padding:28px;color:var(--muted);font-size:13px; }
.no-prod i{ display:block;font-size:28px;color:#ddd6fe;margin-bottom:10px; }
</style>

<div class="cpg">
<div class="cwrap">

    {{-- TOP BAR --}}
    <div class="cbar">
        <div class="cbar-title">
            <i class="fa fa-plus-circle" style="color:var(--p2);"></i>
            Create New Order
        </div>
        <a href="{{ route('admin.all-orders') }}" class="btn-back">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
    @csrf
    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-lg-8">

            {{-- CUSTOMER --}}
            <div class="sbox mb-4">
                <div class="shead">
                    <div class="shead-title">
                        <span class="shead-icon"><i class="fa fa-user"></i></span>
                        Customer Info
                    </div>
                </div>
                <div class="sbody">

                    {{-- Toggle: existing vs manual --}}
                    <div class="ctab">
                        <button type="button" class="ctab-btn active" id="tabExist" onclick="switchTab('exist')">
                            <i class="fa fa-search me-1"></i> Existing Customer
                        </button>
                        <button type="button" class="ctab-btn" id="tabManual" onclick="switchTab('manual')">
                            <i class="fa fa-pen me-1"></i> Manual Entry
                        </button>
                    </div>

                    {{-- Existing customer --}}
                    <div id="existBlock">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="flabel">Select Customer</label>
                                <select name="user_id" id="customerSelect" class="finput">
                                    <option value="">-- Select Customer --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            data-phone="{{ $user->phone }}"
                                            data-email="{{ $user->email }}"
                                            data-address="{{ $user->address }}">
                                            {{ $user->name }} — {{ $user->phone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="flabel">Phone</label>
                                <input type="text" id="cPhone" class="finput" readonly placeholder="Auto-filled">
                            </div>
                            <div class="col-md-4">
                                <label class="flabel">Email</label>
                                <input type="text" id="cEmail" class="finput" readonly placeholder="Auto-filled">
                            </div>
                            <div class="col-md-4">
                                <label class="flabel">Address</label>
                                <input type="text" id="cAddress" class="finput" readonly placeholder="Auto-filled">
                            </div>
                        </div>
                    </div>

                    {{-- Manual entry --}}
                    <div id="manualBlock" style="display:none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="flabel">Full Name <span style="color:var(--red);">*</span></label>
                                <input type="text" name="manual_name" class="finput" placeholder="Customer name">
                            </div>
                            <div class="col-md-6">
                                <label class="flabel">Phone <span style="color:var(--red);">*</span></label>
                                <input type="text" name="manual_phone" class="finput mono" placeholder="01XXXXXXXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="flabel">Email</label>
                                <input type="email" name="manual_email" class="finput" placeholder="email@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="flabel">Address</label>
                                <input type="text" name="manual_address" class="finput" placeholder="Delivery address">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- PRODUCTS --}}
            <div class="sbox mb-4">
                <div class="shead">
                    <div class="shead-title">
                        <span class="shead-icon"><i class="fa fa-box"></i></span>
                        Order Items
                    </div>
                    <button type="button" class="btn-add-prod" id="addProdBtn">
                        <i class="fa fa-plus"></i> Add Product
                    </button>
                </div>
                <div class="sbody">
                    <div id="prodRows">
                        <div class="no-prod" id="noProdMsg">
                            <i class="fa fa-box-open"></i>
                            Click "Add Product" to add items to this order
                        </div>
                    </div>
                    <template id="prodTpl">
                        <div class="prod-row">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-5">
                                    <label class="flabel">Product</label>
                                    <select name="products[]" class="finput prod-select">
                                        <option value="">-- Select Product --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">
                                                {{ $product->name }} ({{ currency() }}{{ number_format($product->sale_price,2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Price</label>
                                    <input type="text" class="finput mono prod-price" readonly placeholder="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Qty</label>
                                    <input type="number" class="finput mono prod-qty" min="1" value="1">
                                </div>
                                <div class="col-md-2">
                                    <label class="flabel">Subtotal</label>
                                    <input type="text" class="finput mono prod-sub" readonly placeholder="0.00" style="color:var(--p2);font-weight:700;">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn-remove w-100 rm-btn"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- NOTE --}}
            <div class="sbox">
                <div class="shead">
                    <div class="shead-title"><span class="shead-icon"><i class="fa fa-sticky-note"></i></span>Note</div>
                </div>
                <div class="sbody">
                    <textarea name="note" class="finput" rows="3" placeholder="Special instructions...">{{ old('note') }}</textarea>
                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-4">

            {{-- PAYMENT --}}
            <div class="sbox mb-4">
                <div class="shead">
                    <div class="shead-title"><span class="shead-icon"><i class="fa fa-credit-card"></i></span>Payment</div>
                </div>
                <div class="sbody">
                    <div class="mb-3">
                        <label class="flabel">Payment Method</label>
                        <select name="payment_method" class="finput">
                            <option value="cod">Cash on Delivery</option>
                            <option value="bkash">bKash</option>
                            <option value="nagad">Nagad</option>
                        </select>
                    </div>
                   <div class="mb-3">
                        <label class="flabel">Transaction Number</label>
                        <input 
                            type="text" 
                            name="transaction_id"  
                            class="finput mono" 
                            placeholder="C3K2C8A1EU"
                        >
                    </div>
                    
                    <div class="mb-3">
                        <label class="flabel">Payment Number</label>
                        <input 
                            type="text" 
                            name="payment_number"  
                            class="finput mono" 
                            placeholder="01XXXXXXXXX"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="flabel">Delivery Charge (৳)</label>
                        <input type="number" name="delivery_charge" id="deliveryCharge" class="finput mono" min="0" value="0" placeholder="0">
                    </div>
                    <div>
                        <label class="flabel">Paid Amount (৳)</label>
                        <input type="number" name="paid" class="finput mono" min="0" value="0" placeholder="0">
                    </div>
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="sbox">
                <div class="shead">
                    <div class="shead-title"><span class="shead-icon"><i class="fa fa-calculator"></i></span>Summary</div>
                </div>
                <div class="sbody">
                    <div class="sum-row">
                        <span class="sum-lbl">Subtotal</span>
                        <span class="sum-val" id="sumSub">{{ currency() }}0.00</span>
                    </div>
                    <div class="sum-row">
                        <span class="sum-lbl">Delivery</span>
                        <span class="sum-val" id="sumDel">{{ currency() }}0.00</span>
                    </div>
                    <div class="sum-row grand">
                        <span class="sum-lbl">Grand Total</span>
                        <span class="sum-val" id="sumTotal">{{ currency() }}0.00</span>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fa fa-check-circle"></i> Create Order
                    </button>
                </div>
            </div>

        </div>
    </div>
    </form>

</div>
</div>

<script>
// Customer tab toggle
function switchTab(tab) {
    const isExist = tab === 'exist';
    document.getElementById('tabExist').classList.toggle('active', isExist);
    document.getElementById('tabManual').classList.toggle('active', !isExist);
    document.getElementById('existBlock').style.display  = isExist ? '' : 'none';
    document.getElementById('manualBlock').style.display = isExist ? 'none' : '';
    document.getElementById('customerSelect').required = isExist;
}

// Customer auto-fill
document.getElementById('customerSelect').addEventListener('change', function() {
    const o = this.options[this.selectedIndex];
    document.getElementById('cPhone').value   = o.dataset.phone   || '';
    document.getElementById('cEmail').value   = o.dataset.email   || '';
    document.getElementById('cAddress').value = o.dataset.address || '';
});

// Add product row
document.getElementById('addProdBtn').addEventListener('click', () => {
    const tpl   = document.getElementById('prodTpl');
    const clone = tpl.content.cloneNode(true);
    document.getElementById('prodRows').appendChild(clone);
    document.getElementById('noProdMsg').style.display = 'none';
    bindRow(document.querySelector('#prodRows .prod-row:last-child'));
    updateQtyNames();
});

function bindRow(row) {
    const sel  = row.querySelector('.prod-select');
    const prEl = row.querySelector('.prod-price');
    const qtEl = row.querySelector('.prod-qty');
    const sbEl = row.querySelector('.prod-sub');
    const rmBtn = row.querySelector('.rm-btn');

    sel.addEventListener('change', () => {
        const opt   = sel.options[sel.selectedIndex];
        const price = parseFloat(opt.dataset.price || 0);
        prEl.value  = price.toFixed(2);
        sbEl.value  = (price * parseInt(qtEl.value || 1)).toFixed(2);
        updateQtyNames(); calc();
    });
    qtEl.addEventListener('input', () => {
        sbEl.value = (parseFloat(prEl.value||0) * parseInt(qtEl.value||1)).toFixed(2);
        calc();
    });
    rmBtn.addEventListener('click', () => {
        row.remove();
        if (!document.querySelectorAll('#prodRows .prod-row').length)
            document.getElementById('noProdMsg').style.display = '';
        updateQtyNames(); calc();
    });
}

function updateQtyNames() {
    document.querySelectorAll('#prodRows .prod-row').forEach(row => {
        const sel = row.querySelector('.prod-select');
        const qty = row.querySelector('.prod-qty');
        if (sel.value) qty.name = `quantities[${sel.value}]`;
    });
}

function calc() {
    let sub = 0;
    document.querySelectorAll('#prodRows .prod-sub').forEach(el => sub += parseFloat(el.value||0));
    const del = parseFloat(document.getElementById('deliveryCharge').value||0);
    const sym = '{{ currency() }}';
    document.getElementById('sumSub').textContent   = sym + sub.toFixed(2);
    document.getElementById('sumDel').textContent   = sym + del.toFixed(2);
    document.getElementById('sumTotal').textContent = sym + (sub+del).toFixed(2);
}
document.getElementById('deliveryCharge').addEventListener('input', calc);
</script>
@endsection