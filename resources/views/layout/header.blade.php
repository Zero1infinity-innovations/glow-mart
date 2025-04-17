<header class="sticky-top">
    @if (Request::is('/'))
        <div class="announcement text-center py-1" style="  position: relative">
            <p>BEST PRICE IN CITY, SAME DAY FREE HOME DELIVERY SERVICE, Refer & Earn per Member ₹50 Coupon.</p>
        </div>
    @endif

    <!-- Top Bar -->
    <div class="top-bar container-fluid bg-light py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a href="#" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('/theme/images/GLOWMARTlogo.png') }}" class="logo" alt="Glowmart Logo">
                <div class="ms-2">
                    <h5 class="mb-0">GLOWMART</h5>
                    <p class="text-muted mb-0 small">एक कदम सपनों से हकीकत की ओर</p>
                </div>
            </a>

            <!-- Desktop Search Bar -->
            <form class="search-box d-none d-md-flex">
                <span class="search-icon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search for products">
            </form>


            <!-- Icons -->
            <!-- Icons -->
            <div class="icons d-flex align-items-center">
                <a href="#" class="btn px-2 d-none d-md-inline" id="locationIcon">
                    <i class="bi bi-geo-alt"></i>
                </a>
                <div class="location-box position-absolute bg-white shadow p-3 rounded d-none" id="locationBox"
                    style="width: 250px; max-width: 250px; min-width: 250px; z-index: 5000; left: 50%; transform: translateX(-50%);">

                    <h6 class="mb-2">Enter ZIP Code</h6>
                    <input type="text" class="form-control mb-2" placeholder="Enter ZIP Code" id="zipCode">
                    <button class="btn btn-primary w-100" id="currentLocation">Use My Current Location</button>
                </div>

                <div class="dropdown d-none d-md-inline">
                    <a href="#" class="btn px-2 d-flex align-items-center" id="profileDropdown"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @auth
                            @if (Auth::user()->role_id == 2)
                                <!-- If user has role_id = 2 (User) -->
                                <li>
                                    <a class="dropdown-item" href="/profile" style="font-size: 18px;">My Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/change-password" style="font-size: 18px;">Change
                                        Password</a>
                                </li>
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"
                                            style="font-size: 18px;">Logout</button>
                                    </form>
                                </li>
                            @endif
                        @else
                            <!-- If user is NOT logged in -->
                            <li>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#loginModal"
                                    style="font-size: 18px;">Login</a>
                            </li>
                            <li>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#registerModal"
                                    style="font-size: 18px;">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
                <a href="{{ route('frontend.cart') }}" class="btn px-2 d-none d-md-inline position-relative">
                    <i class="bi bi-cart" style="font-size: 24px;"></i>
                    @if ($count != 0)
                        <span id="headerCartCount" data-id="{{ $count }}"
                            class="position-absolute badge rounded-circle bg-success d-flex align-items-center justify-content-center"
                            style="top: 2px; right: 2px; font-size: 12px; width: 18px; height: 18px;">
                            {{ $count }}
                        </span>
                    @endif
                </a>
                <a href="#" class="btn px-2" style="color: rgb(14, 139, 14);"><i class="fab fa-whatsapp"></i></a>
            </div>

        </div>

        <!-- Mobile Search Bar -->
        <!-- Mobile Search Bar -->
        <div class="container mt-2 d-md-none position-relative">
            <form class="search-box d-flex align-items-center">
                <span class="search-icon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search for products" style="width: 300px;">

                <button type="button" class="btn location-btn px-2" id="mobileLocationIcon">

                    <i class="fas fa-map-marker-alt"></i>
                </button>
            </form>

            <!-- Location Box -->
            <!-- <div class="location-box-mobile position-absolute bg-white shadow p-3 rounded d-none" id="mobileLocationBox">
                <h6 class="mb-2">Enter ZIP Code</h6>
                <input type="text" class="form-control mb-2" placeholder="Enter ZIP Code">
                <button class="btn btn-primary w-100">Use My Current Location</button>
            </div> -->
        </div>
    </div>


    <!-- NAVIGATION MENU -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-lg-none" href="index.html">GLOWMART</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <button class="close-menu" onclick="closeNav()">&times;</button>
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">SMART INCOME</a>
                        <ul class="dropdown-menu">
                            <li><a href="Login.html" class="dropdown-item">Login , Refer & Earn</a></li>
                            <li><a href="Blogs.html" class="dropdown-item">MY BLOG</a></li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Groceries, Oil & Masala</a>
                        <ul class="dropdown-menu">
                            <li><a href="Category.html" class="dropdown-item">Immunity Boosters</a></li>
                            <li><a href="Category.html" class="dropdown-item">Dal & Pulses</a></li>
                            <li><a href="Category.html" class="dropdown-item">Atta & Other Flours</a></li>
                            <li><a href="Category.html" class="dropdown-item">Salt, Sugar & Jaggery</a></li>
                            <li><a href="Category.html" class="dropdown-item">Rice & Other Grains</a></li>
                            <li><a href="Category.html" class="dropdown-item">Noodles, Sewaiyan, Pasta & Soups</a></li>
                            <li><a href="Category.html" class="dropdown-item">Dry Fruits & Nuts</a></li>
                            <li><a href="Category.html" class="dropdown-item">Edible Oils</a></li>
                            <li><a href="Category.html" class="dropdown-item">Potato, Onion & Other Vegetables</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Dairy, Breakfast & Biscuits</a>
                        <ul class="dropdown-menu">
                            <li><a href="Category.html" class="dropdown-item">Biscuits & Bakery</a></li>
                            <li><a href="Category.html" class="dropdown-item">Jam, Honey & Spreads</a></li>
                            <li><a href="Category.html" class="dropdown-item">Dairy Products</a></li>
                            <li><a href="Category.html" class="dropdown-item">Breakfast Cereals</a></li>
                            <li><a href="Category.html" class="dropdown-item">Bread & Cake Essentials</a></li>
                        </ul>
                    </li> -->

                    @foreach ($categories as $category)
                        @if ($category->subcategories->count())
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    {{ $category->category_name }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($category->subcategories as $sub)
                                        <li>
                                            <a href="/all-product?subcategory_id={{ $sub->id }}"
                                                class="dropdown-item">
                                                {{ $sub->subcate_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="/all-product?category_id={{ $category->id }}" class="nav-link">
                                    {{ $category->category_name }}
                                </a>
                            </li>
                        @endif
                    @endforeach


                    <!--
                    @foreach ($categories as $category)
<li class="nav-item"><a href="/all-product?category_id={{ $category->id }}" class="nav-link">{{ $category->category_name }}</a></li>
@endforeach -->



                    <!-- <li class="nav-item"><a href="#" class="nav-link">Groceries</a></li> -->
                    <!-- <li class="nav-item"><a href="Category.html" class="nav-link">Beverages</a></li>
                    <li class="nav-item"><a href="Category.html" class="nav-link">Home Care</a></li>
                    <li class="nav-item"><a href="Category.html" class="nav-link">Personal Care</a></li>
                    <li class="nav-item"><a href="Category.html" class="nav-link">Kitchen Essentials</a></li>
                    <li class="nav-item"><a href="Category.html" class="nav-link">Household Essentials</a></li>
                    <li class="nav-item"><a href="Category.html" class="nav-link">Baby Care</a></li> -->
                    <!-- <li class="nav-item"><a href="#" class="nav-link">Kitchen Essentials</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Kitchen Essentials</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Kitchen Essentials</a></li> -->
                </ul>
            </div>
        </div>
    </nav>
</header>
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
                <form id="">
                    @csrf
                    <input type="text" id="name" name="name" placeholder="Name" class="form-control mb-2" required>
                    <input type="email" id="email" name="email" placeholder="Email" class="form-control mb-2" required>
                    <input type="text" id="mobile" name="mobile" placeholder="Mobile Number" class="form-control mb-2"
                        required>
                    <input type="password" id="registerPassword" name="password" placeholder="Password" class="form-control mb-2"
                        required>
                    <input type="text" id="pincode" name="pincode" placeholder="Enter Pincode"
                        class="form-control mb-2" required>

                    <select name="shop_id" id="shopSelect" class="form-control mb-2">
                        <option value="">Select Shop</option>
                    </select>
                    <button type="button" id="registerForm" class="btn btn-success">Register</button>
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
                <form>
                    @csrf
                    <input type="text" id="username" name="login" placeholder="Email or Mobile" class="form-control mb-2" required>
                    <input type="password" id="loginPassword" name="password" placeholder="Password" class="form-control mb-2" required>
                    <button type="submit" id="loginForm" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
