@extends('layouts.app')

@section('title', 'Home')

@section('content')


<!-- banner section -->
<section class="banner-section">
  <div class="w-100 position-relative">

    <!-- Bootstrap Carousel -->
    <div id="bannerCarousel" class="carousel slide banner-carousel" data-bs-ride="carousel"
      data-bs-interval="4000">

      <!-- Indicators -->
      <div class="carousel-indicators">
        @foreach($banner as $index => $item)
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $index }}" 
                        class="{{ $index == 0 ? 'active' : '' }}" 
                        aria-current="{{ $index == 0 ? 'true' : 'false' }}" 
                        aria-label="Slide {{ $index + 1 }}"></button>
          @endforeach
      </div>

      <!-- Slides -->
      <div class="carousel-inner">
        @foreach($banner as $index => $item)
        <!-- Slide 1 -->
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
          <img src="{{ Storage::url($item->image) }}"
            alt="{{ $item->title }}" />

        </div>
        @endforeach
      </div><!-- /carousel-inner -->

      <!-- Prev Button -->
      <button class="carousel-control-prev d-flex align-items-center justify-content-center" type="button"
        data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <i class="fa-solid fa-chevron-left"></i>
        <span class="visually-hidden">Previous</span>
      </button>

      <!-- Next Button -->
      <button class="carousel-control-next d-flex align-items-center justify-content-center" type="button"
        data-bs-target="#bannerCarousel" data-bs-slide="next">
        <i class="fa-solid fa-chevron-right"></i>
        <span class="visually-hidden">Next</span>
      </button>

    </div><!-- /carousel -->

    <!-- Blog Badge (same position as original) -->
    <a href="/blog" class="blog-badge" title="Visit our blog area">
      <i class="fa-solid fa-pen-nib"></i>
      <span>Blog</span>
    </a>

  </div>
</section>
<!-- banner end section -->



<!-- main section -->

<!-- category section  -->
<section class="category-section">
  <div class="container">
    <div class="category-scroll-wrapper">
      <div class="category-track" id="catTrack">

        <!-- All -->
         @foreach ($categories as $category)
          
        <div class="cat-item">
          <a class="cat-link" href="{{ route('products', ['category' => $category->id]) }}">
            <div class="cat-icon">
              <img src="{{ Storage::url($category->image) }}"
                alt="{{ $category->name }}" />
            </div>
            <span class="cat-label">{{ $category->name }}</span>
          </a>
        </div>
         @endforeach


      </div>
    </div>
  </div>
</section>
<!-- category section  -->

