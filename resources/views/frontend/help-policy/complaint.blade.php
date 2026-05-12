
@extends('layouts.app')
@section('title', 'Submit Complain')

@section('content')

 

    <!-- Customer Complaint Section -->
    <section class="container mx-auto px-4 py-12 md:py-16">

      <!-- Page Title -->
      <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{$setting->complain_title}}</h1>
        <p class="text-gray-600 text-lg">{{$setting->complain_description}}</p>
        <div class="w-24 h-1 bg-secondary mx-auto mt-4"></div>
      </div>

      <div class="container mx-auto">
        <div class="grid lg:grid-cols-2 gap-0 bg-white rounded-2xl shadow-xl overflow-hidden">

          <!-- Left Side - Complaint Form -->
          <div class="p-4 md:p-12">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">SEND US YOUR COMPLAINT</h2>
            
           @if(session('success'))
            <div id="successMessage" class="bg-green-50 border-l-4 border-green-500 rounded-xl px-6 py-5 mb-8 shadow-sm flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="font-bold text-green-800 text-lg mb-1">Complaint Submitted Successfully!</p>
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    <p class="text-green-600 text-xs mt-2">
                        <i class="fas fa-clock me-1"></i>
                        Our team will get back to you within 24 hours.
                    </p>
                </div>
            </div>
          @endif    

            <form action="{{route('complaint.store')}}" method="POST" class="space-y-6">
                @csrf
              <!-- Name -->
              <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                  Your Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name"
                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-secondary transition-colors">
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                  Your Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" required placeholder="example@email.com"
                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-secondary transition-colors">
              </div>

              <!-- Mobile Number -->
              <div>
                <label for="mobile" class="block text-sm font-semibold text-gray-700 mb-2">
                  Mobile Number <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="phone" name="phone" required placeholder="017********"
                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-secondary transition-colors">
              </div>

              <!-- Order Number (Optional) -->
              <div>
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                  Order Number <span class="text-gray-400 text-xs">(Optional)</span>
                </label>
                <input type="text" id="order_number" name="order_number" placeholder="e.g., #ORD12345"
                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-secondary transition-colors">
              </div>

              <!-- Subject -->
              {{--<div>
                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                  Subject <span class="text-red-500">*</span>
                </label>
                <input type="text" id="subject" name="subject" required
                  placeholder="Brief description of your complaint"
                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-secondary transition-colors">
              </div>--}}

              <!-- Message -->
              <div>
                <label for="complaint" class="block text-sm font-semibold text-gray-700 mb-2">
                  Your Complaint <span class="text-red-500">*</span>
                </label>
                <textarea id="complaint" name="complaint"  rows="5"
                  placeholder="Please describe your complaint in detail..."
                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-secondary transition-colors resize-none"></textarea>
              </div>

              <!-- Submit Button -->
              <button type="submit"
                class="w-full bg-primary hover:bg-secondary/90 text-white font-bold py-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane"></i>
                SUBMIT COMPLAINT
              </button>
            </form>
          </div>

          <!-- Right Side - Contact Information -->
          <div class="bg-gradient-to-br from-gray-800 to-gray-900 text-white p-8 md:p-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-8">CONTACT INFORMATION</h2>

            <!-- Address -->
            <div class="mb-8">
              <h3 class="text-lg font-bold mb-3 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-primary"></i>
                Address
              </h3>
              <p class="text-gray-300 leading-relaxed">
               {{$setting->address}}
              </p>
            </div>

            <!-- Phone -->
            <div class="mb-8">
              <h3 class="text-lg font-bold mb-3 flex items-center gap-2">
                <i class="fas fa-phone-alt text-primary"></i>
                Phone
              </h3>
              <a href="tel:+8801774801737" class="text-gray-300 hover:text-secondary transition-colors">
                {{$setting->phone_one}}
              </a>
            </div>

            <!-- Email -->
            <div class="mb-8">
              <h3 class="text-lg font-bold mb-3 flex items-center gap-2">
                <i class="fas fa-envelope text-primary"></i>
                Email
              </h3>
              <a href="mailto:{{$setting->email_one}}" class="text-gray-300 hover:text-secondary transition-colors">
                {{$setting->email_one}}
              </a>
            </div>

            <!-- Working Hours -->
            <div class="mb-8">
              <h3 class="text-lg font-bold mb-3 flex items-center gap-2">
                <i class="fas fa-clock text-primary"></i>
                Working Hours
              </h3>
              <p class="text-gray-300">
                {{$setting->working_day}}<br>
               {{$setting->working_hours}}
              </p>
            </div>

            {{--<div class="border-t border-gray-700 pt-8">
              <p class="text-gray-400 mb-4">
                আপনার সমস্যা সমাধানে আমরা সর্বদা প্রস্তুত। আমাদের সাথে যোগাযোগ করুন এবং আমরা দ্রুত আপনার সাহায্য করব।
              </p>

              <!-- Social Media -->
              <div>
                <p class="text-sm font-semibold mb-3">Follow Us:</p>
                <div class="flex gap-3">
                  <a href="{{$setting->facebook}}" target="_blank"
                    class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition-colors">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                  <a href="{{$setting->youtube}}" target="_blank"
                    class="w-10 h-10 bg-red-600 hover:bg-red-700 rounded-full flex items-center justify-center transition-colors">
                    <i class="fab fa-youtube"></i>
                  </a>
                  <a href="{{$setting->linkedin}}" target="_blank"
                    class="w-10 h-10 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors">
                    <i class="fab fa-linkedin-in"></i>
                  </a> 
                  <a href="https://wa.me/{{$setting->phone_one}}" target="_blank"
                        class="w-10 h-10 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center transition-colors">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
              </div>
            </div>--}}
          </div>

        </div>
      </div>

      <!-- FAQ Section -->
      <div class="max-w-4xl mx-auto mt-16">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Frequently Asked Questions</h2>

        <div class="space-y-4">

             {!! $data->submit_complaint !!}
           
        </div>

    </div>

</section>
    
    



@endsection

@section('script')
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('successMessage');
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endif
@endsection
