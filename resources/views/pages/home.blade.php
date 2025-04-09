@extends('layout.index')
@section('title', 'GrowMart')
@section('styleCss')
<style>
/* ✅ Home Care Section */
.home-care {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background-color: orange;
    flex-wrap: wrap;
}

/* ✅ Category Box */
.category-box {
    position: relative;
    width: 100%;
    max-width: 500px;
    /* Adjust as needed */
    overflow: hidden;
    border-radius: 10px;
}

.category-box img {
    width: 100%;
    height: 400px;
    display: block;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    /* Semi-transparent black overlay */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    font-size: 18px;
    font-weight: bold;
    transition: background 0.3s ease-in-out;
}

.category-box .overlay h2 {
    margin: 0;
    padding: 10px;
}

.category-box .overlay .view-all {
    background: #ff9800;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
    margin-top: 10px;
    transition: background 0.3s ease-in-out;
}

.category-box .overlay .view-all:hover {
    background: #ff6600;
}

/* ✅ Product Slider */
.product-slider {
    width: 55%;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
}

/*
.scroll-btn {
background: black;
color: white;
border: none;
padding: 10px;
cursor: pointer;
position: absolute;
z-index: 10;
}

.scroll-left {
left: 0;
}

.scroll-right {
right: 0;
} */

.product-list {
    display: flex;
    gap: 15px;
    overflow-x: auto;
    /* Horizontal Scroll Enable */
    scroll-behavior: smooth;
    padding: 10px;
    white-space: nowrap;
    /* Cards ek hi row me rahenge */
}

.product-cards {
    flex: 0 0 auto;
    /* Fixed width, no wrapping */
    width: 250px;
    height: 350px;
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    display: inline-block;
    /* Ensure Single Line */
}

.product-cards img {
    width: 100%;
    height: 160px;
    object-fit: contain;
    border-radius: 5px;
}

.discount {
    background: red;
    color: white;
    padding: 5px;
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 12px;
}

.price {
    font-weight: bold;
    margin-top: 5px;
    font-size: 16px;
}

.old-price {
    text-decoration: line-through;
    color: gray;
    font-size: 14px;
}

.buttons {
    display: flex;
    gap: 5px;
    justify-content: center;
    margin-top: 10px;
}

/* .add-to-cart {
background: #28a745;
color: white;
border: none;
padding: 8px 12px;
cursor: pointer;
border-radius: 5px;
} */

/* .whatsapp-btn {
color: green;
font-size: 20px;
border: none;
cursor: pointer;
} */

/* ✅ Responsive Design (Har Device Par Proper Show Hogi) */
@media (max-width: 1200px) {
    .home-care {
        flex-direction: column;
        align-items: center;
    }

    .category-box,
    .product-slider {
        width: 80%;
    }

    .product-cards {
        width: 180px;
    }
}

@media (max-width: 992px) {

    .category-box,
    .product-slider {
        width: 100%;
    }

    .product-list {
        justify-content: center;
    }

    .product-cards {
        width: 170px;
    }
}

@media (max-width: 768px) {
    .product-slider {
        flex-direction: column;
    }

    .product-list {
        width: 100%;
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        white-space: nowrap;
    }

    .product-cards {
        width: 160px;
    }
}

@media (max-width: 576px) {
    .category-box {
        width: 100%;
    }

    .product-slider {
        width: 100%;
    }

    .product-cards {
        width: 160px;
    }
}

/* ✅ Scroll Button Styling */
.scroll-btn {
    background: none;
    /* No Background */
    color: black;
    border: none;
    font-size: 30px;
    /* Bigger Arrow Icon */
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    transition: all 0.3s ease-in-out;
}

/* Left & Right Arrow Icons */
.scroll-left::before {
    content: "\276E";
    /* Unicode Left Arrow */
}

.scroll-right::before {
    content: "\276F";
    /* Unicode Right Arrow */
}



/* Left & Right Button Positions */
.scroll-left {
    left: -5px;
}

.scroll-right {
    right: -5px;
}