<!-- best sellers section  -->
<section class="bestsellers-section">
  <div class="container">

    <!-- Header -->
    <div class="section-header">
      <h2 class="section-title">OUR BEST SELLERS</h2>
      <div class="slider-nav">
        <button id="prodPrev" aria-label="Previous">&#8249;</button>
        <button id="prodNext" aria-label="Next">&#8250;</button>
      </div>
    </div>

    <!-- Slider -->
    <div class="product-slider-wrapper">
      <div class="product-track" id="productTrack">

        <!-- Product 1 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/ambor-ashab">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/100gm_KMGhjjwhk.webp"
                alt="আম্বর আশহাব" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/ambor-ashab" style="text-decoration:none;">
                <h3 class="product-name">আম্বর আশহাব | Ambor Ashab</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳2,250</span>
                <span class="price-old">৳3,500</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/lychee-honey-">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/w_KMGifau2.webp"
                alt="লিচু ফুলের মধু" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/lychee-honey-" style="text-decoration:none;">
                <h3 class="product-name">লিচু ফুলের মধু | Lychee Honey</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳1,050</span>
                <span class="price-old">৳1,400</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/lyche-mustard-honey">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/litchi_mustard_2000x2500_KMGlipkx9.webp"
                alt="লিচু ও সরিষা ফুলের মধুর কম্বো" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/lyche-mustard-honey" style="text-decoration:none;">
                <h3 class="product-name">লিচু ও সরিষা ফুলের মধুর কম্বো | Lychee &amp; Mustard Honey
                </h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳1,050</span>
                <span class="price-old">৳1,350</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/mustard-honey-box">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/w_KMGht4ud8.webp"
                alt="সরিষা মধু" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/mustard-honey-box" style="text-decoration:none;">
                <h3 class="product-name">সরিষা মধু | Mustard Honey</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳1,050</span>
                <span class="price-old">৳1,300</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/honey-nut">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1_KMGzq10kr.webp"
                alt="মধুময় বাদাম" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/honey-nut" style="text-decoration:none;">
                <h3 class="product-name">মধুময় বাদাম | Honey Nut</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳1,250</span>
                <span class="price-old">৳1,700</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/classic-honey-combo-2">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/WW_KMG3qle6k.webp"
                alt="ক্লাসিক হানি কম্বো" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/classic-honey-combo-2" style="text-decoration:none;">
                <h3 class="product-name">ক্লাসিক হানি কম্বো | Classic Honey Combo</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳1,400</span>
                <span class="price-old">৳2,000</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 7 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/shilajit-honey">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/01_KMGqke4ig.webp"
                alt="শিলাজিৎ মধু" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/shilajit-honey" style="text-decoration:none;">
                <h3 class="product-name">শিলাজিৎ মধু | Shilajit Honey</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳850</span>
                <span class="price-old">৳1,080</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 8 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/mustard-oil-ghee-combo">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Photo 1_KMGrcqla.webp"
                alt="সরিষার তেল ও ঘি কম্বো" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/mustard-oil-ghee-combo" style="text-decoration:none;">
                <h3 class="product-name">সরিষার তেল ও ঘি (কম্বো) | Mustard Oil and Ghee Combo</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳2,650</span>
                <span class="price-old">৳3,550</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 9 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/miswak-powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/W_KMGkm2rgr.webp"
                alt="মিসওয়াক পাউডার" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/miswak-powder" style="text-decoration:none;">
                <h3 class="product-name">মিসওয়াক পাউডার | Miswak Powder</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳550</span>
                <span class="price-old">৳800</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 10 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/kalogira-rosun-modhu">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Black Seed  Garlic Honye_KMGvlzcd9.webp"
                alt="কালোজিরা রসুন মধু" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/kalogira-rosun-modhu" style="text-decoration:none;">
                <h3 class="product-name">কালোজিরা রসুন মধু | Black Seed Garlic Honey</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳850</span>
                <span class="price-old">৳1,050</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 11 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/pink-salt">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1 KG White_KMG04rthb.webp"
                alt="পিংক সল্ট" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/pink-salt" style="text-decoration:none;">
                <h3 class="product-name">পিংক সল্ট | Pink Salt</h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳550</span>
                <span class="price-old">৳800</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product 12 -->
        <div class="product-slide">
          <div class="product-card">
            <a class="product-img-wrap" href="/product/black-garlik-single-clove">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Black Garlic single_KMGf2gm3.webp"
                alt="ব্লাক গার্লিক সিঙ্গেল ক্লোভ" loading="lazy" />
            </a>
            <div class="product-info">
              <a href="/product/black-garlik-single-clove" style="text-decoration:none;">
                <h3 class="product-name">ব্লাক গার্লিক সিঙ্গেল ক্লোভ | Black Garlic Single Clove
                </h3>
              </a>
              <div class="product-price">
                <span class="price-current">৳1,250</span>
                <span class="price-old">৳1,600</span>
              </div>
            </div>
          </div>
        </div>

      </div><!-- /product-track -->
    </div><!-- /product-slider-wrapper -->

  </div>
</section>
<!-- best sellers section  -->

<!-- product section -->
<!-- ══════════════════════════════
     SUPER FOOD SECTION — HTML
