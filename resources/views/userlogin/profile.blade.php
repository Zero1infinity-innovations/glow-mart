@extends('layout.index')
@section('title', 'GrowMart')
@section('styleCss')
@endsection

@section('bodyContent')
    <div class="container">
        @if (Auth::check())
            <h4 class="text-center mt-5">My Profile</h4>
            <form id="profileForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Profile Image -->
                    <div class="col-md-4">
                        <label>Profile Image</label>
                        <input type="file" name="profile_image" class="form-control">
                        <br>
                        @if (Auth::user()->profile_image)
                            <img src="{{ asset('uploads/profile_images/' . Auth::user()->profile_image) }}"
                                alt="Profile Image" width="150" height="150"
                                style="border-radius: 50%; object-fit: cover;">
                        @endif
                    </div>

                    <div class="col-md-8">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required>

                        <label>Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control"
                            required>

                        <label>Mobile</label>
                        <input type="text" name="mobile" value="{{ Auth::user()->mobile }}" class="form-control"
                            required>

                        <label>City</label>
                        <input type="text" name="city" value="{{ Auth::user()->city }}" class="form-control">

                        <label>State</label>
                        <input type="text" name="state" value="{{ Auth::user()->state }}" class="form-control">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Pincode</label>
                                <input type="text" id="pincode2" name="pincode" value="{{ Auth::user()->pincode }}"
                                    class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label>Select Shop</label>
                                <input type="hidden" id="preselectedShopId" value="{{ $shop->id }}">
                                <select name="shop_id" id="shopSelect1" class="form-control mb-2">
                                    <option value="">Select Shop</option>
                                    <option value="{{ $shop->id }}" selected>{{ $shop->shop_name }}</option>
                                </select>
                            </div>
                        </div>

                        <label>Address</label>
                        <textarea name="address" class="form-control">{{ Auth::user()->address }}</textarea>

                        <button type="button" id="updateProfileBtn" class="btn btn-primary mt-3">Update Profile</button>
                    </div>
                </div>
            </form>
        @else
            <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                <div class="text-center">
                    <div style="font-size: 80px;">🔐</div>
                    <h4 class="fw-bold mt-3">You are not logged in</h4>
                    <p class="text-muted">Please <a data-bs-toggle="modal" data-bs-target="#loginModal"
                            class="btn btn-primary">login</a> to continue shopping.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let preselectedShopId = $('#preselectedShopId').val();

        $('#pincode2').on('input', function() {
            let pincode = $(this).val();

            if (pincode.length === 6) {
                $.ajax({
                    url: `/get-shops/${pincode}`,
                    type: 'GET',
                    success: function(response) {
                        let $shopSelect = $('#shopSelect1');
                        let userSelectedShopId = $shopSelect
                    .val(); // agar user ne already manually select kiya ho

                        $shopSelect.empty().append('<option value="">Select Shop</option>');

                        $.each(response, function(index, shop) {
                            let selected = '';

                            if (userSelectedShopId && userSelectedShopId == shop.id) {
                                selected = 'selected';
                            } else if (!userSelectedShopId && preselectedShopId == shop.id) {
                                selected = 'selected';
                            }

                            $shopSelect.append(
                                `<option value="${shop.id}" ${selected}>${shop.shop_name}</option>`
                            );
                        });
                    },
                    error: function() {
                        $('#shopSelect1').empty().append(
                            '<option value="">No Shops Found</option>');
                    }
                });
            }
        });
        $(document).ready(function() {
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
                                        location
                                            .reload(); // Reload page after clicking "OK"
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
