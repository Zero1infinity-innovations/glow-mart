document.addEventListener("DOMContentLoaded", function () {
    let carousel = document.querySelector("#carouselExampleIndicators");

    // Pause on hover & resume on mouse leave
    carousel.addEventListener("mouseenter", function () {
        bootstrap.Carousel.getInstance(carousel).pause();
    });

    carousel.addEventListener("mouseleave", function () {
        bootstrap.Carousel.getInstance(carousel).cycle();
    });

    // Auto-adjust height based on active slide
    function updateCarouselHeight() {
        let activeItem = carousel.querySelector(".carousel-item.active img");
        if (activeItem) {
            let height = activeItem.clientHeight;
            carousel.style.height = height + "px";
        }
    }

    // Adjust height on slide change
    carousel.addEventListener("slid.bs.carousel", updateCarouselHeight);
});
// ========================================

// Toggle Cart Function
function toggleCart(button) {
    if (button.innerText === "Add to Cart") {
        button.innerText = "Added";
        button.style.background = "green";
    } else {
        button.innerText = "Add to Cart";
        button.style.background = "#007bff";
    }
}

// WhatsApp Share Function
document.querySelectorAll(".whatsapp-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        let productName = this.closest(".product-card").querySelector("p").innerText;
        let price = this.closest(".product-card").querySelector(".price").innerText;
        let message = `Check out this product: ${productName} - Price: ${price}`;
        let url = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
        window.open(url, "_blank");
    });
});





function toggleCart(button) {
    // Parent container
    let parent = button.parentElement;

    // Create Quantity Selector
    let quantityDiv = document.createElement("div");
    quantityDiv.classList.add("quantity-selector");

    // Minus Button (-)
    let minusBtn = document.createElement("button");
    minusBtn.innerText = "−";
    minusBtn.classList.add("qty-btn");
    
    // Quantity Display (1 by default)
    let quantityText = document.createElement("span");
    quantityText.innerText = "1";
    quantityText.classList.add("qty-value");
    
    // Plus Button (+)
    let plusBtn = document.createElement("button");
    plusBtn.innerText = "+";
    plusBtn.classList.add("qty-btn");

    // Append buttons & quantity inside div
    quantityDiv.appendChild(minusBtn);
    quantityDiv.appendChild(quantityText);
    quantityDiv.appendChild(plusBtn);

    // Replace "Add to Cart" button with quantity selector
    parent.replaceChild(quantityDiv, button);

    // Increase Quantity
    plusBtn.addEventListener("click", function () {
        let qty = parseInt(quantityText.innerText);
        quantityText.innerText = qty + 1;
    });

    // Decrease Quantity
    minusBtn.addEventListener("click", function () {
        let qty = parseInt(quantityText.innerText);
        if (qty > 1) {
            quantityText.innerText = qty - 1;
        } else {
            // If quantity = 0, restore "Add to Cart" button
            parent.replaceChild(button, quantityDiv);
        }
    });
}
// ========================
// Sidebar toggle function
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("open");
}

// "See More" for filter options
function toggleSizeFilter() {
    let hiddenItems = document.querySelectorAll("#sizeFilter .hidden");
    hiddenItems.forEach(item => {
        item.classList.toggle("hidden");
    });
}

// ===============================================
function openWhatsApp() {
    var phoneNumber = "919876543210"; // यहां अपना व्हाट्सएप नंबर डालें (देश कोड के साथ)
    var message = "Hello, I need some help!"; // पहले से लिखा हुआ संदेश
    var url = "https://wa.me/" + phoneNumber + "?text=" + encodeURIComponent(message);
    window.open(url, "_blank");
}

// ======================================================




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


// ============================

document.getElementById("locationIcon").addEventListener("click", function(event) {
    event.preventDefault();
    let locationBox = document.getElementById("locationBox");
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
// ==========================================================================

// जब वेबसाइट लोड होगी, पॉपअप दिखेगा
window.onload = function() {
    document.getElementById("pincodePopup").style.display = "flex";
};

// पॉपअप बंद करने का फ़ंक्शन
function closePopup() {
    document.getElementById("pincodePopup").style.display = "none";
}

// पिनकोड चेक करना
function checkPincode() {
    let pincode = document.getElementById("pincodeInput").value;
    
    if (pincode.length === 6 && !isNaN(pincode)) {
        alert("Delivery available in your area! ✅");
        closePopup();
    } else {
        alert("Please enter a valid 6-digit pincode!");
    }
}



//==============================



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