══════════════════════════════ -->
<section class="superfood-section">
  <div class="container">

    <!-- Header -->
    <div class="sf-header">
      <h2 class="sf-title">Super Food</h2>
      <a class="sf-view-more" href="/category/super-food">
        View more
        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="1em"
          width="1em" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M765.7 486.8L314.9 134.7A7.97 7.97 0 0 0 302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 0 0 0-50.4z">
          </path>
        </svg>
      </a>
    </div>

    <!-- Slider -->
    <div class="sf-slider-wrapper">
      <div class="sf-track" id="sfTrack">

        <!-- Product 1: Raisins -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/Raisins">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Raisins A_KMGjqdcxh.webp"
                alt="কিসমিস | Raisins" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/Raisins">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                  viewBox="0 0 512 512" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg>
              </a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg>
              </button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/Raisins">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                  viewBox="0 0 512 512" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg>
              </a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg>
              </button>
            </div>
            <a href="/product/Raisins" style="text-decoration:none;">
              <h3 class="sf-name">কিসমিস | Raisins</h3>
            </a>
            <div class="sf-price">
              <span class="sf-price-current">৳780</span>
              <span class="sf-price-old">৳1,050</span>
            </div>
          </div>
        </div>

        <!-- Product 2: Garlic Honey -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/garlic-honey">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Garlic Honey 1_KMGcnjimf.webp"
                alt="গার্লিক হানি | Garlic Honey" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/garlic-honey"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/garlic-honey"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/garlic-honey" style="text-decoration:none;">
              <h3 class="sf-name">গার্লিক হানি | Garlic Honey</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳700</span><span
                class="sf-price-old">৳850</span></div>
          </div>
        </div>

        <!-- Product 3: Chia Seeds -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/chia-seeds">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1_KMG3khpvs.webp"
                alt="চিয়া সীড বক্স | Boxed Chia Seeds" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/chia-seeds"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/chia-seeds"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/chia-seeds" style="text-decoration:none;">
              <h3 class="sf-name">চিয়া সীড বক্স | Boxed Chia Seeds</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳1,400</span><span
                class="sf-price-old">৳2,200</span></div>
          </div>
        </div>

        <!-- Product 4: Pink Salt -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/pink-salt">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1 KG White_KMG04rthb.webp"
                alt="পিংক সল্ট | Pink Salt" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/pink-salt"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/pink-salt"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/pink-salt" style="text-decoration:none;">
              <h3 class="sf-name">পিংক সল্ট | Pink Salt</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳550</span><span
                class="sf-price-old">৳800</span></div>
          </div>
        </div>

        <!-- Product 5: Pink Salt Jar -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/Pink-Salt-Jar">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Generic Large_KMGkeil46.webp"
                alt="পিংক সল্ট জার | Pink Salt Jar" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/Pink-Salt-Jar"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/Pink-Salt-Jar"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/Pink-Salt-Jar" style="text-decoration:none;">
              <h3 class="sf-name">পিংক সল্ট | Pink Salt</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳650</span><span
                class="sf-price-old">৳950</span></div>
          </div>
        </div>

        <!-- Product 6: Premium Beetroot Powder (Out of Stock) -->
        <div class="sf-slide">
          <div class="sf-card">
            <span class="sf-out-badge">Out of Stock</span>
            <a class="sf-img-wrap" href="/product/Premium-Beetroot-Powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/01_KMGpjsa5m.webp"
                alt="প্রিমিয়াম বিটরুট পাউডার" loading="lazy" />
            </a>
            <a href="/product/Premium-Beetroot-Powder" style="text-decoration:none;">
              <h3 class="sf-name">প্রিমিয়াম বিটরুট পাউডার । Premium Beetroot Powder</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳700</span><span
                class="sf-price-old">৳1,200</span></div>
          </div>
        </div>

        <!-- Product 7: Beetroot Powder (Out of Stock) -->
        <div class="sf-slide">
          <div class="sf-card">
            <span class="sf-out-badge">Out of Stock</span>
            <a class="sf-img-wrap" href="/product/beetroot-powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Beetroot_700 copy_KMGqwnepm.webp"
                alt="বিটরুট পাউডার" loading="lazy" />
            </a>
            <a href="/product/beetroot-powder" style="text-decoration:none;">
              <h3 class="sf-name">বিটরুট পাউডার । Beetroot Powder</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳900</span><span
                class="sf-price-old">৳1,250</span></div>
          </div>
        </div>

        <!-- Product 8: Honey Nut -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/honey-nut">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1_KMGzq10kr.webp"
                alt="মধুময় বাদাম | Honey Nut" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/honey-nut"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/honey-nut"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/honey-nut" style="text-decoration:none;">
              <h3 class="sf-name">মধুময় বাদাম | Honey Nut</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳1,250</span><span
                class="sf-price-old">৳1,700</span></div>
          </div>
        </div>

        <!-- Product 9: Red Sakura Plum -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/Red-Sakura-Plum">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Red Pum A_KMG5m4p78.webp"
                alt="রেড সাকুরা পাম | Red Sakura Plum" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/Red-Sakura-Plum"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/Red-Sakura-Plum"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/Red-Sakura-Plum" style="text-decoration:none;">
              <h3 class="sf-name">রেড সাকুরা পাম | Red Sakura Plum</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳940</span><span
                class="sf-price-old">৳1,350</span></div>
          </div>
        </div>

        <!-- Product 10: Lemon Mix Moringa -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/lemon-mix-moringa-powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Lemon Moringa 01_KMGhozth.webp"
                alt="লেবু মিক্স সজিনা পাতার গুঁড়া" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/lemon-mix-moringa-powder"><svg
                  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/lemon-mix-moringa-powder"><svg
                  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/lemon-mix-moringa-powder" style="text-decoration:none;">
              <h3 class="sf-name">লেবু মিক্স সজিনা পাতার গুঁড়া | Lemon Mix Moringa Powder</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳700</span><span
                class="sf-price-old">৳800</span></div>
          </div>
        </div>

        <!-- Product 11: Seed Shorbot -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/seed-shorbot">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1 KG_KMGy4yi.webp"
                alt="সিড শরবত | Seed Shorbot" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/seed-shorbot"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/seed-shorbot"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/seed-shorbot" style="text-decoration:none;">
              <h3 class="sf-name">সিড শরবত | Seed Shorbot</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳900</span><span
                class="sf-price-old">৳1,200</span></div>
          </div>
        </div>

        <!-- Product 12: Spray Dried Beetroot Powder -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/Spray-Dried-Beetroot-Powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/01_KMG5dpqlvj.webp"
                alt="স্প্রে ড্রাইড বিটরুট পাউডার" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/Spray-Dried-Beetroot-Powder"><svg
                  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/Spray-Dried-Beetroot-Powder"><svg
                  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/Spray-Dried-Beetroot-Powder" style="text-decoration:none;">
              <h3 class="sf-name">স্প্রে ড্রাইড বিটরুট পাউডার । Spray Dried Beetroot Powder</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳1,050</span><span
                class="sf-price-old">৳1,550</span></div>
          </div>
        </div>

      </div><!-- /sf-track -->
    </div><!-- /sf-slider-wrapper -->

  </div>
