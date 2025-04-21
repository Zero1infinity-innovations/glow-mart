@extends('admin.layouts.master')
@push('title')
Product List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Product</h6>
    </div>
</div>
<hr />
@if(session('success'))
    <div class="alert alert-success mt-3 mb-2">
        {{ session('success') }}
    </div>
@endif
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered no-footer" id="data-table">
                <thead class="table-light">
                    <tr id="thead-html">
                        <th>ID</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Sale Price</th>
                        <th>MRP Price</th>
                        <th>Quantity</th>
                        <!-- <th>Category</th> -->
                        <th>Status</th>
                        <th>Payment Method</th>
                        <!-- <th>Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($productLists as $assigned)
                    <tr>
                        <td>{{ $assigned->product->id }}</td>
                        <td>
                            <img src="{{ asset($assigned->product->product_image) }}" style="border-radius:50px;" width="50" height="50" alt="Product Image">
                        </td>
                        <td>{{ $assigned->product->product_name }}</td>
                        <td>{{ $assigned->product->sale_price }}</td>
                        <td>{{ $assigned->product->mrp_price }}</td>
                        <td>{{ $assigned->quantity }}</td>
                        <td>
                            @if($assigned->product->product_status == 1)
                            Active
                            @else
                            Inactive
                            @endif
                        </td>
                        <td>
                            @if($assigned->product->payment_method == 'cod_only')
                            COD
                            @else
                            Prepaid
                            @endif
                        </td>
                        <!-- <td>
                            <a href="{{ route('admin.product.edit', $assigned->product->id) }}"
                                class="btn btn-sm btn-warning">Edit</a>

                            <button class="btn btn-sm btn-danger delete-product"
                                data-id="{{ $assigned->product->id }}">Delete</button>

                            <form id="delete-form-{{ $assigned->product->id }}"
                                action="{{ route('admin.product.destroy', $assigned->product->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td> -->
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $productLists->links() }}
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete-product").forEach(button => {
        button.addEventListener("click", function() {
            let productId = this.getAttribute("data-id");

            Swal.fire({
                title: "Are you sure?",
                text: "This record will be deleted permanently!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("delete-form-" + productId).submit();
                }
            });
        });
    });
});
</script>

@endpush