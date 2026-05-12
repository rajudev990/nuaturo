@extends('layouts.app')
@section('title', $item->slug)

@section('content')

<style>
/* ─── Inline Checkout ───────────────────────────────── */
.ic-area-btn.selected { border-color:#1B3A6B !important; background:#eef1f8; }
.ic-area-btn.selected .ic-radio-dot { border-color:#1B3A6B !important; }
.ic-area-btn.selected .ic-radio-fill { background:#1B3A6B !important; }

/* ─── Swiper Equal Height Slides ────────────────────── */
.relatedProductsSwiper .swiper-wrapper { align-items: stretch; }
.relatedProductsSwiper .swiper-slide   { height: auto; }

/* ─── Swiper Nav Buttons ─────────────────────────────── */
.nav-swiper-btn {
    width:36px!important; height:36px!important;
    background:#fff; border:1px solid #e5e7eb!important;
    border-radius:50%!important;
    display:flex!important; align-items:center!important; justify-content:center!important;
    color:#374151; cursor:pointer;
    transition:border-color .15s,color .15s,box-shadow .15s;
    top:50%; transform:translateY(-50%);
    box-shadow:0 1px 4px rgba(0,0,0,.06);
}
.nav-swiper-btn::after { display:none!important; }
.nav-swiper-btn:hover  { border-color:#1B3A6B!important; color:#1B3A6B; box-shadow:0 2px 8px rgba(27,58,107,.15); }
.swiper-button-disabled.nav-swiper-btn { opacity:.3; pointer-events:none; }

/* ─── Image Zoom ─────────────────────────────────────── */
.img-zoom-wrap {
    position:relative; overflow:hidden;
    cursor:crosshair; border-radius:.5rem; background:#f9fafb;
}
.img-zoom-wrap img {
    display:block; width:100%; height:100%; object-fit:contain;
    transition:transform .08s ease; will-change:transform;
}
.img-zoom-wrap:hover img { transform:scale(2.2); }

/* ─── Thumbnail ──────────────────────────────────────── */
.thumb-item { transition:border-color .15s,box-shadow .15s; }
.thumb-item.active, .thumb-item:hover {
    border-color:#1B3A6B!important;
    box-shadow:0 0 0 2px rgba(27,58,107,.2);
}

/* ─── Price ──────────────────────────────────────────── */
.price-regular { text-decoration:line-through; color:#9ca3af; font-size:1rem; }
.price-sale    { font-size:28px; font-weight:800; color:#111827; letter-spacing:-.5px; line-height:1; }

/* ─── Qty ────────────────────────────────────────────── */
.qty-btn {
    width:40px; height:40px;
    display:flex; align-items:center; justify-content:center;
    font-size:1.1rem; font-weight:700;
    background:#f3f4f6; cursor:pointer;
    transition:background .15s; border:none; outline:none; user-select:none;
}
.qty-btn:hover { background:#e5e7eb; }
.qty-input {
    width:52px; height:40px; text-align:center;
    border:none; font-weight:600; font-size:.95rem;
    background:#fff; outline:none;
}
.sec-divider { border:none; border-top:1px solid #f1f5f9; margin:1.1rem 0; }

/* ─── Quick Order FAB ────────────────────────────────── */
.quick-order-fab {
    position:fixed; bottom:24px; right:24px;
    z-index:999;
    background:linear-gradient(135deg,#1B3A6B 0%,#0f2347 100%);
    color:#fff;
    border:none; border-radius:50px;
    padding:14px 22px;
    font-weight:700; font-size:.9rem;
    cursor:pointer;
    box-shadow:0 8px 24px rgba(27,58,107,.4);
    display:none; align-items:center; gap:8px;
    transition:transform .2s, box-shadow .2s;
}
.quick-order-fab:hover { transform:translateY(-2px); box-shadow:0 12px 32px rgba(27,58,107,.5); }
</style>

{{-- ── Variant JSON ──────────────────────────────────── --}}
@php
$variantData = $item->variants->map(fn($v) => [
    'color_id'  => $v->color_id,
    'color'     => $v->color?->name,
    'size_id'   => $v->size_id,
    'size'      => $v->size?->name,
    'size_desc' => $v->size?->description,
    'price'     => $v->price,
    'stock'     => $v->stock,
]);
$regularPrice = $item->regular_price;
$salePrice    = $item->sale_price;
$discountPct  = $regularPrice > 0 ? round((($regularPrice - $salePrice) / $regularPrice) * 100) : 0;
$totalStock   = $item->variants->sum('stock');
$hasVariants  = $item->variants->count() > 0;

$phone = preg_replace('/[^0-9]/', '', $setting->phone_one ?? '');
$phone = preg_replace('/^880/', '', $phone);
$phone = ltrim($phone, '0');
$whatsappNumber = '880' . $phone;
$fbUrl = $setting->facebook_page ?? '';
$fbUsername = preg_replace('/^https?:\/\/(www\.)?facebook\.com\/?/', '', rtrim($fbUrl, '/'));
@endphp
<script>const allVariants = @json($variantData);</script>

<main class="w-full bg-gray-50 min-h-screen">

    {{-- ── Breadcrumb ──────────────────────────────────── --}}
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 md:px-8 py-3">
            <nav class="flex items-center text-xs text-gray-400 gap-1.5 flex-wrap">
                <a href="/" class="hover:text-[#1B3A6B] transition-colors">Home</a>
                <span>/</span>
                @if($item->category)
                <a href="{{ route('products', ['category' => $item->category->id]) }}"
                    class="hover:text-[#1B3A6B] transition-colors">{{ $item->category->name }}</a>
                <span>/</span>
                @endif
                <span class="text-gray-700 font-medium truncate max-w-[200px]">{{ $item->name }}</span>
            </nav>
        </div>
    </div>

    {{-- ── Product Detail ──────────────────────────────── --}}
    <section class="container mx-auto px-4 md:px-8 py-8 md:py-12">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-10 mb-8">

            {{-- ══ LEFT — Images ══ --}}
            <div class="w-full lg:w-[42%] flex-shrink-0">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-3 relative">
                    @if($discountPct > 0)
                    <div class="absolute top-3 left-3 z-10">
                        <span class="text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm"
                            style="background:#E90C66;">
                            {{ $discountPct }}% OFF
                        </span>
                    </div>
                    @endif
                    <div class="img-zoom-wrap aspect-square p-6" id="mainZoomWrap">
                        <img id="mainProductImage"
                             src="{{ Storage::url($item->featured_image_1) }}"
                             alt="{{ $item->name }}"
                             class="w-full h-full object-contain" />
                    </div>
                </div>
                @if($item->images->count() > 0)
                <div class="flex gap-2 overflow-x-auto pb-1">
                    @foreach($item->images->take(5) as $index => $img)
                    <div onclick="switchImage('{{ Storage::url($img->image) }}', this)"
                         class="thumb-item flex-shrink-0 w-[70px] h-[70px] bg-white rounded-lg border-2 border-gray-200 overflow-hidden cursor-pointer {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ Storage::url($img->image) }}" alt="{{ $item->name }}"
                            class="w-full h-full object-contain p-1.5" />
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ══ RIGHT — Info ══ --}}
            <div class="w-full lg:w-[58%] bg-white rounded-xl border border-gray-200 shadow-sm p-6 md:p-8">

                <h1 class="text-xl md:text-[1.55rem] font-bold text-gray-900 leading-snug mb-3">
                    {{ \App\Helpers\TranslateHelper::translate($item->name) }}
                </h1>

                {{-- Stock + SKU --}}
                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    @if($hasVariants)
                        @if($totalStock > 0)
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-full border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>In Stock
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-xs font-semibold px-3 py-1.5 rounded-full border border-red-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Out of Stock
                        </span>
                        @endif
                    @endif
                    <span class="text-xs text-gray-400">
                        <span class="font-semibold text-gray-500">SKU:</span> {{ $item->sku }}
                    </span>
                </div>

                <hr class="sec-divider">

                {{-- Price --}}
                <div class="flex items-end gap-3 mb-1 flex-wrap">
                    @if($regularPrice > $salePrice)
                    <span class="price-regular">{{ currency() }} {{ number_format($regularPrice, 2) }}</span>
                    @endif
                    <span class="price-sale current-price">{{ currency() }} {{ number_format($salePrice, 2) }}</span>
                    <span id="discountBadge"
                          class="text-white text-xs font-bold px-2.5 py-1 rounded-full self-center"
                          style="background:#E90C66;"
                          @if($discountPct <= 0) style="display:none;" @endif>
                        {{ $discountPct }}% {{ \App\Helpers\TranslateHelper::translate('off') }}
                    </span>
                </div>

                @if($item->vendor)
                <div class="flex items-center gap-3 mb-4 px-3 py-2.5 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                        style="background:rgba(27,58,107,0.1);">
                        <i class="fas fa-store text-sm" style="color:#1B3A6B;"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-0.5">{{ \App\Helpers\TranslateHelper::translate('Sold by') }}</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $item->vendor->shop_name ?? $item->vendor->name }}</p>
                    </div>
                </div>
                @endif

                <hr class="sec-divider">

                {{-- Color --}}
                @if($item->variants->whereNotNull('color_id')->count() > 0)
                <div class="mb-5">
                    <p class="text-sm font-semibold text-gray-700 mb-2.5">
                        {{ \App\Helpers\TranslateHelper::translate('Color') }}:
                        <span id="selectedColorName" class="font-bold ml-1" style="color:#1B3A6B;"></span>
                    </p>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach($item->variants->whereNotNull('color_id')->unique('color_id') as $variant)
                        @php
                            $colorCode = $variant->color->code ?? '#000000';
                            if (preg_match('/^#[0-9a-fA-F]{5}$/', $colorCode)) { $colorCode = $colorCode . '0'; }
                            $isLight = in_array(strtolower($colorCode), ['#ffffff','#fff','#f5f5f5','#fafafa','#ffffffff','#f0f0f0']);
                        @endphp
                        <button type="button" onclick="selectColor(this)"
                            data-color="{{ $variant->color->name }}"
                            data-color-id="{{ $variant->color_id }}"
                            data-price="{{ $variant->price }}"
                            title="{{ $variant->color->name }}"
                            class="color-option relative w-10 h-10 rounded-full border-2 {{ $isLight ? 'border-gray-400' : 'border-gray-300' }} transition-all cursor-pointer shadow-sm"
                            style="background-color: {{ $colorCode }};">
                            <span class="checkmark hidden absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-check text-sm drop-shadow"
                                    style="color: {{ $isLight ? '#111827' : '#ffffff' }};"></i>
                            </span>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Size --}}
                @if($item->variants->whereNotNull('size_id')->count() > 0)
                <div class="mb-5" id="sizeSection" style="display:none;">
                    <p class="text-sm font-semibold text-gray-700 mb-2.5">
                        {{ \App\Helpers\TranslateHelper::translate('Size') }}:
                        <span style="color:#E90C66;">*</span>
                    </p>
                    <div class="flex flex-wrap gap-2" id="sizeButtonsContainer"></div>
                    <p id="variantStockInfo" class="text-xs mt-2"></p>
                </div>
                @endif

                <hr class="sec-divider">

                {{-- Qty + CTA --}}
                <div class="mb-4">
                    <div class="flex items-center gap-3 mb-3 flex-wrap">
                        <div class="flex items-center rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                            <button onclick="decreaseQuantity()" class="qty-btn rounded-l-lg">−</button>
                            <input id="quantity" type="text" value="1" class="qty-input" readonly />
                            <button onclick="increaseQuantity()" class="qty-btn rounded-r-lg">+</button>
                        </div>
                        <span class="text-xs text-gray-400">Min. 1 piece</span>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="space-y-2">
                        {{-- PRIMARY: Buy Now --}}
                        <button type="button" onclick="scrollToCheckout()"
                            class="w-full text-white font-bold py-4 px-6 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2.5 text-base hover:opacity-90 active:scale-[.99]"
                            style="background:linear-gradient(135deg,#1B3A6B 0%,#0f2347 100%);">
                            <i class="fas fa-bolt"></i>
                            Buy Now
                            <i class="fas fa-arrow-down text-sm animate-bounce"></i>
                        </button>

                        {{-- SECONDARY: Add to Cart --}}
                        <button type="button"
                            class="orders-now w-full text-white font-semibold py-3 px-4 rounded-lg transition-all shadow flex items-center justify-center gap-2 text-sm"
                            style="background:#E90C66;"
                            onmouseover="this.style.background='#E90C66'"
                            onmouseout="this.style.background='#E90C66'"
                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                            data-price="{{ $item->sale_price }}"
                            data-image="{{ Storage::url($item->featured_image_1) }}"
                            data-slug="{{ $item->slug }}">
                            <i class="fas fa-shopping-cart text-sm"></i> Add To Cart
                        </button>
                    </div>
                </div>

                {{-- Social Order --}}
                <div class="flex gap-3 mb-5">
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode(\App\Helpers\TranslateHelper::translate('I want to order') . ': ' . $item->name . ' - ' . \App\Helpers\TranslateHelper::translate('Price') . ': ' . currency() . ' ' . $item->sale_price) }}"
                        target="_blank" class="flex-1">
                        <button class="w-full bg-[#25D366] hover:bg-[#1ebe5d] text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-sm flex items-center justify-center gap-2 text-sm">
                            <i class="fab fa-whatsapp text-base"></i>
                            {{ \App\Helpers\TranslateHelper::translate('Order on WhatsApp') }}
                        </button>
                    </a>
                    <a href="https://m.me/{{ $fbUsername }}?ref=order" target="_blank" class="flex-1">
                        <button class="w-full bg-[#0084FF] hover:bg-[#006edb] text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-sm flex items-center justify-center gap-2 text-sm">
                            <i class="fab fa-facebook-messenger text-base"></i>
                            {{ \App\Helpers\TranslateHelper::translate('Order on Messenger') }}
                        </button>
                    </a>
                </div>

                {{-- Share --}}
                <hr class="sec-divider">
                <div class="flex items-center gap-2.5 pt-1">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide mr-1">Share:</span>
                    @php $shareUrl = urlencode(request()->url()); @endphp
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                        onclick="window.open(this.href,'_blank');return false;" target="_blank"
                        class="w-8 h-8 flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white rounded-full transition-colors text-xs shadow-sm">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="whatsapp://send?text={{ urlencode('Check out this product: ' . request()->url()) }}"
                        onclick="if(!navigator.userAgent.match(/Mobile/)){window.open('https://wa.me/?text={{ urlencode('Check out this product: ' . request()->url()) }}','_blank');return false;}"
                        class="w-8 h-8 flex items-center justify-center bg-[#25D366] hover:bg-[#1ebe5d] text-white rounded-full transition-colors text-xs shadow-sm">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <button onclick="copyLink()"
                        class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-full transition-colors text-xs shadow-sm">
                        <i class="fas fa-link"></i>
                    </button>
                </div>

            </div>
        </div>

        {{-- ── Description ─────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                <i class="fas fa-align-left text-sm" style="color:#1B3A6B;"></i>
                <h2 class="text-sm font-bold text-gray-800">Product Description</h2>
            </div>
            <div class="px-6 py-6 text-gray-600 leading-relaxed prose max-w-none text-sm">
                {!! \App\Helpers\TranslateHelper::translate($item->description) !!}
            </div>
        </div>

        {{-- ════ INLINE CHECKOUT ════ --}}
        <div class="mb-12" id="inlineCheckoutSection">

          
           {{-- Section Header --}}
            <div class="rounded-2xl px-5 py-4 mb-6 flex items-center justify-between"
                style="background:linear-gradient(135deg,#1B3A6B 0%,#0f2347 100%);">
            
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                        style="background:rgba(255,255,255,0.15);">
                        <i class="fas fa-clipboard-list text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-base leading-tight">Place Your Order</h2>
                        <p class="text-white/60 text-xs mt-0.5">Fill in your details below</p>
                    </div>
                </div>
            
                {{-- Step indicator --}}
                <div class="flex items-center gap-1.5">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white/50 text-xs font-bold"
                        style="background:rgba(255,255,255,0.12);">1</div>
                    <div class="w-5 h-px" style="background:rgba(255,255,255,0.25);"></div>
                    <div class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-xs font-bold"
                        style="color:#1B3A6B;">2</div>
                    <div class="w-5 h-px" style="background:rgba(255,255,255,0.25);"></div>
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white/50 text-xs font-bold"
                        style="background:rgba(255,255,255,0.12);">3</div>
                </div>
            
            </div>

            <div class="flex flex-col lg:flex-row gap-6">

                {{-- ══ LEFT — Checkout Form ══ --}}
                <div class="w-full lg:w-[58%] space-y-4">

                    {{-- Contact Info --}}
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                            <i class="fas fa-user text-xs" style="color:#1B3A6B;"></i>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Contact Information</span>
                        </div>
                        <div class="p-5 space-y-3">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input id="ic-name" type="text" placeholder="Full Name *"
                                    class="ic-input w-full pl-9 pr-4 py-3 border border-gray-200 rounded-lg text-sm outline-none bg-gray-50 focus:bg-white transition-all"
                                    onfocus="this.style.borderColor='#1B3A6B';this.style.boxShadow='0 0 0 2px rgba(27,58,107,0.1)';"
                                    onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';" />
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input id="ic-phone" type="tel" placeholder="Phone Number *"
                                    class="ic-input w-full pl-9 pr-4 py-3 border border-gray-200 rounded-lg text-sm outline-none bg-gray-50 focus:bg-white transition-all"
                                    onfocus="this.style.borderColor='#1B3A6B';this.style.boxShadow='0 0 0 2px rgba(27,58,107,0.1)';"
                                    onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';" />
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input id="ic-address" type="text" placeholder="Full Address (District, Upazila, Area) *"
                                    class="ic-input w-full pl-9 pr-4 py-3 border border-gray-200 rounded-lg text-sm outline-none bg-gray-50 focus:bg-white transition-all"
                                    onfocus="this.style.borderColor='#1B3A6B';this.style.boxShadow='0 0 0 2px rgba(27,58,107,0.1)';"
                                    onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';" />
                            </div>
                        </div>
                    </div>

                  {{-- Shipping Area --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                        <i class="fas fa-truck text-xs" style="color:#1B3A6B;"></i>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Shipping Area</span>
                    </div>
                    <div class="p-5">
                        <div class="relative">
                            <select id="shippingAreaSelect"
                                onchange="icSelectAreaFromDropdown(this)"
                                class="w-full appearance-none border-2 border-gray-200 rounded-xl px-4 py-3 pr-10 text-sm font-semibold text-gray-700 bg-white focus:outline-none cursor-pointer"
                                style="border-color:#1B3A6B;">
                                <option value="" disabled selected>-- select --</option>
                               @foreach($shipingAreas as $area)
                                    <option value="{{ $area->text }}|{{ $area->amount }}">
                                        {{ $area->text }} — ৳{{ number_format($area->amount, 0) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                <i class="fas fa-chevron-down text-xs" style="color:#1B3A6B;"></i>
                            </div>
                        </div>
                
                        {{-- Selected info (optional, shows after selection) --}}
                        <div id="shippingInfo" class="mt-3 hidden px-4 py-3 rounded-xl text-sm" style="background:#EEF2FF;">
                            <span class="text-gray-500">Delivery charge:</span>
                            <span id="shippingCharge" class="font-bold ml-1" style="color:#1B3A6B;"></span>
                        </div>
                    </div>
                </div>

                  {{-- Payment Method --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                        <i class="fas fa-credit-card text-xs" style="color:#1B3A6B;"></i>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Payment Method</span>
                    </div>
                    <div class="p-5">
                
                        {{-- 3-column method selector --}}
                        <div class="grid grid-cols-3 gap-3 mb-0">
                
                            {{-- Cash on Delivery --}}
                            <div onclick="selectPayment('cod', this)"
                                class="payment-option relative flex flex-col items-center text-center p-4 rounded-2xl border-2 cursor-pointer transition-all active-cod"
                                style="border-color:#22c55e; background:#f0fdf4;">
                                <div class="absolute top-2.5 right-2.5 w-[18px] h-[18px] rounded-full bg-green-500 items-center justify-content chk-cod" style="display:flex;">
                                    <svg class="mx-auto" width="10" height="10" viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2.5" style="background:#22c55e;">
                                    <i class="fas fa-money-bill-wave text-white text-base"></i>
                                </div>
                                <p class="font-bold text-gray-800 text-xs leading-tight">Cash on Delivery</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Pay on arrival</p>
                            </div>
                
                            {{-- bKash --}}
                            <div onclick="selectPayment('bkash', this)"
                                class="payment-option relative flex flex-col items-center text-center p-4 rounded-2xl border-2 border-gray-200 cursor-pointer transition-all bg-white">
                                <div class="absolute top-2.5 right-2.5 w-[18px] h-[18px] rounded-full items-center justify-content chk-bkash" style="background:#E2136E; display:none;">
                                    <svg class="mx-auto" width="10" height="10" viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2.5 font-bold text-white text-base"
                                    style="background:#E2136E;">B</div>
                                <p class="font-bold text-gray-800 text-xs leading-tight">bKash</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Mobile banking</p>
                            </div>
                
                            {{-- Nagad --}}
                            <div onclick="selectPayment('nagad', this)"
                                class="payment-option relative flex flex-col items-center text-center p-4 rounded-2xl border-2 border-gray-200 cursor-pointer transition-all bg-white">
                                <div class="absolute top-2.5 right-2.5 w-[18px] h-[18px] rounded-full items-center justify-content chk-nagad" style="background:#F6821F; display:none;">
                                    <svg class="mx-auto" width="10" height="10" viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2.5 font-bold text-white text-base"
                                    style="background:#F6821F;">N</div>
                                <p class="font-bold text-gray-800 text-xs leading-tight">Nagad</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Mobile banking</p>
                            </div>
                
                        </div>
                
                        {{-- bKash Info Box --}}
                        <div id="bkash-info-box" class="hidden mt-3 rounded-xl p-4 border" style="background:#fff0f6; border-color:#f9a8d4;">
                        
                            {{-- Instruction --}}
                            <div class="rounded-lg px-4 py-3 mb-3 border border-pink-200" style="background:#ffe4f0;">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center mt-0.5" style="background:#E2136E;">
                                        <i class="fas fa-comment-dots text-white text-[10px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold mb-1" style="color:#E2136E;">How to pay via bKash</p>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            আপনার bKash অ্যাপ থেকে
                                            <span class="font-bold text-gray-800">{{ $setting->bkash_number ?? 'N/A' }}</span>
                                            নম্বরে
                                            <span class="font-bold" style="color:#E2136E;" id="bkash-amount-hint">মোট টাকা</span>
                                            Send Money করুন, তারপর নিচে তথ্য দিন।
                                        </p>
                                    </div>
                                </div>
                            </div>
                        
                            {{-- Merchant Number --}}
                            <p class="text-xs font-semibold mb-2" style="color:#E2136E;">
                                <i class="fas fa-mobile-alt mr-1"></i> bKash Number:
                            </p>
                            <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2.5 border border-pink-200 mb-4">
                                <span class="font-bold text-gray-800 text-sm tracking-widest">{{ $setting->bkash_number ?? 'N/A' }}</span>
                                <button type="button" onclick="copyNumber('{{ $setting->bkash_number ?? '' }}')"
                                    class="text-xs font-semibold px-2 py-1 rounded flex items-center gap-1" style="color:#E2136E;">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        
                            {{-- Payment Number (customer's bKash number) --}}
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                আপনার bKash নম্বর <span class="text-red-500">*</span>
                                <span class="font-normal text-gray-400 ml-1">(যে নম্বর থেকে টাকা পাঠিয়েছেন)</span>
                            </label>
                            <div class="relative mb-3">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"><i class="fas fa-phone"></i></span>
                                <input type="tel" id="ic-bkash-payment-number" placeholder="01XXXXXXXXX"
                                    class="w-full pl-8 pr-3 py-2.5 border rounded-lg text-sm outline-none bg-white"
                                    style="border-color:#f9a8d4;"
                                    onfocus="this.style.borderColor='#E2136E'"
                                    onblur="this.style.borderColor='#f9a8d4'" />
                            </div>
                        
                            {{-- TrxID --}}
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                Transaction ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="ic-trx-id" placeholder="e.g. 8C3D2F1AB9"
                                class="w-full px-3 py-2.5 border rounded-lg text-sm outline-none bg-white"
                                style="border-color:#f9a8d4;"
                                onfocus="this.style.borderColor='#E2136E'"
                                onblur="this.style.borderColor='#f9a8d4'" />
                            <p class="text-[10px] text-gray-400 mt-1.5">
                                <i class="fas fa-shield-alt mr-1"></i> Send Money complete হলে TrxID কপি করে দিন
                            </p>
                        </div>
                        
                        {{-- Nagad Info Box --}}
                        <div id="nagad-info-box" class="hidden mt-3 rounded-xl p-4 border" style="background:#fff7ed; border-color:#fed7aa;">
                        
                            {{-- Instruction --}}
                            <div class="rounded-lg px-4 py-3 mb-3 border border-orange-200" style="background:#ffe8d0;">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center mt-0.5" style="background:#F6821F;">
                                        <i class="fas fa-comment-dots text-white text-[10px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold mb-1" style="color:#F6821F;">How to pay via Nagad</p>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            আপনার Nagad অ্যাপ থেকে
                                            <span class="font-bold text-gray-800">{{ $setting->nagad_number ?? 'N/A' }}</span>
                                            নম্বরে
                                            <span class="font-bold" style="color:#F6821F;" id="nagad-amount-hint">মোট টাকা</span>
                                            Send Money করুন, তারপর নিচে তথ্য দিন।
                                        </p>
                                    </div>
                                </div>
                            </div>
                        
                            {{-- Merchant Number --}}
                            <p class="text-xs font-semibold mb-2" style="color:#F6821F;">
                                <i class="fas fa-mobile-alt mr-1"></i> Nagad Number:
                            </p>
                            <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2.5 border border-orange-200 mb-4">
                                <span class="font-bold text-gray-800 text-sm tracking-widest">{{ $setting->nagad_number ?? 'N/A' }}</span>
                                <button type="button" onclick="copyNumber('{{ $setting->nagad_number ?? '' }}')"
                                    class="text-xs font-semibold px-2 py-1 rounded flex items-center gap-1" style="color:#F6821F;">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        
                            {{-- Payment Number (customer's Nagad number) --}}
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                আপনার Nagad নম্বর <span class="text-red-500">*</span>
                                <span class="font-normal text-gray-400 ml-1">(যে নম্বর থেকে টাকা পাঠিয়েছেন)</span>
                            </label>
                            <div class="relative mb-3">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"><i class="fas fa-phone"></i></span>
                                <input type="tel" id="ic-nagad-payment-number" placeholder="01XXXXXXXXX"
                                    class="w-full pl-8 pr-3 py-2.5 border rounded-lg text-sm outline-none bg-white"
                                    style="border-color:#fed7aa;"
                                    onfocus="this.style.borderColor='#F6821F'"
                                    onblur="this.style.borderColor='#fed7aa'" />
                            </div>
                        
                            {{-- TrxID --}}
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                Transaction ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="ic-nagad-trx-id" placeholder="e.g. 8C3D2F1AB9"
                                class="w-full px-3 py-2.5 border rounded-lg text-sm outline-none bg-white"
                                style="border-color:#fed7aa;"
                                onfocus="this.style.borderColor='#F6821F'"
                                onblur="this.style.borderColor='#fed7aa'" />
                            <p class="text-[10px] text-gray-400 mt-1.5">
                                <i class="fas fa-shield-alt mr-1"></i> Send Money complete হলে TrxID কপি করে দিন
                            </p>
                        </div>
                
                    </div>
                </div>
                    
                    
                    
                    

                    {{-- Terms --}}
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" id="ic-terms" class="mt-0.5 w-4 h-4 rounded"
                                style="accent-color:#1B3A6B;" checked />
                            <span class="text-xs text-gray-500 leading-relaxed">
                                I agree to the
                                <a href="#" class="font-medium hover:underline" style="color:#1B3A6B;">Terms & Conditions</a>,
                                <a href="#" class="font-medium hover:underline" style="color:#1B3A6B;">Refund Policy</a> and
                                <a href="#" class="font-medium hover:underline" style="color:#1B3A6B;">Privacy Policy</a>.
                            </span>
                        </label>
                    </div>

                    {{-- Place Order Button --}}
                    <button id="ic-place-order" onclick="placeInlineOrder()"
                        class="w-full text-white font-bold py-4 rounded-xl text-base flex items-center justify-center gap-2 shadow-lg transition-all hover:opacity-90 active:scale-[.99]"
                        style="background:linear-gradient(135deg,#E90C66 0%,#E90C66 100%);">
                        <i class="fas fa-check-circle"></i>
                        Confirm Order
                    </button>

                </div>

                {{-- ══ RIGHT — Order Summary ══ --}}
                <div class="w-full lg:w-[42%]">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden sticky top-[90px]">

                        {{-- Header --}}
                        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100"
                            style="background:linear-gradient(135deg,#1B3A6B,#0f2347);">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shopping-bag text-white text-sm"></i>
                                <h3 class="font-bold text-white text-sm">Order Summary</h3>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full text-white"
                                style="background:rgba(255,255,255,0.15);">1 item</span>
                        </div>

                        {{-- Product Card --}}
                        <div class="p-4 border-b border-gray-100">
                            <div class="flex gap-3">
                                <div class="w-18 h-18 flex-shrink-0">
                                    <img src="{{ Storage::url($item->featured_image_1) }}"
                                        alt="{{ $item->name }}"
                                        class="w-16 h-16 rounded-xl object-cover border border-gray-200" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-800 text-sm line-clamp-2 leading-snug mb-1">{{ $item->name }}</h4>
                                    <p class="text-xs text-gray-400 mb-2" id="ic-variant-info">No variant selected</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center rounded-lg border border-gray-200 overflow-hidden">
                                            <button onclick="icDecQty()" class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-100 font-bold text-gray-600 text-sm transition-all">−</button>
                                            <span id="ic-qty-display" class="w-8 text-center font-bold text-sm text-gray-800">1</span>
                                            <button onclick="icIncQty()" class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-100 font-bold text-gray-600 text-sm transition-all">+</button>
                                        </div>
                                        <p class="font-bold text-base" style="color:#1B3A6B;" id="ic-item-total">
                                            {{ currency() }} {{ number_format($salePrice, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Totals --}}
                        <div class="p-4 space-y-2.5">
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Subtotal</span>
                                <span id="ic-subtotal" class="font-semibold text-gray-700">
                                    {{ currency() }} {{ number_format($salePrice, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Delivery Charge</span>
                                <span id="ic-delivery" class="font-semibold text-gray-700">
                                    {{ currency() }} 0.00
                                </span>
                            </div>
                           
                            <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center">
                                <span class="font-bold text-gray-800">Total Payable</span>
                                <span id="ic-total" class="text-xl font-extrabold" style="color:#E90C66;">
                                    {{ currency() }} {{ number_format($salePrice, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- ════ END INLINE CHECKOUT ════ --}}

    </section>

    {{-- ── Related Products ─────────────────────────────── --}}
   @if($relatedProducts->isNotEmpty())
     {{--<section class="container mx-auto px-4 md:px-8 pb-16">
       <div class="section-bar mb-6">
            <div class="section-bar-left">
                <h2>{{ \App\Helpers\TranslateHelper::translate('Related Products') }}</h2>
            </div>
            @if($item->category_id)
            <a href="{{ route('products', ['category' => $item->category_id]) }}" class="section-bar-right">
                <span>{{ \App\Helpers\TranslateHelper::translate('View All') }} <i class="fa-solid fa-circle-arrow-right"></i></span>
            </a>
            @endif
        </div>

        @if($productCount > 4)
        <div class="relative">
            <div class="swiper relatedProductsSwiper overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach ($relatedProducts->sortBy('sale_price') as $product)
                    @php
                        $prodDiscount = ($product->regular_price > 0 && $product->sale_price < $product->regular_price)
                            ? round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) : 0;
                    @endphp
                    <div class="swiper-slide h-auto">
                        <div class="gadget-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mx-2">
                            <div class="product-img-wrap">
                                <img src="{{ Storage::url($product->featured_image_1) }}"
                                    alt="{{ $product->name }}"
                                    class="primary-img"
                                    onerror="this.src='https://via.placeholder.com/500x500/e5e7eb/6b7280?text=Product'" />
                                @if($product->featured_image_2)
                                <img src="{{ Storage::url($product->featured_image_2) }}"
                                    alt="{{ $product->name }}"
                                    class="hover-img"
                                    onerror="this.src='https://via.placeholder.com/500x500/e5e7eb/6b7280?text=Product'" />
                                @endif
                        
                                <div class="cart-overlay">
                                    <button class="orders-now text-white text-xs font-bold px-3 py-1.5 rounded-full"
                                        style="background:#E90C66;"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-slug="{{ $product->slug }}"
                                        data-image="{{ Storage::url($product->featured_image_1) }}"
                                        data-price="{{ $product->sale_price }}"
                                        data-has-variant="{{ $product->variants->count() > 0 ? '1' : '0' }}">
                                        <i class="fa-solid fa-cart-plus mr-1"></i>Add
                                    </button>
                                </div>
                            </div>
                            <div class="card-info">
                                <a href="{{ route('product.single', $product->slug) }}">
                                    <h3>{{ \App\Helpers\TranslateHelper::translate($product->name) }}</h3>
                                </a>
                                <div class="card-bottom">
                                    <div>
                                        <p class="card-price">{{ currency() }} {{ number_format($product->sale_price, 2) }}</p>
                                        @if($product->regular_price > $product->sale_price)
                                        <p class="card-price-old" style="color:#E90C66;">
                                            {{ currency() }} {{ number_format($product->regular_price, 2) }}
                                        </p>
                                        @endif
                                    </div>
                                    <a href="{{ route('product.single', $product->slug) }}">
                                        <button class="buy-btn">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span class="btn-text">{{ \App\Helpers\TranslateHelper::translate('Buy Now') }}</span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev nav-swiper-btn">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="swiper-button-next nav-swiper-btn">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 3L11 8L6 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
        @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($relatedProducts->sortBy('sale_price') as $product)
            @php
                $prodDiscount = ($product->regular_price > 0 && $product->sale_price < $product->regular_price)
                    ? round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) : 0;
            @endphp
            <div class="gadget-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="product-img-wrap">
                    <img src="{{ Storage::url($product->featured_image_1) }}"
                        alt="{{ $product->name }}" class="primary-img" />
                    @if($product->featured_image_2)
                    <img src="{{ Storage::url($product->featured_image_2) }}"
                        alt="{{ $product->name }}" class="hover-img" />
                    @endif
                   
                    <div class="cart-overlay">
                        <button class="orders-now text-white text-xs font-bold px-3 py-1.5 rounded-full"
                            style="background:#E90C66;"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-slug="{{ $product->slug }}"
                            data-image="{{ Storage::url($product->featured_image_1) }}"
                            data-price="{{ $product->sale_price }}"
                            data-has-variant="{{ $product->variants->count() > 0 ? '1' : '0' }}">
                            <i class="fa-solid fa-cart-plus mr-1"></i>Add
                        </button>
                    </div>
                </div>
                <div class="card-info">
                    <a href="{{ route('product.single', $product->slug) }}">
                        <h3>{{ \App\Helpers\TranslateHelper::translate($product->name) }}</h3>
                    </a>
                    <div class="card-bottom">
                        <div>
                            <p class="card-price">{{ currency() }} {{ number_format($product->sale_price, 2) }}</p>
                            @if($product->regular_price > $product->sale_price)
                            <p class="card-price-old" style="color:#E90C66;">
                                {{ currency() }} {{ number_format($product->regular_price, 2) }}
                            </p>
                            @endif
                        </div>
                        <a href="{{ route('product.single', $product->slug) }}">
                            <button class="buy-btn">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="btn-text">{{ \App\Helpers\TranslateHelper::translate('Buy Now') }}</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>--}}
    @endif

</main>

@endsection

@section('script')
<script>
    @if($productCount > 4)
    new Swiper(".relatedProductsSwiper", {
        slidesPerView: 2,
        spaceBetween: 16,
        loop: {{ $productCount >= 8 ? 'true' : 'false' }},
        autoplay: { delay: 3000, disableOnInteraction: false },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        breakpoints: {
            320:  { slidesPerView: 2, spaceBetween: 12 },
            640:  { slidesPerView: 2, spaceBetween: 16 },
            768:  { slidesPerView: 3, spaceBetween: 16 },
            1024: { slidesPerView: 4, spaceBetween: 16 },
            1280: { slidesPerView: 4, spaceBetween: 20 },
        },
    });
    @endif
</script>

<script>
/* ════════════════════════════════════════════
   SCROLL TO CHECKOUT
════════════════════════════════════════════ */
function scrollToCheckout() {
    if (!validateBeforeOrder()) return;
    const section = document.getElementById('inlineCheckoutSection');
    if (!section) return;
    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    setTimeout(function() {
        section.style.transition   = 'box-shadow .3s';
        section.style.boxShadow    = '0 0 0 3px rgba(27,58,107,0.35)';
        section.style.borderRadius = '1rem';
        setTimeout(function() {
            section.style.boxShadow = 'none';
            const firstInput = document.getElementById('ic-name');
            if (firstInput) firstInput.focus();
        }, 800);
    }, 600);
}

/* Scroll → show FAB */
window.addEventListener('scroll', function() {
    const fab = document.getElementById('quickOrderFab');
    if (fab) fab.style.display = window.scrollY > 400 ? 'flex' : 'none';
});

/* ─── Image Zoom ─── */
const zoomWrap = document.getElementById('mainZoomWrap');
if (zoomWrap) {
    zoomWrap.addEventListener('mousemove', function(e) {
        const r  = this.getBoundingClientRect();
        const ox = ((e.clientX - r.left)  / r.width  * 100).toFixed(1) + '%';
        const oy = ((e.clientY - r.top)   / r.height * 100).toFixed(1) + '%';
        this.querySelector('img').style.transformOrigin = ox + ' ' + oy;
    });
}

function switchImage(src, el) {
    document.getElementById('mainProductImage').src = src;
    document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href)
        .then(() => toastr.success('Link copied!'))
        .catch(() => toastr.error('Could not copy link'));
}

/* ─── Quantity ─── */
function increaseQuantity() {
    let el = document.getElementById('quantity');
    el.value = parseInt(el.value) + 1;
    icUpdateTotals();
}
function decreaseQuantity() {
    let el = document.getElementById('quantity');
    let v  = parseInt(el.value);
    if (v > 1) { el.value = v - 1; icUpdateTotals(); }
}

/* ─── Variant State ─── */
const regularPrice       = {{ $item->regular_price }};
let selectedColorValue   = '';
let selectedSizeValue    = '';
let selectedColorId      = null;
let selectedVariantPrice = {{ $item->sale_price }};
let selectedVariantStock = null;

function updatePriceUI(newPrice) {
    selectedVariantPrice = parseFloat(newPrice);
    document.querySelector('.current-price').textContent = '{{ currency() }} ' + selectedVariantPrice.toFixed(2);
    const badge = document.getElementById('discountBadge');
    if (regularPrice > 0 && selectedVariantPrice < regularPrice) {
        const pct = Math.round(((regularPrice - selectedVariantPrice) / regularPrice) * 100);
        badge.textContent   = pct + '% {{ \App\Helpers\TranslateHelper::translate("off") }}';
        badge.style.display = 'inline-block';
    } else {
        badge.style.display = 'none';
    }
    icUpdateTotals();
}

function selectColor(button) {
    document.querySelectorAll('.color-option .checkmark').forEach(m => m.classList.add('hidden'));
    document.querySelectorAll('.color-option').forEach(o => {
        o.style.borderColor = '';
        o.style.boxShadow   = '';
    });
    button.querySelector('.checkmark').classList.remove('hidden');
    button.style.borderColor = '#1B3A6B';
    button.style.boxShadow   = '0 0 0 3px rgba(27,58,107,0.2)';

    selectedColorValue   = button.dataset.color;
    selectedColorId      = parseInt(button.dataset.colorId);
    selectedSizeValue    = '';
    selectedVariantStock = null;

    document.getElementById('selectedColorName').textContent = selectedColorValue;
    if (button.dataset.price) updatePriceUI(button.dataset.price);

    const sizes       = allVariants.filter(v => v.color_id === selectedColorId && v.size_id !== null);
    const sizeSection = document.getElementById('sizeSection');
    const sizeCont    = document.getElementById('sizeButtonsContainer');
    const stockInfo   = document.getElementById('variantStockInfo');
    if (stockInfo) stockInfo.textContent = '';

    if (sizes.length > 0) {
        selectedVariantStock = null;
        sizeSection.style.display = 'block';
        sizeCont.innerHTML = '';
        sizes.forEach(v => {
            const inStock = v.stock > 0;
            const btn     = document.createElement('button');
            btn.type = 'button';
            btn.dataset.size   = v.size;
            btn.dataset.sizeId = v.size_id;
            btn.dataset.price  = v.price;
            btn.dataset.stock  = v.stock;
            if (inStock) {
                btn.className = 'size-option px-5 py-2.5 border-2 border-gray-300 rounded-lg font-semibold text-sm text-gray-700 transition-all cursor-pointer';
                btn.onmouseover = function() { if(!this.classList.contains('selected-size')) { this.style.borderColor='#1B3A6B'; } };
                btn.onmouseout  = function() { if(!this.classList.contains('selected-size')) { this.style.borderColor='#d1d5db'; } };
                btn.onclick = function() { selectSize(this); };
            } else {
                btn.className = 'size-option px-5 py-2.5 border-2 border-gray-200 rounded-lg font-semibold text-sm text-gray-300 cursor-not-allowed line-through';
                btn.disabled = true;
            }
            let html = v.size;
            if (v.size_desc) html += `<span class="block text-[10px] font-normal ${inStock ? 'text-gray-400' : 'text-gray-200'}">${v.size_desc}</span>`;
            if (!inStock)    html += `<span class="block text-[10px] font-normal text-red-400">(Out of Stock)</span>`;
            btn.innerHTML = html;
            sizeCont.appendChild(btn);
        });
    } else {
        sizeSection.style.display = 'none';
        const colorVariant = allVariants.find(v => v.color_id === selectedColorId);
        selectedVariantStock = colorVariant ? colorVariant.stock : 0;
    }
}

function selectSize(button) {
    document.querySelectorAll('.size-option').forEach(opt => {
        opt.classList.remove('selected-size');
        opt.style.borderColor = '#d1d5db';
        opt.style.background  = '';
        opt.style.color       = '#374151';
    });
    button.classList.add('selected-size');
    button.style.borderColor = '#1B3A6B';
    button.style.background  = 'rgba(27,58,107,0.06)';
    button.style.color       = '#1B3A6B';

    selectedSizeValue    = button.dataset.size;
    selectedVariantStock = parseInt(button.dataset.stock);
    if (button.dataset.price) updatePriceUI(button.dataset.price);

    const stockEl = document.getElementById('variantStockInfo');
    stockEl.innerHTML = selectedVariantStock > 0
        ? `<span class="text-green-600 font-semibold">✓ In Stock</span> <span class="text-gray-400">(${selectedVariantStock} available)</span>`
        : `<span class="text-red-500 font-semibold">✗ Out of Stock</span>`;
}

function validateBeforeOrder() {
    const hasVariants = allVariants.length > 0;
    const hasSizes    = allVariants.some(v => v.size_id !== null);
    if (hasVariants && !selectedColorValue) { toastr.warning('Please select a color first!'); return false; }
    if (hasSizes && !selectedSizeValue)     { toastr.warning('Please select a size!');        return false; }
    if (selectedVariantStock !== null && selectedVariantStock <= 0) { toastr.error('Sorry! This product is currently out of stock.'); return false; }
    return true;
}

/* ─── Add to Cart ─── */
$(document).on('click', '.order-now', function(e) {
    e.preventDefault();
    if (!validateBeforeOrder()) return;
    const btn = $(this);
    const qty = parseInt($('#quantity').val()) || 1;
    const item = {
        productId : btn.data('id'),
        name      : btn.data('name') + (selectedColorValue ? ' - ' + selectedColorValue : '') + (selectedSizeValue ? ' / ' + selectedSizeValue : ''),
        price     : selectedVariantPrice,
        image     : btn.data('image'),
        slug      : btn.data('slug'),
        quantity  : qty,
        color     : selectedColorValue,
        size      : selectedSizeValue
    };
    let cart  = JSON.parse(localStorage.getItem('cart')) || [];
    let exist = cart.find(p => p.productId === item.productId && p.color === item.color && p.size === item.size);
    if (exist) { exist.quantity += qty; } else { cart.push(item); }
    localStorage.setItem('cart', JSON.stringify(cart));
    toastr.success(item.name + ' added to cart!');
    renderCart();
    toggleCart();
});

/* ─── Inline Checkout ─── */
let icDeliveryCharge = 0;
let icDeliveryArea   = '';
let icQty            = 1;
const icBasePrice    = {{ $item->sale_price }};

function icSelectArea(btn, area, charge) {
    document.querySelectorAll('.ic-area-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    icDeliveryArea   = area;
    icDeliveryCharge = charge;
    icUpdateTotals();
}

function icIncQty() {
    icQty++;
    document.getElementById('ic-qty-display').textContent = icQty;
    document.getElementById('quantity').value = icQty;
    icUpdateTotals();
}
function icDecQty() {
    if (icQty > 1) {
        icQty--;
        document.getElementById('ic-qty-display').textContent = icQty;
        document.getElementById('quantity').value = icQty;
        icUpdateTotals();
    }
}

function icUpdateTotals() {
    const price = selectedVariantPrice || icBasePrice;
    const sub   = price * icQty;
    const total = sub + icDeliveryCharge;
    document.getElementById('ic-item-total').textContent = '{{ currency() }} ' + sub.toFixed(2);
    document.getElementById('ic-subtotal').textContent   = '{{ currency() }} ' + sub.toFixed(2);
    document.getElementById('ic-delivery').textContent   = '{{ currency() }} ' + icDeliveryCharge.toFixed(2);
    document.getElementById('ic-total').textContent      = '{{ currency() }} ' + total.toFixed(2);
    
    
     // bKash / Nagad amount hint update
    const amountText = '৳' + total.toFixed(0);
    const bEl = document.getElementById('bkash-amount-hint');
    const nEl = document.getElementById('nagad-amount-hint');
    if (bEl) bEl.textContent = amountText;
    if (nEl) nEl.textContent = amountText;
}

function icSyncVariant() {
    let variantText = '';
    if (selectedColorValue) variantText += selectedColorValue;
    if (selectedSizeValue)  variantText += (variantText ? ' / ' : '') + selectedSizeValue;
    const el = document.getElementById('ic-variant-info');
    if (el) el.textContent = variantText || 'No variant selected';
    icUpdateTotals();
}

const _origSelectColor = selectColor;
selectColor = function(button) { _origSelectColor(button); icSyncVariant(); };
const _origSelectSize  = selectSize;
selectSize  = function(button) { _origSelectSize(button);  icSyncVariant(); };

const _origInc = increaseQuantity;
increaseQuantity = function() {
    _origInc();
    icQty = parseInt(document.getElementById('quantity').value) || 1;
    document.getElementById('ic-qty-display').textContent = icQty;
    icUpdateTotals();
};
const _origDec = decreaseQuantity;
decreaseQuantity = function() {
    _origDec();
    icQty = parseInt(document.getElementById('quantity').value) || 1;
    document.getElementById('ic-qty-display').textContent = icQty;
    icUpdateTotals();
};

function placeInlineOrder() {
    if (!validateBeforeOrder()) return;
    const name    = document.getElementById('ic-name').value.trim();
    const phone   = document.getElementById('ic-phone').value.trim();
    const address = document.getElementById('ic-address').value.trim();
    const terms   = document.getElementById('ic-terms').checked;

    if (!name)           { toastr.warning('Please enter your name');          return; }
    if (!phone)          { toastr.warning('Please enter phone number');        return; }
    if (!address)        { toastr.warning('Please enter your address');        return; }
    if (!icDeliveryArea) { toastr.warning('Please select a shipping area');   return; }
    if (!terms)          { toastr.warning('Please agree to terms & conditions'); return; }
    
  // Transaction ID + Payment Number check
let transactionId   = '';
let paymentNumber   = '';

if (selectedPaymentMethod === 'bkash') {
    paymentNumber   = document.getElementById('ic-bkash-payment-number').value.trim();
    transactionId   = document.getElementById('ic-trx-id').value.trim();
    if (!paymentNumber)  { toastr.warning('আপনার bKash নম্বর দিন'); return; }
    if (!transactionId)  { toastr.warning('bKash Transaction ID দিন'); return; }
}
if (selectedPaymentMethod === 'nagad') {
    paymentNumber   = document.getElementById('ic-nagad-payment-number').value.trim();
    transactionId   = document.getElementById('ic-nagad-trx-id').value.trim();
    if (!paymentNumber)  { toastr.warning('আপনার Nagad নম্বর দিন'); return; }
    if (!transactionId)  { toastr.warning('Nagad Transaction ID দিন'); return; }
}

    const price   = selectedVariantPrice || icBasePrice;
    const sub     = price * icQty;
    const total   = sub + icDeliveryCharge;

    const productName = '{{ addslashes($item->name) }}'
        + (selectedColorValue ? ' - ' + selectedColorValue : '')
        + (selectedSizeValue  ? ' / ' + selectedSizeValue  : '');

   const orderData = {
    _token          : '{{ csrf_token() }}',
    customer_name   : name,
    phone           : phone,
    address         : address,
    delivery_area   : icDeliveryArea,
    delivery_charge : icDeliveryCharge,
    payment_method  : selectedPaymentMethod,   // ✅ fix
    transaction_id  : transactionId,            // ✅ fix
    payment_number  : paymentNumber,
    coupon_code     : '',
    coupon_amount   : 0,
    coupon_point    : 0,
    total           : total.toFixed(2),
    items           : [{
        productId  : {{ $item->id }},
        id         : {{ $item->id }},
        variant_id : null,
        quantity   : icQty,
        price      : price,
        name       : productName,
        image      : '{{ Storage::url($item->featured_image_1) }}',
        color      : selectedColorValue || '',
        size       : selectedSizeValue  || '',
        brand      : '',
    }]
};

    const btn = document.getElementById('ic-place-order');
    btn.disabled  = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

    $.post('{{ route("order.store") }}', orderData, function(res) {
        if (res.success) {
            toastr.success('Order placed successfully!');
            window.location.href = '/success/' + res.id;
        }
    }).fail(function(xhr) {
        toastr.error('Order failed: ' + (xhr.responseJSON?.message || 'Unknown error'));
        btn.disabled  = false;
        btn.innerHTML = '<i class="fas fa-check-circle"></i> Confirm Order';
    });
}
</script>


<script>
    
let selectedPaymentMethod = 'cod';

function selectPayment(method, el) {
    selectedPaymentMethod = method;

    document.querySelectorAll('.payment-option').forEach(opt => {
        opt.classList.remove('active-cod', 'active-bkash', 'active-nagad');
        opt.style.borderColor = '#e5e7eb';
        opt.style.background  = '#fff';
    });
    document.querySelector('.chk-cod').style.display   = 'none';
    document.querySelector('.chk-bkash').style.display = 'none';
    document.querySelector('.chk-nagad').style.display = 'none';
    document.getElementById('bkash-info-box').classList.add('hidden');
    document.getElementById('nagad-info-box').classList.add('hidden');

    if (method === 'cod') {
        el.style.borderColor = '#22c55e';
        el.style.background  = '#f0fdf4';
        document.querySelector('.chk-cod').style.display = 'flex';
    } else if (method === 'bkash') {
        el.style.borderColor = '#E2136E';
        el.style.background  = '#fff0f6';
        document.querySelector('.chk-bkash').style.display = 'flex';
        document.getElementById('bkash-info-box').classList.remove('hidden');
    } else if (method === 'nagad') {
        el.style.borderColor = '#F6821F';
        el.style.background  = '#fff7ed';
        document.querySelector('.chk-nagad').style.display = 'flex';
        document.getElementById('nagad-info-box').classList.remove('hidden');
    }
}

function copyNumber(number) {
    if (!number) return;
    navigator.clipboard.writeText(number)
        .then(() => toastr.success('Number copied: ' + number))
        .catch(() => toastr.error('Could not copy'));
}
</script>


<script>
    function icSelectAreaFromDropdown(select) {
    const val = select.value;
    if (!val) return;

    const parts  = val.split('|');
    icDeliveryArea   = parts[0];
    icDeliveryCharge = parseFloat(parts[1]);

    // Shipping info box দেখাও
    const infoBox = document.getElementById('shippingInfo');
    const chargeEl = document.getElementById('shippingCharge');
    if (infoBox) infoBox.classList.remove('hidden');
    if (chargeEl) chargeEl.textContent = '৳' + parts[1];

    icUpdateTotals();
}
</script>



@endsection