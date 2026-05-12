@extends('layouts.app')
@section('title', 'Checkout')

@section('content')

<style>
.checkout-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    background: #fafafa;
}
.checkout-input:focus {
    border-color: #1B3A6B;
    box-shadow: 0 0 0 3px rgba(27,58,107,0.08);
    background: #fff;
}
.section-card {
    background: #fff;
    border-radius: 0.75rem;
    box-shadow: 0 1px 6px rgba(0,0,0,0.07);
    margin-bottom: 1.25rem;
    overflow: hidden;
}
.section-header {
    padding: 0.75rem 1.25rem;
    background: #f9fafb;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.section-header span {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    color: #6b7280;
}
.section-header i { color: #1B3A6B; font-size: 0.75rem; }
.section-body { padding: 1.25rem; }
.cart-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: #f3f4f6;
    border-radius: 999px;
    padding: 0.15rem 0.6rem;
    font-size: 0.7rem;
    font-weight: 600;
    color: #374151;
}
.pay-card {
    flex: 1;
    min-width: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 14px 10px;
    border-radius: 14px;
    border: 2px solid #e5e7eb;
    cursor: pointer;
    transition: border-color .18s, background .18s;
    background: #fff;
    position: relative;
    user-select: none;
}
.pay-card.active-cod   { border-color: #22c55e; background: #f0fdf4; }
.pay-card.active-bkash { border-color: #E2136E; background: #fff0f6; }
.pay-card.active-nagad { border-color: #F6821F; background: #fff7ed; }
.pay-icon {
    width: 44px; height: 44px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 8px;
    font-weight: 700; color: #fff; font-size: 15px;
}
.pay-check {
    position: absolute; top: 8px; right: 8px;
    width: 18px; height: 18px;
    border-radius: 50%;
    display: none;
    align-items: center; justify-content: center;
}
.pay-check svg { width: 10px; height: 10px; }
.pay-info-box {
    border-radius: 12px;
    padding: 14px;
    margin-top: 14px;
    border: 1.5px solid;
    display: none;
}
.pay-number-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 10px;
    border: 1px solid;
}
.trx-input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1.5px solid;
    font-size: 13px;
    outline: none;
    background: #fff;
    box-sizing: border-box;
}
</style>

<main class="bg-gray-50 min-h-screen">
<section class="container mx-auto my-6 md:my-10 px-4 md:px-6 py-4">

    <div class="mb-6 flex items-center gap-3">
        <div class="w-1 h-7 rounded-full" style="background:#1B3A6B;"></div>
        <h1 class="text-2xl font-bold text-gray-800">Checkout</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- LEFT --}}
        <div class="w-full lg:w-[58%]">

            {{-- Contact Info --}}
            <div class="section-card">
                <div class="section-header">
                    <i class="fas fa-user"></i>
                    <span>Contact Information</span>
                </div>
                <div class="section-body space-y-3">
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"><i class="fas fa-user"></i></span>
                        <input id="name" type="text" placeholder="Full Name *" class="checkout-input" />
                    </div>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"><i class="fas fa-phone"></i></span>
                        <input id="phone" type="tel" placeholder="Phone Number *" class="checkout-input" />
                    </div>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"><i class="fas fa-map-marker-alt"></i></span>
                        <input id="address" type="text" placeholder="District, Upazila, Thana, Area *" class="checkout-input" />
                    </div>
                </div>
            </div>

            {{-- Shipping Area --}}
            <div class="section-card">
                <div class="section-header">
                    <i class="fas fa-truck"></i>
                    <span>Shipping Area</span>
                </div>
                <div class="section-body">
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"><i class="fas fa-location-dot"></i></span>
                        <select id="delivery_area"
                            onchange="onShippingChange(this)"
                            class="checkout-input appearance-none pr-8"
                            style="padding-left:2.5rem;">
                            <option value="" disabled selected>-- Select Shipping Area --</option>
                            @foreach($shipingAreas as $area)
                            <option value="{{ $area->text }}|{{ $area->amount }}">
                                {{ $area->text }} — ৳{{ number_format($area->amount, 0) }}
                            </option>
                            @endforeach
                        </select>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div id="shippingInfoBox" class="hidden mt-3 px-4 py-3 rounded-xl text-sm" style="background:#EEF2FF;">
                        <span class="text-gray-500">Delivery charge:</span>
                        <span id="shippingChargeText" class="font-bold ml-1" style="color:#1B3A6B;"></span>
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="section-card">
                <div class="section-header">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment Method</span>
                </div>
                <div class="section-body">

                    <div style="display:flex; gap:10px; flex-wrap:wrap;">

                        {{-- COD --}}
                        <div class="pay-card active-cod" onclick="selectCheckoutPayment('cod', this)">
                            <div class="pay-check" id="chk-cod" style="background:#22c55e; display:flex;">
                                <svg viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="pay-icon" style="background:#22c55e;">
                                <i class="fas fa-money-bill-wave" style="font-size:18px;"></i>
                            </div>
                            <p style="font-weight:700; font-size:12px; color:#111827; line-height:1.2;">Cash on Delivery</p>
                            <p style="font-size:10px; color:#9ca3af; margin-top:2px;">Pay on arrival</p>
                        </div>

                        {{-- bKash --}}
                        <div class="pay-card" onclick="selectCheckoutPayment('bkash', this)">
                            <div class="pay-check" id="chk-bkash" style="background:#E2136E;">
                                <svg viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="pay-icon" style="background:#E2136E;">B</div>
                            <p style="font-weight:700; font-size:12px; color:#111827; line-height:1.2;">bKash</p>
                            <p style="font-size:10px; color:#9ca3af; margin-top:2px;">Mobile banking</p>
                        </div>

                        {{-- Nagad --}}
                        <div class="pay-card" onclick="selectCheckoutPayment('nagad', this)">
                            <div class="pay-check" id="chk-nagad" style="background:#F6821F;">
                                <svg viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="pay-icon" style="background:#F6821F;">N</div>
                            <p style="font-weight:700; font-size:12px; color:#111827; line-height:1.2;">Nagad</p>
                            <p style="font-size:10px; color:#9ca3af; margin-top:2px;">Mobile banking</p>
                        </div>

                    </div>

                    {{-- bKash Info Box --}}
                    <div id="bkash-info-box" class="pay-info-box" style="background:#fff0f6; border-color:#f9a8d4;">
                        <div style="background:#ffe4f0; border:1px solid #f9a8d4; border-radius:10px; padding:12px 14px; margin-bottom:12px;">
                            <div style="display:flex; align-items:flex-start; gap:10px;">
                                <div style="width:28px; height:28px; border-radius:50%; background:#E2136E; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-comment-dots" style="color:#fff; font-size:11px;"></i>
                                </div>
                                <div>
                                    <p style="font-size:12px; font-weight:700; color:#E2136E; margin-bottom:4px;">How to pay via bKash</p>
                                    <p style="font-size:12px; color:#4b5563; line-height:1.6;">
                                        আপনার bKash অ্যাপ থেকে
                                        <strong style="color:#111827;">{{ $item->bkash_number ?? 'N/A' }}</strong>
                                        নম্বরে
                                        <strong style="color:#E2136E;" id="bkash-amount-hint-co">মোট টাকা</strong>
                                        Send Money করুন, তারপর নিচে তথ্য দিন।
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p style="font-size:11px; font-weight:700; color:#E2136E; margin-bottom:8px;">
                            <i class="fas fa-mobile-alt" style="margin-right:4px;"></i>bKash Number:
                        </p>
                        <div class="pay-number-row" style="border-color:#f9a8d4;">
                            <span style="font-weight:700; font-size:14px; color:#111827; letter-spacing:.04em;">{{ $item->bkash_number ?? 'N/A' }}</span>
                            <button type="button" onclick="copyNum('{{ $item->bkash_number ?? '' }}')"
                                style="font-size:11px; font-weight:700; color:#E2136E; background:transparent; border:none; cursor:pointer; display:flex; align-items:center; gap:4px;">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>

                        {{-- Customer bKash number --}}
                        <label style="display:block; font-size:11px; font-weight:700; color:#4b5563; margin-bottom:6px;">
                            আপনার bKash নম্বর <span style="color:#ef4444;">*</span>
                            <span style="font-weight:400; color:#9ca3af; margin-left:4px;">(যে নম্বর থেকে টাকা পাঠিয়েছেন)</span>
                        </label>
                        <div style="position:relative; margin-bottom:10px;">
                            <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:12px;">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="tel" id="co-bkash-payment-number" placeholder="01XXXXXXXXX"
                                class="trx-input" style="border-color:#f9a8d4; padding-left:30px;"
                                onfocus="this.style.borderColor='#E2136E'"
                                onblur="this.style.borderColor='#f9a8d4'" />
                        </div>

                        {{-- TrxID --}}
                        <label style="display:block; font-size:11px; font-weight:700; color:#4b5563; margin-bottom:6px;">
                            Transaction ID <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" id="co-bkash-trx" placeholder="Enter bKash Transaction ID"
                            class="trx-input" style="border-color:#f9a8d4;"
                            onfocus="this.style.borderColor='#E2136E'"
                            onblur="this.style.borderColor='#f9a8d4'" />
                        <p style="font-size:10px; color:#9ca3af; margin-top:6px;">
                            <i class="fas fa-shield-alt" style="margin-right:3px;"></i>
                            Send Money complete হলে TrxID কপি করে এখানে দিন
                        </p>
                    </div>

                    {{-- Nagad Info Box --}}
                    <div id="nagad-info-box" class="pay-info-box" style="background:#fff7ed; border-color:#fed7aa;">
                        <div style="background:#ffe8d0; border:1px solid #fed7aa; border-radius:10px; padding:12px 14px; margin-bottom:12px;">
                            <div style="display:flex; align-items:flex-start; gap:10px;">
                                <div style="width:28px; height:28px; border-radius:50%; background:#F6821F; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-comment-dots" style="color:#fff; font-size:11px;"></i>
                                </div>
                                <div>
                                    <p style="font-size:12px; font-weight:700; color:#F6821F; margin-bottom:4px;">How to pay via Nagad</p>
                                    <p style="font-size:12px; color:#4b5563; line-height:1.6;">
                                        আপনার Nagad অ্যাপ থেকে
                                        <strong style="color:#111827;">{{ $item->nagad_number ?? 'N/A' }}</strong>
                                        নম্বরে
                                        <strong style="color:#F6821F;" id="nagad-amount-hint-co">মোট টাকা</strong>
                                        Send Money করুন, তারপর নিচে তথ্য দিন।
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p style="font-size:11px; font-weight:700; color:#F6821F; margin-bottom:8px;">
                            <i class="fas fa-mobile-alt" style="margin-right:4px;"></i>Nagad Number:
                        </p>
                        <div class="pay-number-row" style="border-color:#fed7aa;">
                            <span style="font-weight:700; font-size:14px; color:#111827; letter-spacing:.04em;">{{ $item->nagad_number ?? 'N/A' }}</span>
                            <button type="button" onclick="copyNum('{{ $item->nagad_number ?? '' }}')"
                                style="font-size:11px; font-weight:700; color:#F6821F; background:transparent; border:none; cursor:pointer; display:flex; align-items:center; gap:4px;">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>

                        {{-- Customer Nagad number --}}
                        <label style="display:block; font-size:11px; font-weight:700; color:#4b5563; margin-bottom:6px;">
                            আপনার Nagad নম্বর <span style="color:#ef4444;">*</span>
                            <span style="font-weight:400; color:#9ca3af; margin-left:4px;">(যে নম্বর থেকে টাকা পাঠিয়েছেন)</span>
                        </label>
                        <div style="position:relative; margin-bottom:10px;">
                            <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:12px;">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="tel" id="co-nagad-payment-number" placeholder="01XXXXXXXXX"
                                class="trx-input" style="border-color:#fed7aa; padding-left:30px;"
                                onfocus="this.style.borderColor='#F6821F'"
                                onblur="this.style.borderColor='#fed7aa'" />
                        </div>

                        {{-- TrxID --}}
                        <label style="display:block; font-size:11px; font-weight:700; color:#4b5563; margin-bottom:6px;">
                            Transaction ID <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" id="co-nagad-trx" placeholder="Enter Nagad Transaction ID"
                            class="trx-input" style="border-color:#fed7aa;"
                            onfocus="this.style.borderColor='#F6821F'"
                            onblur="this.style.borderColor='#fed7aa'" />
                        <p style="font-size:10px; color:#9ca3af; margin-top:6px;">
                            <i class="fas fa-shield-alt" style="margin-right:3px;"></i>
                            Send Money complete হলে TrxID কপি করে এখানে দিন
                        </p>
                    </div>

                </div>
            </div>

            {{-- Terms --}}
            <div class="section-card">
                <div class="section-body py-3">
                    <label class="flex items-start cursor-pointer gap-3">
                        <input type="checkbox" id="co-terms" class="mt-0.5 w-4 h-4" style="accent-color:#1B3A6B;" checked />
                        <span class="text-sm text-gray-500 leading-relaxed">
                            I agree to the
                            <a href="#" class="font-medium hover:underline" style="color:#1B3A6B;">Terms & Conditions</a>,
                            <a href="#" class="font-medium hover:underline" style="color:#1B3A6B;">Refund Policy</a> and
                            <a href="#" class="font-medium hover:underline" style="color:#1B3A6B;">Privacy Policy</a>.
                        </span>
                    </label>
                </div>
            </div>

            {{-- Confirm Button --}}
            <button id="place-order"
                class="w-full text-white font-bold py-4 rounded-xl transition-all text-base shadow-md flex items-center justify-center gap-2"
                style="background:linear-gradient(135deg,#1B3A6B 0%,#0f2347 100%);">
                <i class="fas fa-check-circle"></i> Confirm Order
            </button>
        </div>

        {{-- RIGHT — Order Summary --}}
        <div class="w-full lg:w-[42%]">
            <div class="bg-white rounded-xl shadow-md sticky top-[90px] overflow-hidden">

                <div class="flex justify-between items-center px-5 py-4 border-b border-gray-100"
                    style="background:linear-gradient(135deg,#1B3A6B,#0f2347);">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-white text-sm"></i>
                        <h2 class="font-bold text-white text-sm">Order Summary</h2>
                    </div>
                    <span id="cart-count-badge" class="text-xs font-semibold px-2.5 py-1 rounded-full text-white"
                        style="background:rgba(255,255,255,0.15);">0 items</span>
                </div>

                <div id="cartItems1" class="overflow-y-auto max-h-[380px] p-4 space-y-3 bg-gray-50"></div>

                <div class="px-5 py-4 border-t border-gray-100 space-y-2.5">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span id="cart-total" class="font-semibold text-gray-700">৳ 0</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Delivery Charge</span>
                        <span id="delivery-charge" class="font-semibold text-gray-700">৳ 0</span>
                    </div>
                    <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center">
                        <span class="font-bold text-gray-800">Total Payable</span>
                        <span id="grand-total" class="text-xl font-extrabold" style="color:#E90C66;">৳ 0</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
