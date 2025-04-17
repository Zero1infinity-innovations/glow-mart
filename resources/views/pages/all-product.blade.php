@extends('layout.index')
@section('title', 'GrowMart')
<style>
    .container-fluid {
        display: flex;
        /* padding: 20px; */
    }

    /* Sidebar Filters */
    .filters {
        width: 250px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .filters h2 {
        margin-top: 0;
    }

    .filters label,
    .filters h3 {
        display: block;
        margin: 5px 0;
    }

    .see-more {
        background: #007bff;
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;
    }

    /* Product Listing */
    .product-list {
        display: flex;
        flex-wrap: wrap;
        /* Ensures products wrap to the next line */
        gap: 20px;
        margin-left: 20px;
        width: 100%;
    }

    .product-card {
        width: calc(25% - 20px);
        /* 4 Products per row */
        background: white;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        height: 380px;
        margin-bottom: 20px;
    }

    .product-card img {
        width: 100%;
        border-radius: 5px;
    }

    .discount {
        background: #007bff;
        color: white;
        padding: 5px;
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 12px;
    }

    .buttons {
        margin-top: 15px;
    }

    .add-to-cart {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        cursor: pointer;
    }

    .whatsapp-btn {
        background: #25d366;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        cursor: pointer;
        display: block;
        margin-top: 10px;
    }

    .cart-controls-active {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .qty-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 18px;
    }

    .cart-count {
        margin: 0 10px;
        font-size: 16px;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .product-card {
            width: calc(50% - 20px);
            /* 2 Products per row */
        }
    }

    @media (max-width: 600px) {
        .product-card {
            width: calc(100% - 20px);
            /* 1 Product per row */
        }
    }

    .breadcrumb {
        padding: 10px 10px;
        background: #f4f4f4;
        font-size: 14px;
    }

    .breadcrumb a {
        text-decoration: none;
        color: #007BFF;
    }

    .grocery-offers {
        padding: 20px;
    }

    h2 {
        margin-bottom: 10px;
        color: #333;
    }

    .sort-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .sort-dropdown select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
    }

    .items {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .item {
        border: 1px solid #ccc;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .breadcrumb {
            text-align: center;
        }

        .sort-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .sort-dropdown {
            margin-top: 10px;
        }
    }
</style>

@section('bodyContent')

    <script>
        const isUserLoggedIn = @json(Auth::check() && Auth::user()->role_id == 2);
    </script>
    <div class="container-fluid">
        <!-- Sidebar Filters -->
        <aside class="filters">
            <h2>Filters</h2>

            <h6 style="font-weight: bold;">Brand </h6>
            <label><input type="checkbox"> Brand A</label>
            <label><input type="checkbox"> Brand B</label>
            <label><input type="checkbox"> Brand C</label>

            <h6 style="font-weight: bold;">Price Range (₹500 - ₹5000)</h6>
            <input type="range" min="500" max="5000" value="1000">

            <h6 style="font-weight: bold;">Size</h6>
            <label><input type="checkbox"> 250 ml</label>
            <label><input type="checkbox"> 500 ml</label>
            <label><input type="checkbox"> 1 liter</label>
            <label><input type="checkbox"> 5 kg</label>
            <label><input type="checkbox"> 10 kg</label>

            <!-- Hidden Options (Initially Hidden) -->
            <div id="more-options" style="display: none;">
                <label><input type="checkbox"> 100 gram</label>
                <label><input type="checkbox"> 1 meter</label>
                <label><input type="checkbox"> 5 meter</label>
                <label><input type="checkbox"> 12 inch</label>
            </div>

            <!-- See More Button -->
            <button class="see-more" onclick="toggleOptions()">See More</button>

            <h6 style="font-weight: bold;">Flavor</h6>
            <label><input type="checkbox"> Chocolate</label>
            <label><input type="checkbox"> Vanilla</label>
            <label><input type="checkbox"> Strawberry</label>
            <label><input type="checkbox"> Mango</label>

            <h6 style="font-weight: bold;">Color</h6>
            <label><input type="radio" name="color"> Red</label>
        </aside>

        <!-- Product Listing -->
        <div class="product-section">
            <div class="breadcrumb">
                <a href="index.html"> Home > </a><a href="#">Grocery Offers</a>
            </div>

            <div class="grocery-offers">
                <div class="sort-section">
                    <h2>GROCERY OFFERS</h2>
                    <div class="sort-dropdown">
                        <label for="sort">Sort By:</label>
                        <select id="sort">
                            <option>Newest First</option>
                            <option>Price - Low to High</option>
                            <option>Price - High to Low</option>
                        </select>
                    </div>
                </div>
            </div>

            <section class="product-list">
                @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <div class="product-card">
                            <div class="discount">
                                @if ($product->mrp_price > $product->sale_price)
                                    {{ number_format((($product->mrp_price - $product->sale_price) / $product->mrp_price) * 100, 0) }}%
                                    off
                                @endif
                            </div>
                            <<div class="product-image">

                                <a href="{{ route('frontend.product-details', ['id' => $product->id]) }}">
                                    <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
                                </a>
                            </div>
                            <a href="{{ route('frontend.product-details', ['id' => $product->id]) }}" style="text-decoration: none;">
                                <div class="product-name">{{ $product->product_name }}</div>
                            </a>
                            <div class="product-price">
                                &#8377;{{ $product->sale_price }}
                                <span class="old-price">&#8377;{{ $product->mrp_price }}</span>
                            </div>
                            <div class="product-weight">{{ $product->quantity }} Gm</div>
                            <div class="buttons">
                                @if (isset($cartItems[$product->id]))
                                    <div class="add-to-cart cart-controls-active" data-product-id="{{ $product->id }}">
                                        <button class="qty-btn decrease">-</button>
                                        <span class="cart-count">{{ $cartItems[$product->id] }}</span>
                                        <button class="qty-btn increase">+</button>
                                    </div>
                                @else
                                    <button class="add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
                                @endif

                                <a href="" target="_blank" class="whatsapp-btn">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-products">
                        <h3>No products available at the moment.</h3>
                    </div>
                @endif
            </section>


        </div>
    </div>

@endsection

@section('scriptJs')
    <script>
        $(document).on("click", ".add-to-cart", function(e) {
            let button = $(this);
            var isUserCustomer = {{ (Auth::check() && Auth::user()->role_id == 2) ? 'true' : 'false' }};
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