/* Mobile-Friendly Adjustments */
@media (max-width: 768px) {
    .scroll-btn {
        font-size: 26px;
    }

    .scroll-left {
        left: 5px;
    }

    .scroll-right {
        right: 5px;
    }
}
</style>
@endsection

@section('bodyContent')
<?php
$banners = [
    (object)['image'=>'localhost:8000/theme/images/banner1.png'],
    (object)['image'=>'localhost:8000/theme/images/banner3.png'],
    (object)['image'=>'localhost:8000/theme/images/banner4.png']
];
$browserCategories = [
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories1.png'],
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories2.png'],
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories3.png'],
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories4.png'],
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories5.png'],
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories6.png'],
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories7.png'],
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories8.png'],
    (object)['image'=>'localhost:8000/theme/images/Categories/Categories9.png']
];
?>
<!-- Bootstrap Carousel -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        @foreach($banners as $key => $banner)
        <div class="carousel-item active">
            <img src="{{$banner->image}}" class="d-block w-100" alt="Slide {{$key}}">
            <!-- <div class="carousel-caption d-none d-md-block">
                    <h5>First Slide</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div> -->
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev"
        style="background-color: rgba(0, 0, 0, 0.712); border-radius: 50%; width: 50px; height: 50px; position: absolute; top: 50%; transform: translateY(-50%); left: 10px;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next"
        style="background-color: rgba(0, 0, 0, 0.712); border-radius: 50%; width: 50px; height: 50px; position: absolute; top: 50%; transform: translateY(-50%); right: 10px;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container-fluid pt-5">
    <h2 style="text-align: center;">Browse Categories</h2>
    <div class="category-container pt-5">
        @foreach($categories as $key => $categorie)
        <div class="category-card">
            <a href="#">
                <img src="public/{{ $categorie->category_image }}" alt="image-{{$key}}">
            </a>
        </div>
        @endforeach
    </div>
</div>

<!-- <div class="container-fluid py-5"> -->

<div class="video-container pt-5">
    <h3 class="text-center mb-4">SHOPPING WITH SMART CAREER</h3>
    <video autoplay loop muted controls style="padding-top: 20px;">
        <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <!-- <div class="banner">SHOPPING WITH SMART CAREER</div> -->
</div>


<div class="container-fluid py-4" style="margin-top: 40px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-center">GROCERY OFFERS</h3>
        <a href="GROCERY-OFFERS.html">
            <button class="btn ms-auto" style="background-color: #2E7D32; color: white;">View More</button>
        </a>
    </div>

    <div class="product-container">
        <!-- Product Cards -->
        @if($products->count() > 0)
        @foreach($products as $product)
        <div class="product-card">
            <div class="discount">
                @if($product->mrp_price > $product->sale_price)
                {{ number_format((($product->mrp_price - $product->sale_price) / $product->mrp_price) * 100, 0) }}% off
                @endif
            </div>
            <div class="product-image">

                <a href="">
                    <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
                </a>
            </div>
            <div class="product-name">{{ $product->product_name }}</div>
            <div class="product-price">
                &#8377;{{ $product->sale_price }}
                <span class="old-price">&#8377;{{ $product->mrp_price }}</span>
            </div>
            <div class="product-weight">{{ $product->quantity }} Gm</div>
            <div class="buttons">
                <button class="add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>

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



        <!-- <div class="product-card">
            <div class="discount">10% off</div>
            <div class="product-image">
                <a href="Category.html">
                    <img src="{{asset('/theme/images/GROCERY OFFERS/GROCERY.png')}}" alt="ORANGE FUN TOFFEE">
                </a>
            </div>
            <div class="product-name">ORANGE FUN TOFFEE</div>
            <div class="product-price">&#8377;45 <span class="old-price">&#8377;50</span></div>
            <div class="product-weight">280 Gm</div>
            <div class="buttons">
                <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>
                <button class="whatsapp-btn">
                    <i class="fa-brands fa-whatsapp"></i>
                </button>
            </div>
        </div> -->

        <!-- Aur bhi cards yahan add kar sakte hain -->
    </div>
