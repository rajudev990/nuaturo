@extends('layouts.app')
@section('title','Contact')
@section('content')

<!-- Contact Section -->
<section class="py-12 bg-gray-100">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Get in Touch</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                We would love to hear from you! Send us a message or find us at our office.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-6xl mx-auto">
            <!-- Contact Form -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm">
                <h4 class="text-xl font-semibold text-gray-800 mb-6">Send Us a Message</h4>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="post" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input name="name" type="text" id="name" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                            placeholder="John Doe" required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input name="phone" type="tel" id="phone" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                            placeholder="+880 1234-567890" required>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <input name="subject" type="text" id="subject" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                            placeholder="Subject" required>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea name="message" id="message" rows="5" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none" 
                            placeholder="Your message..." required></textarea>
                    </div>

                    <button type="submit" 
                        class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>Send Message</span>
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm">
                <h4 class="text-xl font-semibold text-gray-800 mb-6">Contact Information</h4>
                
                <div class="space-y-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                        <span class="text-gray-700">{{ $setting->address }}</span>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <i class="fas fa-phone-alt text-primary"></i>
                        <a href="tel:{{ $setting->phone_one }}" class="text-gray-700 hover:text-primary transition-colors">
                            {{ $setting->phone_one }}
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <i class="fas fa-envelope text-primary"></i>
                        <a href="mailto:{{ $setting->email_one }}" class="text-gray-700 hover:text-primary transition-colors">
                            {{ $setting->email_one }}
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <i class="fas fa-clock text-primary"></i>
                        <span class="text-gray-700">Mon – Fri: 9:00 AM – 6:00 PM</span>
                    </div>
                </div>

                <div class="mt-8">
                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Find Us on Map</h5>
                    <div class="rounded-xl overflow-hidden shadow-sm">
                        <iframe src="{{ $setting->google_maps }}"
                            width="100%" height="250" style="border:0;" allowfullscreen=""
                            loading="lazy" class="w-full"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection