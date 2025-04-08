@extends('layout.index')
@section('title', 'E-commerce - Category')
@section('styleCss')
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

    .filters label, .filters h3 {
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
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 Cards Per Row */
        gap: 20px;
        margin-left: 20px;
        width: 100%;
    }

    .product-card {
        background: white;
        /* padding: 10px; */
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        height: 380px;
    }

    .product-card img {
        width: 100%;
        border-radius: 5px;
    }

    .discount {
        background: 007bff;
        color: white;
        padding: 5px;
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 12px;
    }
    /* 
    .cart-btn {
        background: blue;
        color: white;
        border: none;
        padding: 5px;
        width: 100%;
        cursor: pointer;
    } */

    /* .whatsapp-btn {
        background: green;
        color: white;
        border: none;
        padding: 5px;
        width: 100%;
        cursor: pointer;
    } */

    /* Responsive Design */
    @media (max-width: 1024px) {
        .product-list {
            grid-template-columns: repeat(2, 1fr); /* 2 Cards Per Row on Tablets */
        }
    }

    @media (max-width: 600px) {
        .product-list {
            grid-template-columns: repeat(1, 1fr); /* 1 Card Per Row on Mobile */
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
      /* .navbar {
        display: block;
        text-align: center;
      } */

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
@endsection

@section('bodyContent')
<div class="container-fluid">
        <!-- Sidebar Filters -->
        <aside class="filters">
            <h2>Filters not working</h2>
            
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
          <a href="index.html">  Home > </a><a href="#">Grocery Offers</a>
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
            <div class="product-card">
                <span class="discount">10% off</span>
                <img src="{{asset('/theme/images/GROCERY OFFERS/GROCERY.png')}}" alt="Product Image">
                <div class="product-name">MANGO MASTI TOFFEE</div>
                <p>₹325 <del>₹362</del></p>
                <div class="buttons">
                    <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>
                    <button class="whatsapp-btn">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                </div>
            </div>
    
            <div class="product-card">
                <span class="discount">10% off</span>
                <img src="{{asset('/theme/images/GROCERY OFFERS/GROCERY.png')}}" alt="Product Image">
                <div class="product-name">MANGO MASTI TOFFEE</div>
                <p>₹325 <del>₹362</del></p>
                <div class="buttons">
                    <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>
                    <button class="whatsapp-btn">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                </div>
            </div>
    
            <div class="product-card">
                <span class="discount">10% off</span>
                <img src="{{asset('/theme/images/GROCERY OFFERS/GROCERY.png')}}" alt="Product Image">
                <div class="product-name">MANGO MASTI TOFFEE</div>
                <p>₹325 <del>₹362</del></p>
                <div class="buttons">
                    <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>
                    <button class="whatsapp-btn">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                </div>
            </div>
            <div class="product-card">
                <span class="discount">10% off</span>
                <img src="{{asset('/theme/images/GROCERY OFFERS/GROCERY.png')}}" alt="Product Image">
                <div class="product-name">MANGO MASTI TOFFEE</div>
                <p>₹325 <del>₹362</del></p>
                <div class="buttons">
                    <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>
                    <button class="whatsapp-btn">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                </div>
            </div>
            <div class="product-card">
                <span class="discount">10% off</span>
                <img src="{{asset('/theme/images/GROCERY OFFERS/GROCERY.png')}}" alt="Product Image">
                <div class="product-name">MANGO MASTI TOFFEE</div>
                <p>₹325 <del>₹362</del></p>
                <div class="buttons">
                    <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>
                    <button class="whatsapp-btn">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection

@section('scriptJs')
<script>
    function toggleOptions() {
        var options = document.getElementById("more-options");
        var button = document.querySelector(".see-more");

        if (options.style.display === "none") {
            options.style.display = "block";
            button.textContent = "See Less"; // Change button text
        } else {
            options.style.display = "none";
            button.textContent = "See More"; // Reset button text
        }
    }



        


    document.addEventListener("click", function(event) {
        let target = event.target;

        // अगर "Add to Cart" बटन पर क्लिक हुआ
        if (target.classList.contains("add-to-cart")) {
            target.innerHTML = `
                <button class="qty-btn decrease">-</button>
                <span class="cart-count">1</span>
                <button class="qty-btn increase">+</button>
            `;
            target.classList.add("cart-controls-active"); // नया स्टाइल
        }

        // "+" बटन पर क्लिक करने पर quantity बढ़ेगी
        if (target.classList.contains("increase")) {
            let countSpan = target.parentElement.querySelector(".cart-count");
            let count = parseInt(countSpan.textContent);
            countSpan.textContent = count + 1;
        }

        // "-" बटन पर क्लिक करने पर quantity घटेगी
        if (target.classList.contains("decrease")) {
            let countSpan = target.parentElement.querySelector(".cart-count");
            let count = parseInt(countSpan.textContent);

            if (count > 1) {
                countSpan.textContent = count - 1;
            } else {
                // अगर quantity 1 से नीचे जाएगी, तो बटन वापस "Add to Cart" बन जाएगा
                let addToCartBtn = target.parentElement;
                addToCartBtn.innerHTML = `Add to Cart`;
                addToCartBtn.classList.remove("cart-controls-active");
            }
        }
    });
    // ==============================================
    document.getElementById("locationIcon").addEventListener("click", function(event) {
        event.preventDefault();

        let locationBox = document.getElementById("locationBox");
        let icon = document.getElementById("locationIcon");

        // Icon ke position ko find karna
        let rect = icon.getBoundingClientRect();

        // Location Box ko set karna (icon ke just neeche)
        locationBox.style.top = rect.bottom + window.scrollY + "px"; // Icon ke neeche
        locationBox.style.left = rect.left + window.scrollX + "px";  // Same horizontal position

        // Show/Hide Toggle
        locationBox.classList.toggle("d-none");
    });

    document.getElementById("currentLocation").addEventListener("click", function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                alert("Latitude: " + position.coords.latitude + "\nLongitude: " + position.coords.longitude);
            }, function(error) {
                alert("Error getting location: " + error.message);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });


        // ================================================

        document.addEventListener("DOMContentLoaded", function () {
        let filterPanel = document.getElementById("filterPanel");

        // Open Filters (Mobile)
        window.toggleFilter = function () {
            filterPanel.classList.add("active");
        };

        // Close Filters (Mobile)
        window.closeFilter = function () {
            filterPanel.classList.remove("active");
        };

        // Show More Options
        window.toggleOptions = function () {
            let moreOptions = document.getElementById("more-options");
            moreOptions.style.display = moreOptions.style.display === "none" ? "block" : "none";
        };

        // Filter Button Active State Toggle
        document.querySelectorAll(".filter-btn").forEach(button => {
            button.addEventListener("click", function () {
                this.classList.toggle("active");
            });
        });
    });





    // Function to close the navbar
    function closeNav() {
        document.getElementById("navbarNav").classList.remove("show");
    }

    // Close menu when clicking outside
    document.addEventListener("click", function (event) {
        var navbar = document.getElementById("navbarNav");
        var toggleButton = document.querySelector(".navbar-toggler"); // Mobile toggle button

        // Check if the click is outside the menu and not on the toggle button
        if (!navbar.contains(event.target) && !toggleButton.contains(event.target)) {
            closeNav();
        }
    });
    
</script>
@endsection