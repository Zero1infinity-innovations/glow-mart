@extends('layout.index')
@section('title', 'E-commerce - Account')
@section('styleCss')
<style>
 
/*==============================index css===================================================*/



/* ======================================================Account Page========================================== */




/* body {
  font-family: Arial, sans-serif;
} */

.sidebar1 {
  min-width: 250px;
  background: #626569;
  color: #fff;
  padding: 20px;
}

.sidebar1-header {
  height: 170px;
  width: 200px;
  text-align: center;
  margin-bottom: 20px;
  /* background-color: #004085; */
  border-bottom: 1px solid white;
}

.profile-photo1 {
  width: 100px; /* Size of the profile picture */
  height: 100px; /* Size of the profile picture */
  border-radius: 50%; /* Makes the image circular */
  object-fit: cover; /* Ensures the image covers the space */
}

/* .sidebar .components {
  padding-left: 0;
} */

.sidebar1 ul li {
  margin-left: 25px ;
}

.sidebar1 ul li a {
  color: #fff;
  /* text-decoration: none; */
  display: block;
  /* padding: 10px; */
  transition: background 0.3s;
}
/* 
.sidebar1 ul li a:hover {
  background: #495057;
} */





.content1 {
  padding: 20px;
  flex-grow: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .sidebar1 {
      min-width: 100%;
  }
}

/*=======================================================================================*/


/* ======================================order history======================================================= */

body {
font-family: Arial, sans-serif;
}

h2 {
font-size: 28px;
font-weight: bold;
text-align: center;
margin-bottom: 40px;
}

