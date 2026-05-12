@php
    $review = \App\Models\CustomerReview::where('status', 1)->get();
@endphp

<section class="w-full py-12 bg-gray-50">
    <div class="container mx-auto px-4">

        <h2 class="text-2xl md:text-5xl font-bold text-gray-800 text-center mb-10">
            Pleasures From Our Honorable Customers
        </h2>

        @if($review->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($review as $item)
            <div class="bg-white rounded-2xl shadow-sm p-4 flex flex-col hover:shadow-md transition-shadow duration-300">

                {{-- Reviewer Info --}}
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ $item->image ? Storage::url($item->image) : 'https://via.placeholder.com/56x56/e5e7eb/6b7280?text=U' }}"
                        alt="{{ $item->name }}"
                        class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-100 flex-shrink-0" />
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-1">{{ $item->name }}</h4>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star text-sm {{ $i <= $item->star ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- Review Text --}}
                <div class="bg-[#DEEAF1] rounded-xl px-4 py-3 flex-1">
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $item->review_text }}</p>
                </div>

            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-star text-4xl mb-3 opacity-30"></i>
            <p class="text-base">No reviews yet.</p>
        </div>
        @endif

    </div>
</section>