@extends('layout.index')
@section('title', 'E-commerce - ' . $pageTitle)
@section('bodyContent')
    <style>
        .btn-primary {
            background-color: #2E7D32 !important;
            border-color: #2E7D32 !important;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.3em 0.5em;
            border-radius: 4px;
        }
    </style>
    <div class="container my-4">
        <div class="row" style="padding-top: 60px;" id="cartRow">
            @php
                $galleryImagesArray = explode(',', $products->product_gallery); // Convert string to array

                $cleanedGalleryImages = array_map(function ($img) {
                    return str_replace('\\', '', $img);
                }, $galleryImagesArray);
            @endphp

            <div class="col-md-6">
                <div class="d-flex" style="overflow: hidden;"> <!-- Prevent auto scroll -->

                    {{-- LEFT: Thumbnails --}}
                    <div class="d-flex flex-column me-3" style="max-height: 500px; overflow-y: auto; width: 80px;">
                        @foreach ($cleanedGalleryImages as $image)
                            <a class="mb-2">
                                <img src="{{ asset(trim($image)) }}" alt="{{ $products->product_name }}" width="70"
                                    height="70" style="object-fit: cover; border: 1px solid #ccc; border-radius: 5px;">
                            </a>
                        @endforeach
                    </div>

                    {{-- RIGHT: Swiper Main Image --}}
                    <div class="flex-grow-1" style="max-width: calc(100% - 100px); overflow: hidden;">
                        <div class="swiper product-gallery-swiper">
                            <div class="swiper-wrapper">
                                @foreach ($cleanedGalleryImages as $image)
                                    <div class="swiper-slide">
                                        <img class="product-carousel-image" src="{{ asset(trim($image)) }}"
                                            alt="{{ $products->product_name }}"
                                            style="width: 100%; object-fit: contain; max-height: 500px;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-6 product-info">
                <h2>{{ $products->product_name }}</h2>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-5 fw-bold text-dark">₹{{ $products->sale_price }}</span>
                        <span class="text-muted text-decoration-line-through">₹{{ $products->mrp_price }}</span>

                        @php
                            $discount = round(
                                (($products->mrp_price - $products->sale_price) / $products->mrp_price) * 100,
                            );
                        @endphp

                        @if ($discount > 0)
                            <span class="badge bg-warning text-dark fw-bold">{{ $discount }}%</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="bi bi-heart{{ $isWishlisted ? '-fill' : '' }} text-primary me-3 wishlist-icon"
                            data-product-id="{{ $products->id }}" style="cursor: pointer;"></i>
                        <i class="bi bi-share text-primary share-icon"
                            data-product-url="{{ route('frontend.product-details', ['id' => $products->id]) }}"
                            style="cursor: pointer;"></i>
                    </div>
                </div>

                <label for="size" style="margin-top: 5px;">Size (kg):</label>
                <select id="size" class="form-select w-50 mb-3 mt-2">
                    <option value="1">1 kg</option>
                    <option value="2">2 kg</option>
                    <option value="5">5 kg</option>
                </select>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce feugiat arcu ut neque fermentum tristique.</p> -->
                <div class="btn-container d-flex flex-nowrap gap-2 justify-content-center">

                    <!-- WhatsApp Button -->
                    <a href="https://wa.me/?text={{ urlencode($products->name) }}" target="_blank"
                        class="btn btn-success d-flex align-items-center justify-content-center px-3 py-2">
                        <i class="fa-brands fa-whatsapp fs-5"></i>
                    </a>

                    <!-- Add to Cart Button / Quantity Controls -->
                    @if (isset($cartItems[$products->id]))
                        <div class="add-to-cart cart-controls-active d-flex align-items-center gap-2"
                            data-product-id="{{ $products->id }}">
                            <button class="qty-btn btn btn-outline-secondary">-</button>
                            <span class="cart-count">{{ $cartItems[$products->id] }}</span>
                            <button class="qty-btn btn btn-outline-secondary">+</button>
                        </div>
                    @else
                        <button class="add-to-cart btn btn-warning px-3 py-2" data-product-id="{{ $products->id }}">Add to
                            Cart</button>
                    @endif

                    <!-- Buy Now Button -->
                    <a href="{{ route('frontend.cart') }}">
                        <button class="btn btn-success btn-lg px-4 py-2">
                            <span>Buy Now</span>
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptJs')
    <script>
        $(document).on('click', '.wishlist-icon', function() {
            let icon = $(this);
            let productId = icon.data('product-id');
            console.log(productId);

            $.ajax({
                url: '/wishlist/toggle',
                method: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'added') {
                        icon.removeClass('bi-heart').addClass('bi-heart-fill');
                    } else if (response.status === 'removed') {
                        icon.removeClass('bi-heart-fill').addClass('bi-heart');
                    }
                }
            });
        });

        $(document).on('click', '.share-icon', function() {
            let url = $(this).data('product-url');

            if (navigator.share) {
                navigator.share({
                    title: 'Check out this product!',
                    url: url
                });
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link copied to clipboard!');
                });
            }
        });

        $(document).on("click", ".add-to-cart", function(e) {
            let button = $(this);
            var isUserCustomer = {{ Auth::check() && Auth::user()->role_id == 2 ? 'true' : 'false' }};
            if (!isUserCustomer) {
                e.preventDefault();
                $('#loginModal').modal('show');
                return;
            }
            // Agar already cart-controls-active hai to kuch mat karo
            if (button.hasClass("cart-controls-active")) return;

            let productId = button.data("product-id");

            $.ajax({
                url: "{{ route('frontend.add-cart') }}",
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    product_id: productId,
                    quantity: 1
                },
                success: function(res) {
                    if (res.success) {
                        button
                            .html(`
                        <button class="qty-btn decrease">-</button>
                        <span class="cart-count">1</span>
                        <button class="qty-btn increase">+</button>
                    `)
                            .addClass("cart-controls-active")
                            .attr("data-product-id", productId); // Reassign
                        updateCartCountUI(res.cartCount); // Update Cart Count
                    }
                },
                error: function(xhr) {
                    console.log("Add Error:", xhr.responseText);
                }
            });
        });

        // Increase Quantity
        $(document).on("click", ".increase", function() {
            let wrapper = $(this).closest(".add-to-cart");
            let productId = wrapper.data("product-id");
            let countSpan = wrapper.find(".cart-count");
            let count = parseInt(countSpan.text());

            let newQty = count + 1;
            countSpan.text(newQty);
            updateCart(productId, newQty);
        });

        // Decrease Quantity
        $(document).on("click", ".decrease", function() {
            let wrapper = $(this).closest(".add-to-cart");
            let productId = wrapper.data("product-id");
            let countSpan = wrapper.find(".cart-count");
            let count = parseInt(countSpan.text());

            if (count > 1) {
                let newQty = count - 1;
                countSpan.text(newQty);
                updateCart(productId, newQty);
            } else {
                // Quantity = 0, remove UI & call delete
                updateCart(productId, 0, wrapper);
            }
        });

        // Update quantity function
        function updateCart(productId, quantity, wrapper = null) {
            $.ajax({
                url: "{{ route('frontend.update-cart') }}",
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    product_id: productId,
                    quantity: quantity
                },
                success: function(res) {
                    if (quantity === 0 && wrapper) {
                        wrapper.replaceWith(
                            `<button class="add-to-cart" data-product-id="${productId}">Add to Cart</button>`
                        );
                    }
                    updateCartCountUI(res.cartCount); // Update Cart Count
                },
                error: function(xhr) {
                    console.log("Update Error:", xhr.responseText);
                }
            });
        }

        // Update cart count on the UI
        function updateCartCountUI(count) {
            let badge = $("#headerCartCount");

            if (count > 0) {
                if (badge.length) {
                    badge.text(count).attr("data-id", count).show();
                } else {
                    $('.bi-cart').after(`
                <span id="headerCartCount" data-id="${count}"
                    class="position-absolute badge rounded-circle bg-success d-flex align-items-center justify-content-center"
                    style="top: 2px; right: 2px; font-size: 12px; width: 18px; height: 18px;">
                    ${count}
                </span>
            `);
                }
            } else {
                badge.remove(); // Agar 0 hai to hata do
            }
        }
    </script>
@endsection
