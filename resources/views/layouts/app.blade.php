@php
$setting = \App\Models\Setting::first();
$categories = \App\Models\Category::all();
$facebook = \App\Models\Facebook::first();
$google = \App\Models\Google::first();
$tagmanager = \App\Models\TagManager::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ $setting->favicon ? Storage::url($setting->favicon) : asset('/assets/img/null.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main.css">



    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-{{$google->google_id}}');
    </script>
    <!-- End Google Tag Manager -->


    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-{{$google->google_id}}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    {{-- тЬЕ Google Tag Manager (Head) --}}
    <!--<script>-->
    <!--    window.dataLayer = window.dataLayer || [];-->

    <!--    function gtag() {-->
    <!--        dataLayer.push(arguments);-->
    <!--    }-->
    <!--    gtag('js', new Date());-->
    <!--    gtag('config', '{{$google->google_id}}');-->
    <!--</script>-->

    {{-- тЬЕ Google Analytics --}}
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id={{$google->google_id}}"></script>-->

    {{-- тЬЕ Facebook Pixel --}}
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{$facebook->facebook_id}}');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
            src="https://www.facebook.com/tr?id={{$facebook->facebook_id}}&ev=PageView&noscript=1" />
    </noscript>


    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{$facebook->facebook_id}}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{$facebook->facebook_id}}&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    {{-- тЬЕ Google Tag Manager (for Data Layer events) --}}
    <!--<script>-->
    <!--    (function(w, d, s, l, i) {-->
    <!--        w[l] = w[l] || [];-->
    <!--        w[l].push({-->
    <!--            'gtm.start': new Date().getTime(),-->
    <!--            event: 'gtm.js'-->
    <!--        });-->
    <!--        var f = d.getElementsByTagName(s)[0],-->
    <!--            j = d.createElement(s),-->
    <!--            dl = l != 'dataLayer' ? '&l=' + l : '';-->
    <!--        j.async = true;-->
    <!--        j.src =-->
    <!--            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;-->
    <!--        f.parentNode.insertBefore(j, f);-->
    <!--    })(window, document, 'script', 'dataLayer', '{{$tagmanager->tag_id}}');-->
    <!--</script>-->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$tagmanager->tag_id}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '{{$tagmanager->tag_id}}');
    </script>

</head>