</main>

@endsection

@section('script')
<script>
$(document).ready(function () {

    let currency              = '৳ ';
    let cart                  = JSON.parse(localStorage.getItem('cart')) || [];
    let deliveryCharge        = 0;
    let deliveryArea          = '';
    let couponAmount          = 0;
    let selectedPaymentMethod = 'cod';

    /* ── Shipping ── */
    window.onShippingChange = function(select) {
        const val = select.value;
        if (!val) return;
        const parts    = val.split('|');
        deliveryArea   = parts[0];
        deliveryCharge = parseFloat(parts[1]);
        document.getElementById('shippingInfoBox').classList.remove('hidden');
        document.getElementById('shippingChargeText').textContent = '৳' + parts[1];
        updateTotals();
    };

    /* ── Payment ── */
    window.selectCheckoutPayment = function(method, el) {
        selectedPaymentMethod = method;
        document.querySelectorAll('.pay-card').forEach(c => {
            c.classList.remove('active-cod', 'active-bkash', 'active-nagad');
            c.style.borderColor = '#e5e7eb';
            c.style.background  = '#fff';
        });
        document.getElementById('chk-cod').style.display    = 'none';
        document.getElementById('chk-bkash').style.display  = 'none';
        document.getElementById('chk-nagad').style.display  = 'none';
        document.getElementById('bkash-info-box').style.display = 'none';
        document.getElementById('nagad-info-box').style.display = 'none';

        if (method === 'cod') {
            el.classList.add('active-cod');
            document.getElementById('chk-cod').style.display = 'flex';
        } else if (method === 'bkash') {
            el.classList.add('active-bkash');
            document.getElementById('chk-bkash').style.display  = 'flex';
            document.getElementById('bkash-info-box').style.display = 'block';
        } else if (method === 'nagad') {
            el.classList.add('active-nagad');
            document.getElementById('chk-nagad').style.display  = 'flex';
            document.getElementById('nagad-info-box').style.display = 'block';
        }
    };

    window.copyNum = function(number) {
        if (!number) return;
        navigator.clipboard.writeText(number)
            .then(() => toastr.success('Number copied: ' + number))
            .catch(() => toastr.error('Could not copy'));
    };

    /* ── Cart ── */
    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(); updateTotals();
    };
    window.decreaseQty = function(index) {
        if (cart[index].quantity > 1) { cart[index].quantity--; }
        else { cart.splice(index, 1); }
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(); updateTotals();
    };
    window.increaseQty = function(index) {
        cart[index].quantity++;
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(); updateTotals();
    };

    function renderCart() {
        $('#cart-count-badge').text(cart.length + (cart.length === 1 ? ' item' : ' items'));
        let html = '';
        if (cart.length === 0) {
            html = `<div class="text-center py-10 text-gray-400">
                        <i class="fas fa-shopping-cart text-3xl mb-3 block"></i>
                        <p class="text-sm">Your cart is empty</p>
                    </div>`;
        } else {
            cart.forEach((item, i) => {
                let badges = '';
                if (item.color) badges += `<span class="cart-badge">${item.color}</span>`;
                if (item.size)  badges += `<span class="cart-badge">${item.size}</span>`;
                html += `
                <div class="bg-white rounded-xl border border-gray-100 p-3 shadow-sm">
                    <div class="flex gap-3">
                        <div class="w-16 h-16 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0 bg-gray-50">
                            <img src="${item.image || ''}" alt="${item.name}" class="w-full h-full object-cover"/>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start gap-2">
                                <h4 class="font-semibold text-sm text-gray-800 leading-tight line-clamp-2 flex-1">${item.name}</h4>
                                <button onclick="removeFromCart(${i})"
                                    class="w-6 h-6 flex-shrink-0 rounded-full bg-red-50 hover:bg-red-100 text-red-500 flex items-center justify-center text-xs">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            ${badges ? `<div class="flex flex-wrap gap-1 mt-1">${badges}</div>` : ''}
                            <div class="flex justify-between items-center mt-2">
                                <div class="flex items-center gap-1 bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                                    <button onclick="decreaseQty(${i})" class="w-7 h-7 flex items-center justify-content text-gray-500 hover:bg-gray-100 font-bold text-sm">&minus;</button>
                                    <span class="w-7 text-center text-sm font-bold text-gray-800">${item.quantity}</span>
                                    <button onclick="increaseQty(${i})" class="w-7 h-7 flex items-center justify-content text-gray-500 hover:bg-gray-100 font-bold text-sm">&#43;</button>
                                </div>
                                <span class="font-bold text-sm" style="color:#1B3A6B;">${currency}${(item.price * item.quantity).toFixed(2)}</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        }
        $('#cartItems1').html(html);
    }

    function updateTotals() {
        let total   = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        let payable = Math.max(0, total + deliveryCharge - couponAmount);

        $('#cart-total').text(currency + total.toFixed(2));
        $('#delivery-charge').text(currency + deliveryCharge.toFixed(2));
        $('#grand-total').text(currency + payable.toFixed(2));

        const hint = '৳' + Math.round(payable);
        const bEl  = document.getElementById('bkash-amount-hint-co');
        const nEl  = document.getElementById('nagad-amount-hint-co');
        if (bEl) bEl.textContent = hint;
        if (nEl) nEl.textContent = hint;
    }

    setInterval(function () {
        let updated = JSON.parse(localStorage.getItem('cart')) || [];
        if (JSON.stringify(updated) !== JSON.stringify(cart)) {
            cart = updated; renderCart(); updateTotals();
        }
    }, 1000);

    renderCart();
    updateTotals();

    /* ── Place Order ── */
    $('#place-order').click(function () {
        if (cart.length === 0) { toastr.error('Your cart is empty!'); return; }

        const name    = $('#name').val().trim();
        const phone   = $('#phone').val().trim();
        const address = $('#address').val().trim();
        const terms   = document.getElementById('co-terms').checked;

        if (!name)         { toastr.warning('Please enter your name');            return; }
        if (!phone)        { toastr.warning('Please enter phone number');          return; }
        if (!address)      { toastr.warning('Please enter your address');          return; }
        if (!deliveryArea) { toastr.warning('Please select a shipping area');      return; }
        if (!terms)        { toastr.warning('Please agree to terms & conditions'); return; }

        let transactionId = '';
        let paymentNumber = '';

        if (selectedPaymentMethod === 'bkash') {
            paymentNumber = document.getElementById('co-bkash-payment-number').value.trim();
            transactionId = document.getElementById('co-bkash-trx').value.trim();
            if (!paymentNumber) { toastr.warning('আপনার bKash নম্বর দিন');    return; }
            if (!transactionId) { toastr.warning('bKash Transaction ID দিন'); return; }
        }
        if (selectedPaymentMethod === 'nagad') {
            paymentNumber = document.getElementById('co-nagad-payment-number').value.trim();
            transactionId = document.getElementById('co-nagad-trx').value.trim();
            if (!paymentNumber) { toastr.warning('আপনার Nagad নম্বর দিন');    return; }
            if (!transactionId) { toastr.warning('Nagad Transaction ID দিন'); return; }
        }

        let total   = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        let payable = Math.max(0, total + deliveryCharge - couponAmount);

        let orderItems = cart.map(item => ({
            productId  : item.productId || item.id || item.product_id,
            id         : item.productId || item.id || item.product_id,
            variant_id : item.variantId || item.variant_id || null,
            quantity   : item.quantity,
            price      : item.price,
            name       : item.name,
            image      : item.image,
            color      : item.color  || '',
            size       : item.size   || '',
            brand      : item.brand  || '',
        }));

        let orderData = {
            _token          : '{{ csrf_token() }}',
            customer_name   : name,
            phone           : phone,
            address         : address,
            delivery_area   : deliveryArea,
            delivery_charge : deliveryCharge,
            payment_method  : selectedPaymentMethod,
            transaction_id  : transactionId,
            payment_number  : paymentNumber,
            coupon_code     : '',
            coupon_amount   : couponAmount.toFixed(2),
            coupon_point    : 0,
            items           : orderItems,
            total           : payable.toFixed(2),
        };

        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');

        $.post('{{ route("order.store") }}', orderData, function (res) {
            if (res.success) {
                localStorage.removeItem('cart');
                toastr.success('Order placed successfully!');
                window.location.href = '/success/' + res.id;
            }
        }).fail(function (xhr) {
            toastr.error('Order failed: ' + (xhr.responseJSON?.message || 'Unknown error'));
            $('#place-order').prop('disabled', false).html('<i class="fas fa-check-circle"></i> Confirm Order');
        });
    });

});
</script>
@endsection