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

@section('bodyContent')


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
                    <button class="add-to-cart" onclick="toggleCart(this)">Add to Cart</button>

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