<body>

    {{-- тЬЕ Google Tag Manager (Body) --}}
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{$tagmanager->tag_id}}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')



    <!-- тЬЕ jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




    <script>
        function updateVariantInfo(variantId) {
            let variantOption = document.querySelector(`option[value='${variantId}']`);
            if (variantOption) {
                let price = variantOption.dataset.price;
                let stock = variantOption.dataset.stock;
                document.getElementById('variant-price').innerText = price;
                document.getElementById('variant-stock').innerText = stock;
            }
        }

        const colorSelect = document.getElementById('variant-color');
        const sizeSelect = document.getElementById('variant-size');

        if (colorSelect) {
            colorSelect.addEventListener('change', function() {
                updateVariantInfo(this.value);
            });
        }

        if (sizeSelect) {
            sizeSelect.addEventListener('change', function() {
                updateVariantInfo(this.value);
            });
        }
    </script>

    <script>
        $(document).ready(function() {

            var $qty = $('#qty');
            var stock = parseInt($('#variant-stock').text()) || 100;

            function updateVariant() {
                var colorOpt = $('#variant-color option:selected');
                var sizeOpt = $('#variant-size option:selected');

                var price = (sizeOpt.data('price') || colorOpt.data('price')) || parseFloat($('#variant-price').text());
                var stockVal = (sizeOpt.data('stock') || colorOpt.data('stock')) || stock;

                $('#variant-price').text(price);
                $('#variant-stock').text(stockVal);
                stock = stockVal;
                if (parseInt($qty.val()) > stock) $qty.val(stock);
            }

            $('#increment').click(function() {
                var val = parseInt($qty.val()) || 1;
                if (val < stock) $qty.val(val + 1);
            });
            $('#decrement').click(function() {
                var val = parseInt($qty.val()) || 1;
                if (val > 1) $qty.val(val - 1);
            });
            $qty.on('input', function() {
                var val = parseInt($qty.val()) || 1;
                if (val < 1) $qty.val(1);
                if (val > stock) $qty.val(stock);
            });

            $('#variant-color, #variant-size').change(updateVariant);

            $('#add-to-cart').click(function() {
                var productId = $(this).data('product-id');
                var productName = $(this).data('name');
                var productSlug = $(this).data('slug');
                var image = $(this).data('image');
                var quantity = parseInt($('#qty').val()) || 1;
                var affiliateId = $(this).data('affiliate-id');

                var colorOpt = $('#variant-color option:selected');
                var sizeOpt = $('#variant-size option:selected');
                var price = 0,
                    color = '',
                    size = '',
                    stock = parseInt($('#variant-stock').text()) || 100;

                if (colorOpt.length || sizeOpt.length) {
                    price = parseFloat(sizeOpt.data('price') || colorOpt.data('price') || $('#variant-price').text()) || 0;
                    stock = parseInt(sizeOpt.data('stock') || colorOpt.data('stock') || stock);
                    color = colorOpt.text() || '';
                    size = sizeOpt.text() || '';
                } else {
                    price = parseFloat($(this).data('price')) || 0;
                }

                if (quantity > stock) {
                    alert('Quantity exceeds stock!');
                    return;
                }

                var cart = JSON.parse(localStorage.getItem('cart')) || [];
                var existing = cart.find(item => item.productId == productId && item.color == color && item.size == size);

                if (existing) {
                    existing.quantity += quantity;
                    if (existing.quantity > stock) existing.quantity = stock;
                } else {
                    cart.push({
                        productId: productId,
                        name: productName,
                        slug: productSlug,
                        image: image,
                        color: color,
                        size: size,
                        price: price,
                        quantity: quantity,
                        affiliateId: affiliateId
                    });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                toastr.success(productName + " added to cart successfully!");
                window.location.href = "{{ route('checkout') }}";
            });

        });
    </script>

    <!-- Desktop search -->
    
<script>
    $(document).ready(function () {
    const $input      = $('#searchInput');
    const $results    = $('#searchResults');
    const $clearBtn   = $('#searchClearBtn');
    let typingTimer;
    let activeIdx = -1;
    const DELAY = 300;

    /* --- Input handler --- */
    $input.on('input', function () {
        clearTimeout(typingTimer);
        const q = $(this).val().trim();
        $clearBtn.css('display', q ? 'flex' : 'none');

        if (q.length < 2) { hideResults(); return; }

        showLoader();
        typingTimer = setTimeout(() => performSearch(q), DELAY);
    });

    /* --- Clear button --- */
    $clearBtn.on('click', function () {
        $input.val('').trigger('input').focus();
    });

    /* --- Keyboard navigation --- */
    $input.on('keydown', function (e) {
        const $items = $results.find('.search-result-item');
        if (!$items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIdx = (activeIdx + 1) % $items.length;
            $items.removeClass('active').eq(activeIdx).addClass('active');
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIdx = (activeIdx - 1 + $items.length) % $items.length;
            $items.removeClass('active').eq(activeIdx).addClass('active');
        } else if (e.key === 'Enter' && activeIdx >= 0) {
            window.location.href = $items.eq(activeIdx).attr('href');
        } else if (e.key === 'Escape') {
            hideResults();
        }
    });

    /* --- Outside click --- */
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-wrapper').length) hideResults();
    });

    /* --- Core functions --- */
    function performSearch(query) {
        $.ajax({
            url: "{{ route('product.liveSearch') }}",
            method: 'GET',
            data: { q: query },
            success: res => renderResults(res),
            error: () => hideResults()
        });
    }

    function showLoader() {
        $results.html(
            '<div class="search-loader">' +
            '<div class="dots"><span></span><span></span><span></span></div>' +
            '</div>'
        ).addClass('visible');
    }

    function renderResults(products) {
        $results.empty();
        activeIdx = -1;

        if (!products.length) {
            $results.html('<div class="search-empty">কোনো পণ্য পাওয়া যায়নি।</div>').addClass('visible');
            return;
        }

        products.forEach(function (product) {
            const hasSale   = parseFloat(product.sale_price) < parseFloat(product.regular_price);
            const salePrice = parseFloat(product.sale_price).toFixed(0);
            const regPrice  = parseFloat(product.regular_price).toFixed(0);
            const url       = "{{ url('product') }}/" + product.slug;
            const imgSrc    = product.featured_image_1
                ? '/storage/' + product.featured_image_1
                : 'https://via.placeholder.com/48x48/e1f5ee/0f6e56?text=' + encodeURIComponent(product.name[0]);
            const brand     = product.brand ? product.brand.name : '';

            const html = `
                <a href="${url}" class="search-result-item">
                    <img src="${imgSrc}" alt="${product.name}" />
                    <div class="search-result-body">
                        ${brand ? `<div class="search-result-brand">${brand}</div>` : ''}
                        <div class="search-result-name">${product.name}</div>
                    </div>
                    <div class="search-result-price">
                        ${hasSale ? `<div class="old-price">৳${regPrice}</div>` : ''}
                        <div class="new-price">৳${salePrice}</div>
                    </div>
                </a>`;

            $results.append(html);
        });

        $results.addClass('visible');
    }

    function hideResults() {
        $results.removeClass('visible');
        activeIdx = -1;
    }
});
</script>

    <!-- Mobile search -->
    <script>
        $(document).ready(function() {
            let $searchInputMobile = $('#searchInputMobile');
            let $searchResultsMobile = $('#searchResultsMobile');
            let typingTimer;
            const doneTypingInterval = 300;

            $searchInputMobile.on('keyup', function() {
                clearTimeout(typingTimer);
                let query = $(this).val().trim();
                if (query.length > 1) {
                    typingTimer = setTimeout(() => performSearchMobile(query), doneTypingInterval);
                } else {
                    $searchResultsMobile.addClass('hidden').empty();
                }
            });

            function performSearchMobile(query) {
                $.ajax({
                    url: "{{ route('product.liveSearch') }}",
                    method: "GET",
                    data: {
                        q: query
                    },
                    success: res => renderResultsMobile(res),
                    error: () => $searchResultsMobile.addClass('hidden').empty()
                });
            }

            function renderResultsMobile(products) {
                $searchResultsMobile.empty();

                if (!products.length) {
                    $searchResultsMobile.removeClass('hidden').html(
                        '<p class="p-4 text-gray-400 text-sm text-center">No products found.</p>'
                    );
                    return;
                }

                products.forEach(function(product) {
                    const salePrice = parseFloat(product.sale_price).toFixed(2);
                    const regularPrice = parseFloat(product.regular_price).toFixed(2);
                    const url = "{{ url('product') }}/" + product.slug;
                    const imgSrc = product.featured_image_1 ?
                        "/storage/" + product.featured_image_1 :
                        'https://via.placeholder.com/56x56/f3f4f6/9ca3af?text=?';
                    const brandName = product.brand ? product.brand.name : '';
                    const hasSale = parseFloat(product.sale_price) < parseFloat(product.regular_price);

                    const html = `
                    <a href="${url}"
                       class="flex items-center gap-3 px-3 py-2.5 border-b border-gray-100 hover:bg-gray-50 transition-colors group">
    
                        <div class="w-12 h-12 flex-shrink-0 rounded-lg overflow-hidden border border-gray-100 bg-white">
                            <img src="${imgSrc}" alt="${product.name}"
                                 class="w-full h-full object-cover" />
                        </div>
    
                        <div class="flex-1 min-w-0">
                            ${brandName ? `<p class="text-[10px] font-semibold text-primary uppercase tracking-wide leading-none mb-0.5">${brandName}</p>` : ''}
                            <p class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors leading-snug line-clamp-1">
                                ${product.name}
                            </p>
                        </div>
    
                        <div class="flex-shrink-0 text-right">
                            ${hasSale ? `<p class="text-xs text-gray-400 line-through leading-none mb-0.5">৳${regularPrice}</p>` : ''}
                            <p class="text-sm font-bold text-gray-900 leading-none">৳${salePrice}</p>
                        </div>
                    </a>`;

                    $searchResultsMobile.append(html);
                });

                $searchResultsMobile.removeClass('hidden');
            }

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-container').length) {
                    $searchResultsMobile.addClass('hidden');
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.add-to-wishlist', function(e) {
            e.preventDefault();

            let icon = $(this);
            let productId = icon.data('id');

            $.ajax({
                url: "{{ route('wishlist.store') }}",
                method: "POST",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status === 'error') {
                        toastr.warning(res.message);
                        return;
                    }

                    if (res.status === 'added') {
                        toastr.success(res.message);
                    } else if (res.status === 'removed') {
                        toastr.info(res.message);
                    }

                    setTimeout(() => location.reload(), 800);
                },
                error: function() {
                    toastr.error('Please login to add to wishlist.');
                }
            });
        });

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
    </script>

    <script>
        function goToWishlist() {
            @if(auth()->guard('web')->check())
            window.location.href = "{{ route('wishlist.index') }}";
            @else
            toastr.warning('Please login to view your wishlist.');
            @endif
        }

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        }
    </script>

    <script>
        $(document).on('click', '#accountLink', function() {
            @if(auth()->check())
            window.location.href = "{{ route('dashboard') }}";
            @else
            toastr.info('Please login to access your account.');
            setTimeout(function() {
                window.location.href = "{{ route('login') }}";
            }, 1500);
            @endif
        });
    </script>

    <script>
        @if(Session::has('success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
        toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
        toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('warning'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
        toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if(Session::has('info'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
        toastr.info("{{ Session::get('info') }}");
        @endif
    </script>

    <script>
        function trackProductView(productName, productId, price) {
            dataLayer.push({
                'event': 'view_item',
                'ecommerce': {
                    'items': [{
                        'item_name': productName,
                        'item_id': productId,
                        'price': price
                    }]
                }
            });
        }
    </script>


    <!-- =================== MAIN CART SYSTEM =================== -->
    <script>
        let currency = "{{ currency() }}";

        // ================= PRODUCT QTY =================
        function incrementQuantity(btn) {
            let input = btn.parentElement.querySelector('.product-qty');
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity(btn) {
            let input = btn.parentElement.querySelector('.product-qty');
            let val = parseInt(input.value);
            if (val > 1) input.value = val - 1;
        }

        // ================= ADD TO CART =================
        $(document).on('click', '.orders-now', function(e) {
            e.preventDefault();
            let btn = $(this);

            let qtyInput = btn.closest('.p-4').find('.product-qty');
            let qty = qtyInput.length ? parseInt(qtyInput.val()) : 1;

            let item = {
                productId: btn.data('id'),
                name: btn.data('name'),
                price: parseFloat(btn.data('price')),
                image: btn.data('image'),
                slug: btn.data('slug'),
                quantity: qty,
                color: '',
                size: ''
            };

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let exist = cart.find(p => p.productId === item.productId);

            if (exist) {
                exist.quantity += qty;
            } else {
                cart.push(item);
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            toastr.success(item.name + " added to cart successfully!");

            renderCart();
            toggleCart();
        });

        // ================= RENDER CART =================
        function renderCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let html = '';
            let total = 0;
            let count = 0;

            if (cart.length === 0) {
                html = '<div class="text-center text-gray-500 py-8"><p>Your cart is empty</p></div>';
            } else {
                cart.forEach((item, index) => {
                    total += item.price * item.quantity;
                    count += item.quantity;

                    html += `
     <div class="cart-item mb-3 p-3 bg-white rounded-lg border border-gray-200" data-cart-index="${index}">
        <div class="flex gap-3">
            <div class="relative">
                <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded">
               <button type="button" class="remove-cart-item absolute -top-2 -right-2 w-6 h-6 bg-red-600 hover:bg-red-700 text-white rounded-full flex items-center justify-center transition-colors shadow-md" data-index="${index}"><i class="fas fa-times text-xs"></i></button>
            </div>

            <div class="flex-1">
                <h3 class="font-medium text-gray-800 text-sm mb-1">
                    ${item.name}
                </h3>

                <div class="flex items-center gap-2 mt-2">
                    <button type="button" class="cart-qty-decrease w-6 h-6 rounded border border-gray-300 hover:bg-gray-100 transition-colors flex items-center justify-center" data-index="${index}">-</button>

                    <span class="font-medium w-8 text-center text-sm">
                        ${item.quantity}
                    </span>

                    <button type="button" class="cart-qty-increase w-6 h-6 rounded border border-gray-300 hover:bg-gray-100 transition-colors flex items-center justify-center" data-index="${index}">+</button>
                </div>

                <p class="text-red-600 font-bold mt-2 text-sm">
                    ${item.quantity} × ${currency} ${item.price.toFixed(2)}
                </p>
            </div>
        </div>
     </div>`;
                });
            }

            // Update all cart displays
            $('#cartItems').html(html);
            $('#cartItems1').html(html);
            $('#subtotal').text(currency + ' ' + total.toFixed(2));
            $('#cartTotal').text(currency + ' ' + total.toFixed(2));
            $('#cartItemCount').text(count);
            $('#shopingcart').text(count);
            $('#sidebarcartTotal').text(count + ' items');
            $('#footerCartTotal').text(count);
            $('#sidebarcartTotalAmount').text(currency + ' ' + total.toFixed(2));

            // Show/hide empty message
            if (count === 0) {
                $('#emptyCartMessage').removeClass('hidden');
            } else {
                $('#emptyCartMessage').addClass('hidden');
            }
        }

        // ================= EVENT DELEGATION FOR CART BUTTONS =================
        $(document).on('click', '.remove-cart-item', function(e) {
            e.preventDefault();
            e.stopPropagation();

            let index = parseInt($(this).data('index'));
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (cart[index]) {
                let removedItem = cart[index];
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));

                toastr.info(removedItem.name + " removed from cart!");
                renderCart();
            }
        });

        $(document).on('click', '.cart-qty-decrease', function(e) {
            e.preventDefault();
            e.stopPropagation();

            let index = parseInt($(this).data('index'));
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (cart[index]) {
                cart[index].quantity -= 1;

                if (cart[index].quantity <= 0) {
                    let removedItem = cart[index];
                    cart.splice(index, 1);
                    toastr.info(removedItem.name + " removed from cart!");
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }
        });

        $(document).on('click', '.cart-qty-increase', function(e) {
            e.preventDefault();
            e.stopPropagation();

            let index = parseInt($(this).data('index'));
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (cart[index]) {
                cart[index].quantity += 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }
        });

        // ================= TOGGLE =================
        function toggleCart() {
            const sidebar = document.getElementById('cartSidebar');
            if (sidebar) {
                sidebar.classList.toggle('translate-x-full');
            }
        }

        // ================= INIT =================
        $(document).ready(function() {
            renderCart();
        });
    </script>
    <script src="{{asset('assets/js/main.js')}}"></script>


    @yield('script')

</body>

</html>