@extends('layouts.app')
@section('title', 'How To Buy')
@section('content')
<main>
    <section class="container mx-auto px-4 py-12 md:py-16">

        <!-- Page Title -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">How To Order</h1>
            <div class="w-24 h-1 bg-secondary mx-auto mt-4"></div>
        </div>

        <!-- Steps Visual Guide (Images) -->
        @if($data->whereNotNull('image')->count())
        <div class="max-w-6xl mx-auto mb-16">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-{{ $data->count() }} gap-6 md:gap-8">
                @foreach($data as $index => $item)
                    @if($item->image)
                    <div class="text-center">
                        <div class="mb-4">
                            <img src="{{ Storage::url($item->image) }}" alt="Step {{ $index + 1 }}"
                                class="w-full h-24 object-contain mx-auto">
                        </div>
                        <p class="text-sm md:text-base font-semibold text-gray-800">
                            {{ $index + 1 }}. {{ $item->text }}
                        </p>
                    </div>

                    @if(!$loop->last)
                    <div class="hidden lg:flex items-center justify-center -mx-4">
                        <div class="text-gray-400 text-2xl">· · · ·</div>
                    </div>
                    @endif
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Detailed Instructions -->
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8 md:p-12">
            <div class="space-y-6">
                @forelse($data as $index => $item)
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white font-bold">
                            {{ $index + 1 }}
                        </span>
                    </div>
                    <p class="text-gray-700 leading-relaxed pt-1">
                        {{ $item->text }}
                    </p>
                </div>
                @empty
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-info-circle text-3xl mb-3"></i>
                    <p>No instructions available yet.</p>
                </div>
                @endforelse
            </div>
        </div>

    </section>
</main>
@endsection