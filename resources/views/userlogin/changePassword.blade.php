@extends('layout.index')
@section('title', 'GrowMart')
@section('styleCss')
@endsection

@section('bodyContent')
<div class="container">

    <div class="row">
        <h4 class="text-center mt-5">Change Password</h4>
        <form id="passwordForm">
            @csrf
            <label>Current Password:</label>
            <input type="password" name="current_password" class="form-control mb-2" required>

            <label>New Password:</label>
            <input type="password" name="new_password" class="form-control mb-2" required>

            <label>Confirm New Password:</label>
            <input type="password" name="new_password_confirmation" class="form-control mb-2" required>

            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Change Password
    $("#passwordForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "/profile/change-password",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                Swal.fire("Success!", response.message, "success");
                $("#passwordForm")[0].reset();
            },
            error: function (xhr) {
                Swal.fire("Error!", xhr.responseJSON.message || "Something went wrong!", "error");
            }
        });
    });

    // $('#changePasswordBtn').click(function() {
    //     Swal.fire({
    //         title: "Are you sure?",
    //         text: "You want to change your password?",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         cancelButtonColor: "#d33",
    //         confirmButtonText: "Yes, change it!"
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             var formData = new FormData();
    //             $.ajax({
    //                 url: "/profile/change-password",
    //                 type: "POST",
    //                 data: $(this).serialize(),
    //                 success: function(response) {
    //                     Swal.fire({
    //                         title: "Password Changed!",
    //                         text: response.message,
    //                         icon: "success",
    //                         confirmButtonText: "OK"
    //                     }).then((result) => {
    //                         if (result.isConfirmed) {
    //                             location.reload(); // Reload page after clicking "OK"
    //                         }
    //                     });
    //                 },
    //                 error: function(xhr) {
    //                     Swal.fire("Error!", xhr.responseJSON.message, "error");
    //                 }
    //             });
    //         }
    //     });
    // });
});
</script>
@endsection
@section('scriptJs')

@endsection