@extends('layout.index')
@section('title', 'GrowMart')
@section('styleCss')
@endsection

@section('bodyContent')
<div class="container">
    <h4 class="text-center mt-5">My Profile</h4>
    <form id="profileForm" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Profile Image -->
            <div class="col-md-4">
                <label>Profile Image</label>
                <input type="file" name="profile_image" class="form-control">
                <br>
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('uploads/profile_images/' . Auth::user()->profile_image) }}" alt="Profile Image" width="100">
                @endif
            </div>

            <div class="col-md-8">
                <label>Name</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required>

                <label>Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" required>

                <label>Mobile</label>
                <input type="text" name="mobile" value="{{ Auth::user()->mobile }}" class="form-control" required>

                <label>City</label>
                <input type="text" name="city" value="{{ Auth::user()->city }}" class="form-control">

                <label>State</label>
                <input type="text" name="state" value="{{ Auth::user()->state }}" class="form-control">

                <label>Pincode</label>
                <input type="text" name="pincode" value="{{ Auth::user()->pincode }}" class="form-control">

                <label>Address</label>
                <textarea name="address" class="form-control">{{ Auth::user()->address }}</textarea>

                <button type="button" id="updateProfileBtn" class="btn btn-primary mt-3">Update Profile</button>
            </div>
        </div>
    </form>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $('#updateProfileBtn').click(function() {
        Swal.fire({
            title: "Are you sure?",
            text: "You want to update your profile?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData($('#profileForm')[0]);

                $.ajax({
                    url: "/profile/update",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            title: "Updated!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Reload page after clicking "OK"
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Something went wrong!", "error");
                    }
                });
            }
        });
    });
});
</script>
@endsection
@section('scriptJs')

@endsection
