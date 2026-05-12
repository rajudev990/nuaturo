@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('Products'))
@section('content')

@php
    $allCategories = \App\Models\Category::where('status', 1)
        ->with(['subCategories' => fn($q) => $q->where('status', 1)])
        ->get();

    $maxPrice  = \App\Models\Product::where('status', 1)->max('regular_price') ?? 1000;
    $filterMin = request('price_min', 0);
    $filterMax = request('price_max', $maxPrice);
@endphp

<style>
/* ── Sidebar ─────────────────────────────────────── */
.sidebar-section {
    background: #fff;
    border-radius: 0.75rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    padding: 16px;
    margin-bottom: 16px;
    border: 1px solid #f1f5f9;
}
.sidebar-section__title {
    font-size: 0.8125rem;
    font-weight: 800;
    color: #1f2937;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 12px;
    user-select: none;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
</style>

<section class="bg-gray-50 min-h-screen">
  <div class="container mx-auto px-4 py-6">

    {{-- ── Breadcrumb ──────────────────────────────── --}}
    <nav class="bg-white rounded-xl px-4 py-3 mb-5 shadow-sm border border-gray-100">
      <ol class="flex items-center gap-2 text-xs flex-wrap">
        <li>
          <a href="/" class="flex items-center gap-1 text-gray-500 hover:text-primary transition-colors">
            <i class="fas fa-home text-[10px]"></i>
            <span class="font-medium">{{ \App\Helpers\TranslateHelper::translate('Home') }}</span>
          </a>
        </li>
        <li><i class="fas fa-chevron-right text-[9px] text-gray-300"></i></li>
        <li>
          <a href="{{ route('products') }}" class="text-gray-500 hover:text-primary transition-colors font-medium">
            {{ \App\Helpers\TranslateHelper::translate('Products') }}
          </a>
        </li>
        @if(!empty($breadcrumbs))
          @foreach($breadcrumbs as $crumb)
            <li><i class="fas fa-chevron-right text-[9px] text-gray-300"></i></li>
            @if(!$loop->last)
              <li>
                <a href="{{ route('products', [$crumb['type'] === 'category' ? 'category' : 'sub_category' => $crumb['id']]) }}"
                   class="text-gray-500 hover:text-primary transition-colors font-medium">
                  {{ \App\Helpers\TranslateHelper::translate($crumb['name']) }}
                </a>
              </li>
            @else
              <li class="flex items-center gap-2">
                <span class="text-primary font-bold">{{ \App\Helpers\TranslateHelper::translate($crumb['name']) }}</span>
                <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded-full">
                  {{ $products->count() }} {{ \App\Helpers\TranslateHelper::translate('items') }}
                </span>
              </li>
            @endif
          @endforeach
        @elseif($categoryName != 'All Products')
          <li><i class="fas fa-chevron-right text-[9px] text-gray-300"></i></li>
          <li class="flex items-center gap-2">
            <span class="text-primary font-bold">{{ \App\Helpers\TranslateHelper::translate($categoryName) }}</span>
            <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded-full">
              {{ $products->count() }} {{ \App\Helpers\TranslateHelper::translate('items') }}
            </span>
          </li>
        @endif
      </ol>
    </nav>

    <div class="flex gap-5">

      {{-- ══ LEFT SIDEBAR ════════════════════════════ --}}
      <aside class="hidden lg:block w-60 flex-shrink-0">
        <form method="GET" action="{{ route('products') }}" id="filterForm">

          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
          @if(request('sub_category'))
            <input type="hidden" name="sub_category" value="{{ request('sub_category') }}">
          @endif

          {{-- Availability --}}
          <div class="sidebar-section">
            <h3 class="sidebar-section__title" onclick="toggleSection('availSection')">
              Availability
              <i class="fas fa-chevron-up text-xs text-gray-400 transition-transform duration-200" id="availSectionIcon"></i>
            </h3>
            <div id="availSection" class="space-y-2.5">
              <label class="flex items-center gap-2.5 cursor-pointer group">
                <input type="checkbox" name="availability[]" value="in_stock"
                  {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}
                  class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary"
                  onchange="document.getElementById('filterForm').submit()">
                <span class="text-sm text-gray-600 group-hover:text-primary transition-colors">In Stock</span>
              </label>
              <label class="flex items-center gap-2.5 cursor-pointer group">
                <input type="checkbox" name="availability[]" value="out_of_stock"
                  {{ in_array('out_of_stock', request('availability', [])) ? 'checked' : '' }}
                  class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary"
                  onchange="document.getElementById('filterForm').submit()">
                <span class="text-sm text-gray-600 group-hover:text-primary transition-colors">Out of Stock</span>
              </label>
            </div>
          </div>

          {{-- Price Filter --}}
          <div class="sidebar-section">
            <h3 class="sidebar-section__title" onclick="toggleSection('priceSection')">
              Filter By Price
              <i class="fas fa-chevron-up text-xs text-gray-400 transition-transform duration-200" id="priceSectionIcon"></i>
            </h3>
            <div id="priceSection">
              <div class="relative h-2 bg-gray-100 rounded-full mb-4 mt-2" id="sliderTrack">
                <div class="absolute h-2 bg-primary rounded-full" id="sliderRange"></div>
                <input type="range" id="priceMinSlider" name="price_min"
                  min="0" max="{{ $maxPrice }}" value="{{ $filterMin }}" step="1"
                  class="absolute w-full h-2 opacity-0 cursor-pointer" style="z-index:3">
                <input type="range" id="priceMaxSlider" name="price_max"
                  min="0" max="{{ $maxPrice }}" value="{{ $filterMax }}" step="1"
                  class="absolute w-full h-2 opacity-0 cursor-pointer" style="z-index:4">
              </div>
              <div class="flex items-center justify-between text-xs text-gray-500 mb-3 font-medium">
                <span class="bg-gray-50 border border-gray-200 px-2 py-1 rounded">{{ currency() }}<span id="minPriceDisplay">{{ $filterMin }}</span></span>
                <span class="text-gray-300">—</span>
                <span class="bg-gray-50 border border-gray-200 px-2 py-1 rounded">{{ currency() }}<span id="maxPriceDisplay">{{ $filterMax }}</span></span>
              </div>
              <button type="submit"
                class="w-full bg-primary hover:bg-gray-900 text-white text-xs font-bold py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2">
                Apply Filter <i class="fas fa-arrow-right text-xs"></i>
              </button>
            </div>
          </div>

          {{-- Categories --}}
          <div class="sidebar-section">
            <h3 class="sidebar-section__title" onclick="toggleSection('catSection')">
              Categories
              <i class="fas fa-chevron-up text-xs text-gray-400 transition-transform duration-200" id="catSectionIcon"></i>
            </h3>
            <div id="catSection" class="space-y-0.5">
              @foreach($allCategories as $cat)
              <div>
                <div class="flex items-center justify-between group rounded-lg hover:bg-gray-50 px-1 transition-colors">
                  <a href="{{ route('products', ['category' => $cat->id]) }}"
                    class="flex items-center gap-2 py-2 text-sm flex-1 transition-colors
                      {{ request('category') == $cat->id ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary' }}">
                    @if($cat->image)
                      <img src="{{ Storage::url($cat->image) }}" class="w-5 h-5 rounded-full object-cover flex-shrink-0 ring-1 ring-gray-100">
                    @else
                      <span class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-tag text-[8px] text-primary"></i>
                      </span>
                    @endif
                    <span class="truncate">{{ \App\Helpers\TranslateHelper::translate($cat->name) }}</span>
                  </a>
                  @if($cat->subCategories->count() > 0)
                    <button type="button" onclick="toggleSubCat('sub-{{ $cat->id }}')"
                      class="p-1.5 text-gray-400 hover:text-primary transition-colors">
                      <i class="fas fa-chevron-right text-[10px] sub-icon-{{ $cat->id }}
                        {{ request('category') == $cat->id ? 'rotate-90' : '' }} transition-transform duration-200"></i>
                    </button>
                  @endif
                </div>

                @if($cat->subCategories->count() > 0)
                <div id="sub-{{ $cat->id }}"
                  class="ml-6 mt-0.5 space-y-0.5 border-l-2 border-gray-100 pl-3
                    {{ request('category') == $cat->id || (request()->sub_category && $cat->subCategories->pluck('id')->contains(request('sub_category'))) ? 'block' : 'hidden' }}">
                  @foreach($cat->subCategories as $sub)
                    <a href="{{ route('products', ['sub_category' => $sub->id]) }}"
                      class="block py-1.5 text-xs transition-colors truncate rounded px-1
                        {{ request('sub_category') == $sub->id ? 'text-primary font-semibold' : 'text-gray-500 hover:text-primary' }}">
                      {{ \App\Helpers\TranslateHelper::translate($sub->name) }}
                    </a>
                  @endforeach
                </div>
                @endif
              </div>
              @endforeach
            </div>
          </div>

        </form>
      </aside>

      {{-- ══ PRODUCTS GRID ════════════════════════════ --}}
      <div class="flex-1 min-w-0">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-5">
          <div>
            <h1 class="text-lg md:text-2xl font-black text-gray-900">
              {{ \App\Helpers\TranslateHelper::translate($categoryName) }}
            </h1>
            <p class="text-xs text-gray-400 mt-0.5">
              {{ $products->count() }} {{ $products->count() == 1 ? \App\Helpers\TranslateHelper::translate('product') : \App\Helpers\TranslateHelper::translate('products') }} found
            </p>
          </div>
        </div>

        @if($products->isEmpty())
          <div class="bg-white rounded-xl p-16 text-center shadow-sm border border-gray-100">
            <i class="fas fa-box-open text-5xl text-gray-200 mb-4"></i>
            <p class="text-gray-400 font-medium text-sm">No products found.</p>
            <a href="{{ route('products') }}" class="mt-4 inline-block text-primary hover:underline text-sm font-semibold">
              Clear filters
            </a>
          </div>
        @else
          <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-3 md:gap-4">
            @foreach ($products as $item)
            @php
              $discount = ($item->regular_price > 0 && $item->sale_price < $item->regular_price)
                ? round((($item->regular_price - $item->sale_price) / $item->regular_price) * 100) : 0;
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 flex flex-col group h-[330px] md:h-[550px] mx-2">

                {{-- Product Image --}}
                <a href="{{ route('product.single', $item->slug) }}" class="w-full h-48 md:h-[380px] bg-gray-100 relative overflow-hidden block">
        
                  {{-- Primary Image --}}
                  <img src="{{ Storage::url($item->featured_image_1) }}"
                    alt="{{ $item->name }}"
                    class="absolute inset-0 w-full h-full object-fill transition-transform duration-700 ease-in-out group-hover:scale-110 group-hover:opacity-0"
                    onerror="this.src='https://via.placeholder.com/500x500/e5e7eb/6b7280?text=Product'" />
        
                  {{-- Hover Image --}}
                  @if($item->featured_image_2)
                  <img src="{{ Storage::url($item->featured_image_2) }}"
                    alt="{{ $item->name }}"
                    class="absolute inset-0 w-full h-full object-fill transition-transform duration-700 ease-in-out scale-110 opacity-0 group-hover:opacity-100 group-hover:scale-100"
                    onerror="this.src='https://via.placeholder.com/500x500/e5e7eb/6b7280?text=Product'" />
                  @endif
        
                </a>
        
                {{-- Product Info --}}
                <div class="p-3 md:p-5 flex flex-col flex-grow">
                  <a href="{{ route('product.single', $item->slug) }}">
                    <h3 class="text-sm md:text-lg text-gray-800 mb-2 line-clamp-1 group-hover:text-primary transition-colors" style="font-weight: 500">
                      {{ \App\Helpers\TranslateHelper::translate($item->name) }}
                    </h3>
                  </a>
        
                  <div class="mt-auto">
                    <div class="flex items-center gap-1 md:gap-2 mb-2 md:mb-3">
                        <p class="text-base text-gray-900">
                          {{ currency() }} {{ number_format($item->sale_price, 2) }}
                        </p>
                        @if($item->regular_price > $item->sale_price)
                        <p class="text-xs md:text-sm text-red-400 line-through">
                          {{ currency() }} {{ number_format($item->regular_price, 2) }}
                        </p>
                        @endif
                      </div>
        
                    <button type="button"
                      class="orders-now w-full bg-primary hover:bg-black text-white py-2 md:py-3 rounded-lg flex items-center justify-center gap-2 transition-all duration-300 font-bold text-xs md:text-base"
                      data-id="{{ $item->id }}"
                      data-name="{{ $item->name }}"
                      data-slug="{{ $item->slug }}"
                      data-image="{{ Storage::url($item->featured_image_1) }}"
                      data-price="{{ $item->sale_price }}"
                      data-has-variant="{{ $item->variants->count() > 0 ? '1' : '0' }}">
                      <i class="fa-solid fa-cart-shopping"></i>
                      {{ \App\Helpers\TranslateHelper::translate('Buy Now') }}
                    </button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

      </div>
    </div>
  </div>
</section>

<script>
// ── Price Range Slider ──────────────────────────────
(function () {
    const minSlider  = document.getElementById('priceMinSlider');
    const maxSlider  = document.getElementById('priceMaxSlider');
    const minDisplay = document.getElementById('minPriceDisplay');
    const maxDisplay = document.getElementById('maxPriceDisplay');
    const range      = document.getElementById('sliderRange');
    if (!minSlider) return;

    function updateSlider() {
        const min   = parseInt(minSlider.value);
        const max   = parseInt(maxSlider.value);
        const total = parseInt(minSlider.max);
        if (min > max) { minSlider.value = max; return; }
        minDisplay.textContent = min;
        maxDisplay.textContent = max;
        const l = (min / total) * 100;
        const r = (max / total) * 100;
        range.style.left  = l + '%';
        range.style.width = (r - l) + '%';
    }

    minSlider.addEventListener('input', updateSlider);
    maxSlider.addEventListener('input', updateSlider);
    updateSlider();
})();

// ── Toggle Sidebar Sections ─────────────────────────
function toggleSection(id) {
    const el   = document.getElementById(id);
    const icon = document.getElementById(id + 'Icon');
    if (!el) return;
    el.classList.toggle('hidden');
    if (icon) icon.classList.toggle('rotate-180');
}

// ── Toggle Subcategory List ─────────────────────────
function toggleSubCat(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.toggle('hidden');
    const catId = id.replace('sub-', '');
    document.querySelectorAll('.sub-icon-' + catId).forEach(i => i.classList.toggle('rotate-90'));
}
</script>

@endsection