</section>

<!-- Honey section -->

<!-- ══════════════════════════════
     HONEY SECTION — HTML
══════════════════════════════ -->
<section class="superfood-section">
  <div class="container">

    <!-- Header -->
    <div class="sf-header">
      <h2 class="sf-title">Honey</h2>
      <a class="sf-view-more" href="/category/super-food">
        View more
        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="1em"
          width="1em" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M765.7 486.8L314.9 134.7A7.97 7.97 0 0 0 302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 0 0 0-50.4z">
          </path>
        </svg>
      </a>
    </div>

    <!-- Slider -->
    <div class="sf-slider-wrapper">
      <div class="sf-track sfTrack">

        <!-- Product 1: Raisins -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/Raisins">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Raisins A_KMGjqdcxh.webp"
                alt="কিসমিস | Raisins" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/Raisins">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                  viewBox="0 0 512 512" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg>
              </a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg>
              </button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/Raisins">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                  viewBox="0 0 512 512" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg>
              </a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg>
              </button>
            </div>
            <a href="/product/Raisins" style="text-decoration:none;">
              <h3 class="sf-name">কিসমিস | Raisins</h3>
            </a>
            <div class="sf-price">
              <span class="sf-price-current">৳780</span>
              <span class="sf-price-old">৳1,050</span>
            </div>
          </div>
        </div>

        <!-- Product 2: Garlic Honey -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/garlic-honey">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Garlic Honey 1_KMGcnjimf.webp"
                alt="গার্লিক হানি | Garlic Honey" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/garlic-honey"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/garlic-honey"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/garlic-honey" style="text-decoration:none;">
              <h3 class="sf-name">গার্লিক হানি | Garlic Honey</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳700</span><span
                class="sf-price-old">৳850</span></div>
          </div>
        </div>

        <!-- Product 3: Chia Seeds -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/chia-seeds">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1_KMG3khpvs.webp"
                alt="চিয়া সীড বক্স | Boxed Chia Seeds" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/chia-seeds"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/chia-seeds"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/chia-seeds" style="text-decoration:none;">
              <h3 class="sf-name">চিয়া সীড বক্স | Boxed Chia Seeds</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳1,400</span><span
                class="sf-price-old">৳2,200</span></div>
          </div>
        </div>

        <!-- Product 4: Pink Salt -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/pink-salt">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1 KG White_KMG04rthb.webp"
                alt="পিংক সল্ট | Pink Salt" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/pink-salt"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/pink-salt"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/pink-salt" style="text-decoration:none;">
              <h3 class="sf-name">পিংক সল্ট | Pink Salt</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳550</span><span
                class="sf-price-old">৳800</span></div>
          </div>
        </div>

        <!-- Product 5: Pink Salt Jar -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/Pink-Salt-Jar">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Generic Large_KMGkeil46.webp"
                alt="পিংক সল্ট জার | Pink Salt Jar" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/Pink-Salt-Jar"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/Pink-Salt-Jar"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/Pink-Salt-Jar" style="text-decoration:none;">
              <h3 class="sf-name">পিংক সল্ট | Pink Salt</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳650</span><span
                class="sf-price-old">৳950</span></div>
          </div>
        </div>

        <!-- Product 6: Premium Beetroot Powder (Out of Stock) -->
        <div class="sf-slide">
          <div class="sf-card">
            <span class="sf-out-badge">Out of Stock</span>
            <a class="sf-img-wrap" href="/product/Premium-Beetroot-Powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/01_KMGpjsa5m.webp"
                alt="প্রিমিয়াম বিটরুট পাউডার" loading="lazy" />
            </a>
            <a href="/product/Premium-Beetroot-Powder" style="text-decoration:none;">
              <h3 class="sf-name">প্রিমিয়াম বিটরুট পাউডার । Premium Beetroot Powder</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳700</span><span
                class="sf-price-old">৳1,200</span></div>
          </div>
        </div>

        <!-- Product 7: Beetroot Powder (Out of Stock) -->
        <div class="sf-slide">
          <div class="sf-card">
            <span class="sf-out-badge">Out of Stock</span>
            <a class="sf-img-wrap" href="/product/beetroot-powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Beetroot_700 copy_KMGqwnepm.webp"
                alt="বিটরুট পাউডার" loading="lazy" />
            </a>
            <a href="/product/beetroot-powder" style="text-decoration:none;">
              <h3 class="sf-name">বিটরুট পাউডার । Beetroot Powder</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳900</span><span
                class="sf-price-old">৳1,250</span></div>
          </div>
        </div>

        <!-- Product 8: Honey Nut -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/honey-nut">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1_KMGzq10kr.webp"
                alt="মধুময় বাদাম | Honey Nut" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/honey-nut"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/honey-nut"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/honey-nut" style="text-decoration:none;">
              <h3 class="sf-name">মধুময় বাদাম | Honey Nut</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳1,250</span><span
                class="sf-price-old">৳1,700</span></div>
          </div>
        </div>

        <!-- Product 9: Red Sakura Plum -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/Red-Sakura-Plum">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Red Pum A_KMG5m4p78.webp"
                alt="রেড সাকুরা পাম | Red Sakura Plum" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/Red-Sakura-Plum"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/Red-Sakura-Plum"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/Red-Sakura-Plum" style="text-decoration:none;">
              <h3 class="sf-name">রেড সাকুরা পাম | Red Sakura Plum</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳940</span><span
                class="sf-price-old">৳1,350</span></div>
          </div>
        </div>

        <!-- Product 10: Lemon Mix Moringa -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/lemon-mix-moringa-powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/Lemon Moringa 01_KMGhozth.webp"
                alt="লেবু মিক্স সজিনা পাতার গুঁড়া" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/lemon-mix-moringa-powder"><svg
                  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/lemon-mix-moringa-powder"><svg
                  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/lemon-mix-moringa-powder" style="text-decoration:none;">
              <h3 class="sf-name">লেবু মিক্স সজিনা পাতার গুঁড়া | Lemon Mix Moringa Powder</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳700</span><span
                class="sf-price-old">৳800</span></div>
          </div>
        </div>

        <!-- Product 11: Seed Shorbot -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/seed-shorbot">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/1 KG_KMGy4yi.webp"
                alt="সিড শরবত | Seed Shorbot" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/seed-shorbot"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/seed-shorbot"><svg stroke="currentColor"
                  fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="18"
                  width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/seed-shorbot" style="text-decoration:none;">
              <h3 class="sf-name">সিড শরবত | Seed Shorbot</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳900</span><span
                class="sf-price-old">৳1,200</span></div>
          </div>
        </div>

        <!-- Product 12: Spray Dried Beetroot Powder -->
        <div class="sf-slide">
          <div class="sf-card">
            <a class="sf-img-wrap" href="/product/Spray-Dried-Beetroot-Powder">
              <img src="https://pub-b80211003304448e8a7f0edc480f0608.r2.dev/01_KMG5dpqlvj.webp"
                alt="স্প্রে ড্রাইড বিটরুট পাউডার" loading="lazy" />
            </a>
            <div class="sf-actions">
              <a class="sf-action-btn" href="/product/Spray-Dried-Beetroot-Powder"><svg
                  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <div class="sf-actions-mobile">
              <a class="sf-action-btn" href="/product/Spray-Dried-Beetroot-Powder"><svg
                  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                  height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z">
                  </path>
                  <circle cx="256" cy="256" r="80" fill="none" stroke-miterlimit="10"
                    stroke-width="32"></circle>
                </svg></a>
              <div class="sf-action-divider"></div>
              <button class="sf-action-btn"><svg stroke="currentColor" fill="currentColor"
                  stroke-width="0" viewBox="0 0 24 24" height="18" width="18"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill="none" d="M0 0h24v24H0V0z"></path>
                  <path
                    d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49A.996.996 0 0020.01 4H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z">
                  </path>
                </svg></button>
            </div>
            <a href="/product/Spray-Dried-Beetroot-Powder" style="text-decoration:none;">
              <h3 class="sf-name">স্প্রে ড্রাইড বিটরুট পাউডার । Spray Dried Beetroot Powder</h3>
            </a>
            <div class="sf-price"><span class="sf-price-current">৳1,050</span><span
                class="sf-price-old">৳1,550</span></div>
          </div>
        </div>

      </div><!-- /sf-track -->
    </div><!-- /sf-slider-wrapper -->

  </div>
</section>
<!-- Honey section -->


<div class="we-care-section">
  <h2>WE CARE</h2>
  <p>The More We Care For The Earth, The Better Our Product</p>

  <div class="we-care-images">
    <div class="circle-wrap">
      <img src="https://naturobd.com/image1.png" alt="We care image 1" loading="lazy" />
    </div>
    <div class="circle-wrap">
      <img src="https://naturobd.com/image2.png" alt="We care image 2" loading="lazy" />
    </div>
    <div class="circle-wrap">
      <img src="https://naturobd.com/image3.png" alt="We care image 3" loading="lazy" />
    </div>
    <div class="circle-wrap">
      <img src="https://naturobd.com/image4.png" alt="We care image 4" loading="lazy" />
    </div>
  </div>
</div>
<!-- main section -->

@endsection