</div>




<!-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" >
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('theme/images/banner.png"')}} class="d-block w-100" alt="Banner 1" style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="{{asset('theme/images/banner2.png"')}} class="d-block w-100" alt="Banner 2" style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="{{asset('theme/images/banner3.png"')}} class="d-block w-100" alt="Banner 3" style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="{{asset('theme/images/banner4.png"')}} class="d-block w-100" alt="Banner 4" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div> -->
<!-- <h3 class="mb-0 text-center mt-5">Products</h3> -->
<section class="home-care mt-5">

    <div class="category-box">
        <img src="{{asset('theme/images/banner1.png"')}} alt=" Home Care Products">
        <div class="overlay">
            <h2>HOME CARE PRODUCTS</h2>
            <a href="GROCERY-OFFERS.html">
                <button class="view-all">View All</button>
            </a>
        </div>
    </div>

    <!-- Product Slider Container -->
    <!-- <div class="product-slider"> -->
    <!-- <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" ></button> -->
    <div class="product-slider">
        <button class="scroll-btn scroll-left"></button> <!-- Left Arrow -->

        <div class="product-list" id="productList">
            @if($products->count() > 0)
            @foreach($products as $product)
            <div class="product-card">
                <div class="discount">
                    @if($product->mrp_price > $product->sale_price)
                    {{ number_format((($product->mrp_price - $product->sale_price) / $product->mrp_price) * 100, 0) }}%
                    off
                    @endif
                </div>
                <div class="product-image">

                    <a href="">
                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
                    </a>
                </div>
                <div class="product-name">{{ $product->product_name }}</div>
                <div class="product-price">
                    &#8377;{{ $product->sale_price }}
                    <span class="old-price">&#8377;{{ $product->mrp_price }}</span>
                </div>
                <div class="product-weight">{{ $product->quantity }} Gm</div>
                <div class="buttons">
                    <button class="add-to-cart" data-product-id="{{ $product->id }}>Add to Cart</button>

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

            <!-- <div class="product-cards">
                <span class="discount">10% off</span>
                <img src="{{asset('/theme/images/GROCERY OFFERS/GROCERY.png')}}" alt="Product">
                <h3 style="font-size: 15px; padding-top: 25px;">Tide Liquid Detergent</h3>
                <p class="price">₹200 <span class="old-price">₹220</span></p>
                <div class="buttons">
                    <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>
                    <button class="whatsapp-btn">
                        <i class="fa-brands fa-whatsapp"></i>
                    </button>
                </div>
            </div> -->

            <!-- Add more product cards here -->
        </div>

        <button class="scroll-btn scroll-right"></button> <!-- Right Arrow -->
    </div>


</section>


<div class="video-container mt-5">
    <h3 class="text-center mb-4 mt-5">SHOPPING WITH SMART CAREER</h3>
    <video autoplay loop muted controls style="padding-top: 20px;">
        <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <!-- <div class="banner">SHOPPING WITH SMART CAREER</div> -->
</div>


<!-- Home Care Section -->
<!-- <h3 class="mb-0 text-center mt-5">Products</h3> -->


<div class="features-container">
    <img src="{{asset('/theme/images/fast.png')}}" alt="Fast Delivery" class="full-width-image">
    <!-- <div class="feature-text">
            <p>🚀 Fast Delivery | 💰 COD Available | ✅ Quality Guarantee</p>
        </div> -->
</div>