.order-history .card {
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.order-history .card-title {
font-size: 20px;
font-weight: bold;
}

.order-history .card-text {
margin-bottom: 5px;
}

.text-success {
font-weight: bold;
font-size: 20px;
}
.card-body .card-text span{
  font-size: 30px;
}


/* ================================================payment methods=========================================== */
/* .sidebar {
  height: 100vh;
  width: 250px;
  position: fixed;
  top: 0;
  left: 0;
  background-color: #343a40;
  padding-top: 20px;
  color: #fff;
}
.profile-photo {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
}
.sidebar-header h5, .sidebar-header p {
  color: #fff;
}

.sidebar-header {
  cursor: pointer;
} */

/*===========================profile details===========================================*/
/* .profile-container {
  margin-top: 20px;
}
.profile-image {
  width: 120px;
  height: 120px;
  object-fit: cover;
} */

.profile-card {
  max-width: 400px;
  margin: auto;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.profile-header {
  position: relative;
  background: url('Images/son.jpg') no-repeat center center;
  background-size: cover;
  height: 130px;
}
.profile-header img {
  position: absolute;
  bottom: -35px;
  left: 20px;
  border-radius: 50%;
  width: 100px;
  height: 100px;
  object-fit: cover;
  border: 3px solid #fff;
}
.form-section {
  background: #f8f9fa;
  padding: 40px 20px 20px;
}



/* ================================================ */

    </style>
@endsection

@section('bodyContent')
<div class="d-flex ">
        <nav class="sidebar1">
        <div class="sidebar1">
            <!-- Profile Header Section (Clickable) -->
          
<div class="sidebar1-header text-center" data-bs-toggle="modal" data-bs-target="#profileModal">
    <img src="{{asset('/theme/Account-css/Images/dress6.png')}}" alt="User Photo" class="profile-photo1 rounded-circle" width="100" height="100" id="profilePic">
    <h5 class="mt-2">John Doe</h5>
    <p class="mb-0">+1 234 567 8901</p>
</div>

<!-- Profile Edit Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="profileForm">
                    <div class="form-group text-center">
                      <img id="profileImage" src="{{asset('/theme/Account-css/Images/dress.png')}}" alt="Profile Image" class="img-thumbnail" style="width: 150px; height: 150px;">
                      <input type="file" id="imageUpload" class="form-control-file  d-none" accept="image/*">
                    </div>
                
                    <div class="form-group">
                      <strong for="fullName">Full Name</strong>
                      <input type="text" class="form-control" id="fullName" value="John Doe" >
                    </div>
                
                    <div class="form-group">
                      <strong for="email">Email Address</strong>
                      <input type="email" class="form-control" id="email" value="johndoe@example.com" >
                    </div>
                
                    <div class="form-group">
                      <strong for="phone">Phone Number</strong>
                      <input type="tel" class="form-control" id="phone" value="+1 234 567 8901" >
                    </div>
                
                    <div class="form-group">
                      <strong for="address">Address</strong>
                      <textarea class="form-control" id="address" rows="3" >1234 Main St, City, Country</textarea>
                    </div>
                  </form>
                
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="editButton">Edit</button>
                      <button type="button" class="btn btn-primary" id="saveButton" style="display: none;">
                        Save
                      </button>
                      <button type="button" class="btn btn-danger" id="cancelButton" style="display: none;">
                        Cancel
                      </button>
                    </div>
            </div>
        </div>
    </div>
</div>


            
            <!-- Navigation Links -->
            <!-- <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Logout</a>
                </li>
            </ul> -->
            <ul class="nav flex-column" role="tablist">
                <li class="nav-item">
                    <!-- <i class="fas fa-circle"></i> -->
                    <a class="nav-link active" data-toggle="tab" href="#profile-section">Profile details</a>
                </li>
                <li class="nav-item">
                    <!-- <i class="fas fa-circle"></i> -->
                    <a class="nav-link" data-toggle="tab" href="#order-history-section">Order List</a>
                </li>
                <li class="nav-item">
                    <!-- <i class="fas fa-circle"></i> -->
                    <a class="nav-link" data-toggle="tab" href="#payment-methods-section">Payment Methods</a>
                </li>
                <!-- <li class="nav-item">
                    <i class="fas fa-circle"></i>
                    <a class="nav-link" data-toggle="tab" href="#addresses-section">Addresses</a>
                </li> -->
                <!-- <li class="nav-item">
                    <i class="fas fa-circle"></i>
                    <a class="nav-link" data-toggle="tab" href="#help-support-section">Help & Support</a>
                </li> -->
                <li class="nav-item">
                    <!-- <i class="fas fa-circle"></i> -->
                    <a class="nav-link" data-toggle="tab" href="#account-settings-section">Logout</a>
                </li>
            </ul>
        </div>
    
        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileModalLabel">Edit Profile Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="text-center">
                            <img src="{{asset('/theme/Images/dress6.png')}}" alt="User Photo" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        </div> -->
                        <!-- Profile Details Form -->
                        <div class="container ">
                            <!-- <h2 class="mb-4">Edit Profile</h2> -->
                          
                            <!-- Profile Form -->
                            <!-- <form id="profileForm">
                              <div class="form-group text-center">
                                <img id="profileImage" src="theme/Account-css/Images/dress.png" alt="Profile Image" class="img-thumbnail" style="width: 150px; height: 150px;">
                                <input type="file" id="imageUpload" class="form-control-file  d-none" accept="image/*">
                              </div>
                          
                              <div class="form-group">
                                <strong for="fullName">Full Name</strong>
                                <input type="text" class="form-control" id="fullName" value="John Doe" readonly>
                              </div>
                          
                              <div class="form-group">
                                <strong for="email">Email Address</strong>
                                <input type="email" class="form-control" id="email" value="johndoe@example.com" readonly>
                              </div>
                          
                              <div class="form-group">
                                <strong for="phone">Phone Number</strong>
                                <input type="tel" class="form-control" id="phone" value="+1 234 567 8901" readonly>
                              </div>
                          
                              <div class="form-group">
                                <strong for="address">Address</strong>
                                <textarea class="form-control" id="address" rows="3" readonly>1234 Main St, City, Country</textarea>
                              </div>
                            </form>
                          
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="editButton">Edit</button>
                                <button type="button" class="btn btn-primary" id="saveButton" style="display: none;">
                                  Save
                                </button>
                                <button type="button" class="btn btn-danger" id="cancelButton" style="display: none;">
                                  Cancel
                                </button>
                              </div> -->
                          </div>
                          
                </div>
            </div>
        </div>





       
            <!-- <div class="sidebar-header text-center">
                <img src="theme/https://via.placeholder.com/100" alt="User Photo" class="profile-photo">
                <h5 class="mt-2">John Doe</h5>
                <p class="mb-0">+1 234 567 8901</p>
            </div> -->
            <!-- Nav tabs -->
            
        </nav>


        
        <!-- Content Section -->
        <div class="content">
            <div class="tab-content">

                <!--=================================profile informaion-=====================================-->
              
                <div id="profile-section" class="tab-pane fade show active">
                    <div class="container profile-container">
                        <div class="row">
                            <!-- <h3 class="mb-4">Profile Details</h3> -->
                          
                            <!-- <div class="col-md-12 text-center">
                                <img src="{{asset('/theme/Images/dress6.png')}}" alt="User Photo" class="rounded-circle profile-image">
                            </div> -->
                            <div class="col-md-1"></div>
                            <div class="col-md-10" style="width: 500px;">
                                <div class="profile-card" >
                                    <div class="profile-header">
                                        <img src="{{asset('/theme/Account-css/Images/dress6.png')}}" alt="Profile Picture">
                                    </div>
                                    <div class="container" >
                                        <div class="form-section">
                                            <form>
                                                <div class="row">
                                                    <!-- Left Column -->
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Full Name:</label>
                                                            <input type="text" class="form-control" id="fullName" readonly value="John Doe">
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email:</label>
                                                            <input type="email" class="form-control" id="email" readonly value="johndoe@example.com">
                                                        </div>
                                    
                                                        <div class="mb-3">
                                                            <label for="Address" class="form-label">Address:</label>
                                                            <input type="text" class="form-control" id="Address" readonly value="1234 Main St, City, Country">
                                                        </div>
                                                    </div>
                                    
                                                    <!-- Right Column -->
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="number" class="form-label">Mob no.:</label>
                                                            <input type="number" class="form-control" id="number" readonly value="1234567">
                                                        </div>
                                    
                                                        <div class="mb-3">
                                                            <label for="password" class="form-label">Password:</label>
                                                            <input type="password" class="form-control" id="password" readonly value="********">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                               
                                <!-- <form>
                                    <div class="col-md-12 p-3" style="background-color:rgb(194, 190, 190) ; border-radius: 20px;">
                                        <img src="{{asset('/theme/Images/dress6.png')}}" alt="User Photo" class="rounded-circle profile-image">
                                    </div>
                                  
                                    <div class="form-group">
                                        
                                        <label for="fullName"><strong>Full Name</strong></label>
                                        <input type="text" class="form-control" id="fullName" value="John Doe" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><strong>Email Address</strong></label>
                                        <input type="email" class="form-control" id="email" value="johndoe@example.com" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone"><strong>Phone Number</strong></label>
                                        <input type="tel" class="form-control" id="phone" value="+1 234 567 8901" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Address</strong></label>
                                        <textarea class="form-control" id="address" rows="3" readonly>1234 Main St, City, Country</textarea>
                                    </div>
                                </form> -->
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
                


        <!--=============================Order History========================================================-->        
                <!-- Order History Section -->
                <div id="order-history-section" class="tab-pane fade">
                    <h2>Order History</h2>
                    <div class="card-deck">
                      
                        <div class="card mb-3">
                            <div class="row no-gutters">
                                <div class="col-md-3">
                                    <img src="{{asset('/theme/Images/10.jpg')}}" class="card-img m-2" alt="Pizza and Burger" style="width: 180px;" height="150px">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark">Order ID: #1234</h5>
                                        <span class="card-text text-dark"><strong> Costomer Name:</strong> Rupa kushwaha</span><br/>
                                        <span class="card-text text-dark"><strong>Date:</strong> 2024-09-21</span><br/>
                                        <span class="card-text text-dark"><strong>Price:</strong> Rs. 366</span><br/>
                                        <span class="card-text text-dark"><strong>Items:</strong> Pizza, Burger</span>
                                       
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p class="card-text mt-5 text-dark"><strong>Status:</strong> Delivered</p>
                                </div>
                            </div>
                        </div>
                
                      
                       
                    </div>
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <img src="{{asset('/theme/Images/10.jpg')}}" class="card-img m-2" alt="Pizza and Burger" style="width: 180px;" height="150px">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title">Order ID: #1234</h5>
                                    <span class="card-text text-dark" ><strong> Costomer Name:</strong> Rupa kushwaha</span><br/>
                                    <span class="card-text text-dark"><strong>Date:</strong> 2024-09-21</span><br/>
                                    <span class="card-text text-dark"><strong>Price:</strong> Rs. 366</span><br/>
                                    <span class="card-text text-dark"><strong>Items:</strong> Pizza, Burger</span>
                                   
                                </div>
                            </div>
                            <div class="col-md-2">
                                <p class="card-text mt-5 text-dark"><strong>Status:</strong> Delivered</p>
                            </div>
                        </div>
                    </div>
                </div>
                


                <!-- Payment Methods Section -->
                 <div id="payment-methods-section" class="tab-pane fade">
                   
                    <div class="container ">
                        
                     <!-- Button to Open the Modal, positioned to the right -->
                     <div class="add-payment-method mb-5 text-right">
                        <h2>Payment Methods
                       
                            <button class="btn btn-primary mx-5" data-toggle="modal" data-target="#addPaymentModal">Add New Payment Method</button>
                        </h2>
                        </div>
                        <div class="card-container">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>Visa **** 1234</span>
                                    <button class="btn btn-danger btn-sm">Remove</button>
                                </div>
                                <div class="card-body">
                                    <p>Cardholder Name: John Doe</p>
                                    <p>Expiry Date: 12/24</p>
                                </div>
                            </div>
                            <div class="card mt-5">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>MasterCard **** 5678</span>
                                    <button class="btn btn-danger btn-sm">Remove</button>
                                </div>
                                <div class="card-body">
                                    <p>Cardholder Name: John Doe</p>
                                    <p>Expiry Date: 10/25</p>
                                </div>
                            </div>
                        </div>
                    
                       
                    </div>
                    
                    <!-- Modal for Adding New Payment Method -->
                    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPaymentModalLabel">Add New Payment Method</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="cardType">Card Type</label>
                                            <select class="form-control" id="cardType">
                                                <option>Visa</option>
                                                <option>MasterCard</option>
                                                <option>American Express</option>
                                                <option>UPI</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="cardNumber">Card Number</label>
                                            <input type="text" class="form-control" id="cardNumber" placeholder="Enter card number" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="cardHolderName">Cardholder Name</label>
                                            <input type="text" class="form-control" id="cardHolderName" placeholder="Enter cardholder name" required>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="expiryDate">Expiry Date</label>
                                                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cvv">CVV</label>
                                                <input type="password" class="form-control" id="cvv" placeholder="Enter CVV" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Payment Method</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>           
                  </div> 

              

                <!-- Account Settings Section -->
                <div id="account-settings-section" class="tab-pane fade">
                   
                    <div class="container text-center my-5">
                        <div class="card mx-auto" style="max-width: 600px;">
                          <div class="card-body">
                            <h2 class="card-title" style="color: black;">You Have Logged Out</h2>
                            <span class="card-text" style="color: rgb(109, 105, 105);">Thank you for visiting! You have successfully logged out of your account.</span>
                            <span class="card-text" style="color: rgb(109, 105, 105);">Would you like to log back in or return to the homepage?</span>
                      
                            <div class="mt-4">
                              <a href="login.html" class="btn btn-primary">Log In Again</a>
                              <a href="index.html" class="btn btn-secondary">Return to Homepage</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- <p>Manage your account settings here.</p> -->
                </div>

               
            </div>
        </div>
    </div>
@endsection

@section('scriptJs')
<script>


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



 // Image Preview Functionality
 document.getElementById("imageUpload").addEventListener("change", function(event) {
        let reader = new FileReader();
        reader.onload = function() {
            let previewImage = document.getElementById("previewImage");
            let profilePic = document.getElementById("profilePic");
            previewImage.src = reader.result;
            profilePic.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    // Save Changes Functionality
    document.getElementById("saveChanges").addEventListener("click", function() {
        let newName = document.getElementById("userName").value;
        let newPhone = document.getElementById("userPhone").value;
        document.querySelector(".sidebar-header h5").innerText = newName;
        document.querySelector(".sidebar-header p").innerText = newPhone;
        $("#profileModal").modal("hide");
    });



document.querySelectorAll('.nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            // Remove active class from all links
            document.querySelectorAll('.nav-link').forEach(function(nav) {
                nav.classList.remove('active-link');
            });

            // Add active class to the clicked link
            this.classList.add('active-link');
        });
    });



    // Get the navbar
var navbar = document.getElementById("navbar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Create a placeholder element for the navbar
var placeholder = document.createElement("div");
placeholder.classList.add('sticky-placeholder');

// Add a scroll event listener
window.onscroll = function() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky");   // Add sticky class when you scroll past the navbar
        navbar.parentNode.insertBefore(placeholder, navbar); // Insert the placeholder to avoid layout shift
    } else {
        navbar.classList.remove("sticky");  // Remove sticky class when above navbar position
        if (navbar.parentNode.contains(placeholder)) {
            navbar.parentNode.removeChild(placeholder); // Remove the placeholder when navbar is not sticky
        }
    }
};






document.getElementById('profile-link').addEventListener('click', function() {
    showSection('profile-section');
});
document.getElementById('order-history-link').addEventListener('click', function() {
    showSection('order-history-section');
});
document.getElementById('payment-methods-link').addEventListener('click', function() {
    showSection('payment-methods-section');
});
// document.getElementById('addresses-link').addEventListener('click', function() {
//     showSection('addresses-section');
// });
document.getElementById('account-settings-link').addEventListener('click', function() {
    showSection('account-settings-section');
});
// document.getElementById('help-support-link').addEventListener('click', function() {
//     showSection('help-support-section');
// });

function showSection(sectionId) {
    document.querySelectorAll('.section-content').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}


// ===================================================

function openPopup() {
    document.getElementById("downloadPopup").style.display = "block";
}

function closePopup() {
    document.getElementById("downloadPopup").style.display = "none";
}





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