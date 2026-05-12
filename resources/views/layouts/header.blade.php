<!-- header section  -->
    <!-- ══════════════════ TOP INFO BAR ══════════════════ -->
    <!-- OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ════ LEFT SIDEBAR ════ -->
    <div class="left-sidebar" id="leftSidebar">
        <div class="left-sidebar-header">
            <span>Menu</span>
            <button class="left-sidebar-close" id="leftSidebarClose"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="left-sidebar-body">
            <a class="menu-item" href="#"><i class="fa-solid fa-house"></i> Home</a>
            <a class="menu-item" href="#"><i class="fa-solid fa-leaf"></i> Products</a>
            <a class="menu-item" href="#"><i class="fa-solid fa-jar"></i> Honey</a>
            <a class="menu-item" href="#"><i class="fa-solid fa-seedling"></i> Herbal</a>
            <a class="menu-item" href="#"><i class="fa-solid fa-star"></i> Best Sellers</a>
            <a class="menu-item" href="#"><i class="fa-solid fa-tag"></i> Offers</a>
            <a class="menu-item" href="#"><i class="fa-solid fa-location-dot"></i> Order Tracking</a>
            <a class="menu-item" href="#"><i class="fa-solid fa-phone"></i> Contact Us</a>
            <div class="left-sidebar-contact">
                <i class="fa-solid fa-phone me-2" style="color:#25b672;"></i> 09678812525
            </div>
        </div>
    </div>

    <!-- ════ RIGHT SIDEBAR (CART) ════ -->
    <div class="right-sidebar" id="rightSidebar">

        <!-- Header -->
        <div class="cart-sidebar-header">
            <button class="back-btn" id="cartSidebarClose">
                <i class="fa-solid fa-arrow-left"></i> Continue Shopping
            </button>
            <h5>Your Cart</h5>
            <div class="cart-count-circle">1</div>
        </div>

        <!-- Body -->
        <div class="cart-sidebar-body">

            <!-- Cart Item -->
            <div class="cart-item">
                <div class="cart-item-img">
                    <svg viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="60" height="60" fill="#f0ede0" />
                        <rect x="18" y="8" width="10" height="36" rx="3" fill="#c8a84b" />
                        <rect x="30" y="8" width="10" height="36" rx="3" fill="#b8942f" />
                        <rect x="15" y="6" width="30" height="8" rx="2" fill="#a0861f" />
                    </svg>
                </div>
                <div class="cart-item-info">
                    <div class="item-name">লিচু ফুলের মধু - ২ কেজি</div>
                    <div class="qty-controls">
                        <button onclick="changeQty(-1)">−</button>
                        <div class="qty-num" id="qtyNum">1</div>
                        <button onclick="changeQty(1)">+</button>
                    </div>
                </div>
                <div class="cart-item-right">
                    <button class="delete-btn"><i class="fa-solid fa-trash"></i></button>
                    <div class="cart-item-price">৳1,050</div>
                </div>
            </div>

            <!-- You'll Also Love -->
            <div class="also-love-section">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="section-title">You'll also love</div>
                    <div class="also-love-nav d-flex gap-2">
                        <button id="scrollLeft"><i class="fa-solid fa-chevron-left"></i></button>
                        <button id="scrollRight"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Product cards -->
            <div class="love-products-scroll" id="loveScroll">

                <div class="love-card">
                    <div class="love-card-img">
                        <svg viewBox="0 0 155 125" xmlns="http://www.w3.org/2000/svg">
                            <rect width="155" height="125" fill="#f0ede0" />
                            <rect x="52" y="28" width="50" height="62" rx="3" fill="#c8a84b" />
                            <rect x="52" y="28" width="50" height="11" rx="2" fill="#a0861f" />
                            <text x="58" y="50" font-size="7" fill="#fff" font-family="sans-serif"
                                font-weight="bold">NATURO</text>
                            <rect x="18" y="42" width="26" height="58" rx="6" fill="#d4a035" />
                            <rect x="23" y="35" width="16" height="11" rx="3" fill="#a0761f" />
                            <rect x="110" y="42" width="26" height="58" rx="6" fill="#e8b840" />
                            <rect x="115" y="35" width="16" height="11" rx="3" fill="#a0761f" />
                        </svg>
                    </div>
                    <div class="love-card-actions">
                        <button><i class="fa-regular fa-eye"></i></button>
                        <button><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                    <div class="love-card-name">কালোজিরা ও ধনিয়া ফুলের মধুর কম্বো |</div>
                </div>

                <div class="love-card">
                    <div class="love-card-img">
                        <svg viewBox="0 0 155 125" xmlns="http://www.w3.org/2000/svg">
                            <rect width="155" height="125" fill="#f0ede0" />
                            <rect x="52" y="28" width="50" height="62" rx="3" fill="#b8942f" />
                            <rect x="52" y="28" width="50" height="11" rx="2" fill="#8a6e1a" />
                            <text x="58" y="50" font-size="7" fill="#fff" font-family="sans-serif"
                                font-weight="bold">NATURO</text>
                            <rect x="18" y="42" width="26" height="58" rx="6" fill="#c49030" />
                            <rect x="23" y="35" width="16" height="11" rx="3" fill="#8a6e1a" />
                            <rect x="110" y="42" width="26" height="58" rx="6" fill="#d4a840" />
                            <rect x="115" y="35" width="16" height="11" rx="3" fill="#8a6e1a" />
                        </svg>
                    </div>
                    <div class="love-card-actions">
                        <button><i class="fa-regular fa-eye"></i></button>
                        <button><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                    <div class="love-card-name">কালোজিরা ও লিচু ফুলের মধুর কম্বো |</div>
                </div>

                <div class="love-card">
                    <div class="love-card-img">
                        <svg viewBox="0 0 155 125" xmlns="http://www.w3.org/2000/svg">
                            <rect width="155" height="125" fill="#f0ede0" />
                            <rect x="52" y="28" width="50" height="62" rx="3" fill="#d4b050" />
                            <rect x="52" y="28" width="50" height="11" rx="2" fill="#a08030" />
                            <text x="58" y="50" font-size="7" fill="#fff" font-family="sans-serif"
                                font-weight="bold">NATURO</text>
                            <rect x="18" y="42" width="26" height="58" rx="6" fill="#e0b840" />
                            <rect x="23" y="35" width="16" height="11" rx="3" fill="#a08030" />
                            <rect x="110" y="42" width="26" height="58" rx="6" fill="#c8a030" />
                            <rect x="115" y="35" width="16" height="11" rx="3" fill="#a08030" />
                        </svg>
                    </div>
                    <div class="love-card-actions">
                        <button><i class="fa-regular fa-eye"></i></button>
                        <button><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                    <div class="love-card-name">সুন্দরবন ও কালোজিরা মধুর কম্বো |</div>
                </div>

            </div>

        </div><!-- /cart-sidebar-body -->

        <!-- Footer -->
        <div class="cart-sidebar-footer">
            <div class="cart-total-row">
                <span class="label">Total</span>
                <span class="amount">৳1,050</span>
            </div>
            <button class="order-btn">অর্ডার করুন</button>
        </div>

    </div>

    <!-- ════ TOP INFO BAR ════ -->
    <div class="top-bar d-none d-md-block">
        <div class="d-flex justify-content-between align-items-center">
            <a href="tel:{{ $setting->phone_one }}" class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-phone fa-sm"></i><span>{{ $setting->phone_one }}</span>
            </a>
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="fa-solid fa-wand-sparkles fa-sm"></i>
                <span>{{ $setting->blogs_description }}</span>
            </div>
            <a href="tel:{{ $setting->phone_one }}" class="d-flex align-items-center gap-2 fw-semibold">
                <i class="fa-regular fa-circle-question fa-sm"></i><span>Customer Help</span>
            </a>
        </div>
    </div>

    <!-- ════ MAIN NAV ════ -->
    <nav class="main-nav">
        <div class="inner">

            <!-- Hamburger (mobile) -->
            <button class="hamburger-btn mobile-only" id="hamburgerBtn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Logo -->
            <a class="nav-logo" href="/">
                <img src="{{ Storage::url($setting->header_logo) }}" alt="{{ $setting->company_name }}" height="40"
                    style="object-fit: contain;" />
            </a>

            <!-- Search (desktop) -->
            <div class="search-wrapper desktop-only ms-5" style="position: relative;">
    <i class="fa-solid fa-magnifying-glass search-icon"></i>
    <input type="text" id="searchInput" placeholder="Search in Naturo..." autocomplete="off" />
    <button class="search-clear-btn" id="searchClearBtn" aria-label="Clear"><i class="fa-solid fa-xmark"></i></button>
    <div id="searchResults" role="listbox" aria-label="Search results"></div>
