<footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <!-- Quick Links -->
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">My Orders</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Payment Policy</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Return & Refund Policy</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Terms and Conditions</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            <!-- Get In Touch -->
            <div class="col-md-4">
                <h5>Get In Touch</h5>
                <p><i class="fas fa-phone"></i> 05123177380</p>
                <p><i class="fab fa-whatsapp"></i> +91-8840610761</p>
                <p><i class="fas fa-envelope"></i> realglowmart@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> P.No. 68 - Maa Kripa Apartment, Near - Shayam Nagar By
                    Pass, New Azad Nagar, Kanpur, Uttar Pradesh - 208011</p>
            </div>

            <!-- Social Links -->
            <div class="col-md-4">
                <h5>Social</h5>
                <div class="social-icons">
                    <p><i class="fab fa-youtube"></i> <a href="#">Youtube</a></p>
                    <p><i class="fab fa-facebook"></i> <a href="#">Facebook</a></p>
                    <p><i class="fab fa-instagram"></i> <a href="#">Instagram</a></p>
                </div>
            </div>
        </div>

        <!-- Copyright Section -->
        <div class="text-center mt-4">
            <p>Copyright &copy; by Glowmart Smart Retail 2025. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    var isUserCustomer = {{ Auth::check() && Auth::user()->role_id == 2 ? 'true' : 'false' }};
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
    $(document).ready(function() {
        // Register User
        $("#registerForm").on('click', function(e) {
            console.log("hello");
            e.preventDefault();
            let name = $("#name").val();
            let email = $("#email").val();
            let mobile = $("#mobile").val();
            let password = $("#registerPassword").val();
            let pincode = $("#pincode").val();
            let shop_id = $("#shopSelect").val();
            $.ajax({
                url: "/register",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    name: name,
                    email: email,
                    mobile: mobile,
                    password: password,
                    pincode: pincode,
                    shop_id: shop_id
                },
                success: function(response) {
                    alert("Your Registration successfully completed");
                    window.location.reload();
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

        $("#loginForm").on('click', function(e) {
            e.preventDefault();

            let username = $("#username").val();
            let password = $("#loginPassword").val();
            let passwordField = document.getElementById("password");
            let _token = $('input[name="_token"]').val();


            $.ajax({
                url: "/login",
                type: "POST",
                data: {
                    _token: _token,
                    login: username,
                    password: password
                },
                success: function(response) {
                    alert("You are logged in successfully");
                    window.location.reload();
                },
                error: function(xhr) {
                    console.log("Error:", xhr.responseJSON);
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
