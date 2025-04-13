@extends('layout.index')
@section('title', 'E-commerce - Cart')
@section('bodyContent')
    <style>
        .btn-primary {
            background-color: #2E7D32 !important;
            border-color: #2E7D32 !important;
        }
    </style>
    <div class="container my-4">
        <div class="row" style="padding-top: 60px;" id="cartRow">
            @if (count($cartItems) > 0)
                <!-- Left Side -->
                <div class="col-lg-7">
                    <div class="card p-4">
                        <!-- <h3 class="text-primary fw-bold">GLOWMART</h3>
                        <p class="text-muted">एक कदम आसानी से डिलीवरी की ओर</p> -->

                        <h6 class="fw-bold">Shopping Cart > Review Order</h6>

                        <!-- Delivery Options -->
                        <h5 class="fw-bold mt-3">Delivery Options</h5>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="deliveryOption" id="deliver" checked>
                                <label class="form-check-label" for="deliver">Deliver</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="deliveryOption" id="pickup">
                                <label class="form-check-label" for="pickup">I will Pickup</label>
                            </div>
                        </div>


                        <!-- User Details -->
                        <h5 class="fw-bold mt-5">Create User</h5>
                        <form>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control w-50" placeholder="Name">
                                <input type="text" class="form-control w-50" placeholder="Mobile Number">
                            </div>
                        </form>


                        <!-- Address -->
                        <!-- <h5 class="fw-bold mt-3">Address</h5> -->
                        <div id="addressForm">
                            <div class="d-flex align-items-center justify-content-between mt-5">
                                <h5 class="fw-bold mt-3">Address</h5>
                                <a href="#" class="text-dark mt-3" data-bs-toggle="modal" data-bs-target="#mapModal">Use
                                    Map</a>
    
                            </div>
                            <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mapModalLabel">Select Your Location</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Google Map Embed -->
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.8354345094716!2d-122.41941568531541!3d37.774929779758314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c4d5a8b0d%3A0x4dd3f29f12f6b7b!2sSan%20Francisco%2C%20CA%2C%20USA!5e0!3m2!1sen!2sin!4v1644479467979!5m2!1sen!2sin"
                                                width="100%" height="400" style="border:0;" allowfullscreen=""
                                                loading="lazy">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <form id="deliveryAddress">
                                <div class="row mb-2">
                                    <input type="hidden" value="{{ auth()->user()->shop_id ?? '' }}" name="shopId"/>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Mobile Number">
                                    </div>
                                </div>
    
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <textarea class="form-control" rows="3" placeholder="Address"></textarea>
                                    </div>
    
                                </div>
    
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="Pin Code">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="City">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control form-select">
                                            <option selected disabled>Select State</option>
                                            <option value="UP">Uttar Pradesh</option>
                                            <option value="MH">Maharashtra</option>
                                            <option value="DL">Delhi</option>
                                            <option value="RJ">Rajasthan</option>
                                            <option value="MP">Madhya Pradesh</option>
                                            <option value="TN">Tamil Nadu</option>
                                            <option value="WB">West Bengal</option>
                                            <option value="KA">Karnataka</option>
                                            <option value="GJ">Gujarat</option>
                                            <option value="BR">Bihar</option>
                                            <!-- और भी राज्यों के लिए ऑप्शन जोड़ सकते हैं -->
                                        </select>
                                    </div>
    
                                </div>
                            </form>
                        </div>

                        <div id="shopAddress" data-id="" class="pt-4" style="display:none;">
                            <h5 class="fw-bold mt-1">Pickup Address</h5>
                            <h5 class="fw-bold" id="shopname"></h5>
                            <p id="shopAddressDetails"></p>
                        </div>

                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-lg-5 mt-4 mt-lg-0">
                    <div class="card p-4">
                        <!-- Apply Coupon -->
                        <div class="coupon-box d-flex align-items-center">
                            <h5 class="fw-bold me-2">Apply Coupon</h5>
                            <input type="text" class="form-control coupon-input" placeholder="Enter Coupon Code">
                            <button class="btn btn-primary ms-2">Apply</button>
                        </div>


                        <!-- Items List -->
                        <h5 class="fw-bold mt-3">Item ( <span id="itemCount"> {{ count($cartItems) }}</span> )</h5>

                        <div class="cart-items-container" style="max-height: 250px; overflow-y: auto; padding: 1rem;">
                            @foreach ($cartItems as $index => $item)
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2"
                                    id="cart-item-{{ $item->id }}">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($item->product->product_image) }}" class="product-img me-2"
                                            style="height: 50px;">
                                        <div>
                                            <p class="mb-0">{{ $item->product->product_name }} ({{ $item->quantity }}x)
                                            </p>
                                            <small class="text-muted">₹ {{ $item->product->sale_price }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="quantity-btn"
                                            onclick="changeQuantity({{ $item->id }}, -1)">-</button>
                                        <span class="mx-2"
                                            id="quantity-{{ $item->id }}">{{ $item->quantity }}</span>
                                        <button class="quantity-btn"
                                            onclick="changeQuantity({{ $item->id }}, 1)">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <!-- Bill Details -->
                        <h5 class="fw-bold mt-3">Bill Details</h5>
                        <div class="d-flex justify-content-between">
                            <p>Sub Total</p>
                            <p class="fw-bold">₹ <span id="subtotal">{{ $subtotal }}</span></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Tax</p>
                            <p class="fw-bold">₹ 0</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Payable</p>
                            <p class="fw-bold">₹ <span id="payable">{{ $subtotal }}</span></p>
                        </div>

                        <p class="text-success">✅ ₹ <span  id="savingAmount">{{ $totalSavings }}</span> saved so far on this order</p>
                        <h5>Order Accept 24x7 day</h5>
                        <p>& Home Delivery Only </p>
                        <p>9 AM to 6 PM everyday.</p>

                        <button class="btn btn-success w-100" id="rzp-button"
                            data-amount="{{ $subtotal * 100 }}">Continue</button>
                    </div>
                </div>
            @elseif (!Auth::check() || Auth::user()->role_id != 2)
                <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                    <div class="text-center">
                        <div style="font-size: 80px;">🔐</div>
                        <h4 class="fw-bold mt-3">You are not logged in</h4>
                        <p class="text-muted">Please <a data-bs-toggle="modal" data-bs-target="#loginModal"
                                class="btn btn-primary">login</a> to continue shopping.</p>
                    </div>
                </div>
            @else
                <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                    <div class="text-center">
                        <div style="font-size: 80px;">🛒</div>
                        <h4 class="fw-bold mt-3">Your cart is empty</h4>
                        <p class="text-muted">Start shopping and add items to your cart!</p>
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <div class="row" class="padding-top: 60px !important;" id="emptyCart" style="display: none;">
            <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                <div class="text-center">
                    <div style="font-size: 80px;">🛒</div>
                    <h4 class="fw-bold mt-3">Your cart is empty</h4>
                    <p class="text-muted">Start shopping and add items to your cart!</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptJs')
    <script>
        document.getElementById('pickup').addEventListener('change', function() {
            if (this.checked) {
                getShopAddress();
            }
        });
        document.getElementById('deliver').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('shopAddress').style.display = 'none';
                document.getElementById('addressForm').style.display = 'block';
            }
        });

        function getShopAddress() {
            fetch('{{ route('frontend.getAddress') }}')
                .then(response => response.json())
                .then(data => {
                    // Handle the response
                    if (data.success) {
                        document.getElementById('shopname').innerText = data.shopname;
                        document.getElementById('shopAddressDetails').innerText = data.address;
                        document.getElementById('shopAddress').setAttribute('data-id', data.shopNo);
                        document.getElementById('shopAddress').style.display = 'block';
                        document.getElementById('addressForm').style.display = 'none';
                    } else {
                        document.getElementById('shopAddressDetails').innerText =
                            'No shop address found for this pin code.';
                        document.getElementById('shopAddress').style.display = 'none';
                        document.getElementById('addressForm').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    document.getElementById('shopAddressDetails').innerText =
                        'An error occurred while fetching the address.';
                    document.getElementById('shopAddress').style.display = 'none';
                });
        }

        function changeQuantity(cartId, change) {
            $.ajax({
                url: "{{ route('frontend.update-quantity') }}",
                type: "POST",
                data: {
                    cart_id: cartId,
                    change: change,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        // Update quantity in UI
                        if (response.deleted) {
                            $('#cart-item-' + cartId).remove(); // Remove item from DOM
                        } else {
                            $('#quantity-' + cartId).text(response.new_quantity);
                        }

                        // Optionally update subtotal and payable too
                        $('#subtotal').text(response.subtotal);
                        $('#payable').text(response.subtotal);
                        $('#savingAmount').text(response.total_savings);
                        $('#itemCount').text(response.itemCount);
                        if(response.itemCount == 0){
                            document.getElementById("cartRow").style.display = "none";
                            document.getElementById("emptyCart").style.display = "block";
                        }
                    } else {
                        alert(response.message || 'Something went wrong');
                    }
                },
                error: function(xhr) {
                    alert('Error updating quantity');
                }
            });
        }
        


        // create order and payment
        document.getElementById('rzp-button').onclick = function(e) {
            e.preventDefault();

            let amount = this.dataset.amount;
            let shopId = document.getElementById('shopAddress').dataset.id;

            fetch("{{ route('frontend.createOrder') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        amount: amount,
                        shop_id: shopId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    var options = {
                        "key": data.key,
                        "amount": data.amount,
                        "currency": "INR",
                        "name": "GlowMart",
                        "description": "Order Payment",
                        "order_id": data.order_id,
                        "handler": function(response) {
                            fetch("{{ route('frontend.paymentSuccess') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_signature: response.razorpay_signature,
                                        total_amount: data.amount,
                                        shop_id: shopId
                                    })
                                })
                                .then(res => res.json())
                                .then(result => {
                                    alert("Order placed successfully!");
                                    window.location.href = "{{ route('frontend.orderPlaced') }}";
                                });
                        },
                        "prefill": {
                            "name": "{{ Auth::check() ? Auth::user()->name : '' }}",
                            "email": "{{ Auth::check() ? Auth::user()->email : '' }}",
                            "contact": "{{ Auth::check() ? Auth::user()->mobile : '' }}"
                        },
                        "theme": {
                            "color": "#198754"
                        }
                    };
                    var rzp = new Razorpay(options);
                    rzp.open();
                });
        };


        // ========================================================

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
    </script>
@endsection