</div>

            <div class="ms-auto d-flex align-items-center gap-2">
                <!-- Cart (desktop) -->
                <button class="cart-btn desktop-only me-3" id="cartBtnDesktop">
                    <div class="cart-icon-wrap">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="badge-count">1</span>
                    </div>
                    <span class="ms-1">Cart</span>
                </button>

                <!-- Order Track (desktop) -->
                <a href="#" class="track-btn desktop-only">
                    <div class="track-icon-box">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Order</span><span>Track</span>
                    </div>
                </a>
            </div>
            <!-- Mobile right icons -->
            <div class="mobile-only ms-auto d-flex align-items-center gap-3">
                <button class="cart-btn" id="cartBtnMobile">
                    <div class="cart-icon-wrap">
                        <i class="fa-solid fa-cart-shopping" style="font-size:22px;"></i>
                        <span class="badge-count">1</span>
                    </div>
                </button>
                <!-- <a href="#" class="track-btn">
                    <div class="track-icon-box">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Order</span><span>Track</span>
                    </div>
                </a> -->
                <button class="mobile-search-btn" id="mobileSearchBtn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

        </div>
    </nav>

    <!-- Mobile search slide -->
    <div class="mobile-search-bar" id="mobileSearchBar">
        <div class="search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search in Naturo..." />
        </div>
    </div>
    <!-- header section end -->