<div class="container-fluid py-4" style="margin-top: 50px;">
    <h3 class="mb-0 text-center">Products</h3>

    <div class="product-container mt-5">

        <!-- Product Cards -->
        @if($products->count() > 0)
        @foreach($products as $product)
        <div class="product-card">
            <div class="discount">
                @if($product->mrp_price > $product->sale_price)
                {{ number_format((($product->mrp_price - $product->sale_price) / $product->mrp_price) * 100, 0) }}% off
                @endif
            </div>
            <div class="product-image">

                <a href="">
                    <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
                </a>
            </div>
            <div class="product-name">{{ $product->product_name }}</div>
            <div class="product-price">
                &#8377;{{ $product->sale_price }}
                <span class="old-price">&#8377;{{ $product->mrp_price }}</span>
            </div>
            <div class="product-weight">{{ $product->quantity }} Gm</div>
            <div class="buttons">
                <button class="add-to-cart"  data-product-id="{{ $product->id }}">Add to Cart</button>

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

        <!-- <div class="product-card">
            <div class="discount">10% off</div>
            <div class="product-image">
                <a href="Category.html">
                    <img src="{{asset('/theme/images/GROCERY OFFERS/GROCERY.png')}}" alt="MANGO MASTI TOFFEE">
                </a>
            </div>
            <div class="product-name">ORANGE FUN TOFFEE</div>
            <div class="product-price">&#8377;45 <span class="old-price">&#8377;50</span></div>
            <div class="product-weight">280 Gm</div>
            <div class="buttons">
                <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>
                <button class="whatsapp-btn">
                    <i class="fa-brands fa-whatsapp"></i>
                </button>
            </div>
        </div> -->

    </div>

    <!-- 🔹 All Products Button (Centered) -->
    <div class="all-products-btn">
        <a href="/all-product">
            <button class="all-btn">All Products</button>
        </a>
    </div>

</div>
<!-- Login And Register Module Start -->

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm">
                    @csrf
                    <input type="text" name="name" placeholder="Name" class="form-control mb-2" required>
                    <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
                    <input type="text" name="mobile" placeholder="Mobile Number" class="form-control mb-2" required>
                    <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>
                    <input type="text" id="pincode" name="pincode" placeholder="Enter Pincode" class="form-control mb-2"
                        required>

                    <select name="shop_id" id="shopSelect" class="form-control mb-2">
                        <option value="">Select Shop</option>
                    </select>
                    <button type="submit" class="btn btn-success">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    @csrf
                    <input type="text" name="login" placeholder="Email or Mobile" class="form-control mb-2" required>
                    <input type="password" name="password" placeholder="Password" class="form-control mb-2" required>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Login And Register Module End -->
@endsection

@section('scriptJs')
<script>
$(document).ready(function() {
    $('#pincode').on('input', function() {
        let pincode = $(this).val();

        if (pincode.length === 6) { // Ensure valid pincode length
            $.ajax({
                url: `/get-shops/${pincode}`,
                type: 'GET',
                success: function(response) {
                    $('#shopSelect').empty().append(
                        '<option value="">Select Shop</option>');
                    $.each(response, function(index, shop) {
                        $('#shopSelect').append(
                            `<option value="${shop.id}">${shop.shop_name}</option>`
                        );
                    });
                },
                error: function() {
                    $('#shopSelect').empty().append(
                        '<option value="">No Shops Found</option>');
                }
            });
        }
    });
});


document.addEventListener("DOMContentLoaded", function() {
    let productList = document.getElementById("productList");
    let scrollAmount = 220; // Kitna scroll karna hai

    document.querySelector(".scroll-left").addEventListener("click", function() {
        productList.scrollBy({
            left: -scrollAmount,
            behavior: "smooth"
        });
    });

    document.querySelector(".scroll-right").addEventListener("click", function() {
        productList.scrollBy({
            left: scrollAmount,
            behavior: "smooth"
        });
    });
});


document.addEventListener("DOMContentLoaded", function() {
    let productList = document.getElementById("productList");
    let scrollAmount = 250; // Kitna scroll karna hai

    document.querySelector(".scroll-left-btn").addEventListener("click", function() {
        productList.scrollBy({
            left: -scrollAmount,
            behavior: "smooth"
        });
    });

    document.querySelector(".scroll-right-btn").addEventListener("click", function() {
        productList.scrollBy({
            left: scrollAmount,
            behavior: "smooth"
        });
    });
});


// ============================================================================

$(document).on("click", ".add-to-cart", function () {
    let button = $(this);

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
        success: function (res) {
            if (res.success) {
                button
                    .html(`
                        <button class="qty-btn decrease">-</button>
                        <span class="cart-count">1</span>
                        <button class="qty-btn increase">+</button>
                    `)
                    .addClass("cart-controls-active")
                    .attr("data-product-id", productId); // Reassign
            }
        },
        error: function (xhr) {
            console.log("Add Error:", xhr.responseText);
        }
    });
});

// Increase Quantity
$(document).on("click", ".increase", function () {
    let wrapper = $(this).closest(".add-to-cart");
    let productId = wrapper.data("product-id");
    let countSpan = wrapper.find(".cart-count");
    let count = parseInt(countSpan.text());

    let newQty = count + 1;
    countSpan.text(newQty);

    updateCart(productId, newQty);
});

 // Decrease Quantity
 $(document).on("click", ".decrease", function () {
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
        wrapper.html("Add to Cart").removeClass("cart-controls-active");
        updateCart(productId, 0); // 0 = remove
    }
});

// Update quantity function
function updateCart(productId, quantity) {
    $.ajax({
        url: "{{ route('frontend.update-cart') }}",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            product_id: productId,
            quantity: quantity
        },
        success: function (res) {
            console.log("Updated", res);
        },
        error: function (xhr) {
            console.log("Update Error:", xhr.responseText);
        }
    });
}




// =================================

document.addEventListener("DOMContentLoaded", function() {
    let dropdowns = document.querySelectorAll(".dropdown-menu");

    dropdowns.forEach((dropdown) => {
        dropdown.addEventListener("click", function(e) {
            e.stopPropagation();
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function(event) {
        let openDropdowns = document.querySelectorAll(".dropdown-menu.show");
        openDropdowns.forEach((dropdown) => {
            if (!dropdown.parentElement.contains(event.target)) {
                dropdown.classList.remove("show");
            }
        });
    });
});

// ====================================================
document.getElementById("locationIcon").addEventListener("click", function(event) {
    event.preventDefault();

    let locationBox = document.getElementById("locationBox");
    let icon = document.getElementById("locationIcon");

    // Icon ke position ko find karna
    let rect = icon.getBoundingClientRect();

    // Location Box ko set karna (icon ke just neeche)
    locationBox.style.top = rect.bottom + window.scrollY + "px"; // Icon ke neeche
    locationBox.style.left = rect.left + window.scrollX + "px"; // Same horizontal position

    // Show/Hide Toggle
    locationBox.classList.toggle("d-none");
});

document.getElementById("currentLocation").addEventListener("click", function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            alert("Latitude: " + position.coords.latitude + "\nLongitude: " + position.coords
                .longitude);
        }, function(error) {
            alert("Error getting location: " + error.message);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});

// ========================================================================


// Function to close the navbar
function closeNav() {
    document.getElementById("navbarNav").classList.remove("show");
}

// Close menu when clicking outside
document.addEventListener("click", function(event) {
    var navbar = document.getElementById("navbarNav");
    var toggleButton = document.querySelector(".navbar-toggler"); // Mobile toggle button

    // Check if the click is outside the menu and not on the toggle button
    if (!navbar.contains(event.target) && !toggleButton.contains(event.target)) {
        closeNav();
    }
});

// ============================================
document.getElementById("mobileLocationIcon").addEventListener("click", function() {
    let locationBox = document.getElementById("mobileLocationBox");
    locationBox.classList.toggle("d-block"); // Toggle 'd-block' class to show/hide
});



// =============================================
</script>

<script>
$(document).ready(function() {
    // Register User
    $("#registerForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/register",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: "Registration Successful!",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload();
                    // $("#registerModal").modal("hide"); // Hide modal after success
                    // $("#registerForm")[0].reset(); // Clear form
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: "Error!",
                    text: xhr.responseJSON.message || "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    });

    // Login User
    $("#loginForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/login",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                window.location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message);
            }
        });
    });

    $("#logoutForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/logout",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                window.location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message);
            }
        });
    });
});
</script>
@endsection