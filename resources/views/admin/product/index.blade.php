@extends('admin.layouts.master')
@push('title')
Product List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Product</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.product.create')}}" class="btn btn-primary btn-sm px-3"><i
                class='bx bx-plus'></i>Add</a>
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
            <table class="table table-striped table-hover table-bordered no-footer" id="categoryList">
                <thead class="table-light">
                    <tr id="thead-html">
                        <th>ID</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Sale Price</th>
                        <th>MRP Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1 @endphp
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <img src="{{ asset($product->product_image) }}" width="50" height="50" alt="Product Image">
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->sale_price }}</td>
                        <td>{{ $product->mrp_price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category ? $product->categoryName->category_name : 'N/A' }}</td>
                        <td>
                            @if($product->product_status == 1)
                            Active
                            @else
                            Inactive
                            @endif
                        </td>
                        <td>
                            @if($product->payment_method == 'cod_only')
                            COD
                            @else
                            Prepaid
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.product.edit', $product->id) }}"
                                class="btn btn-sm btn-warning">Edit</a>

                            <button class="btn btn-sm btn-danger delete-product"
                                data-id="{{ $product->id }}">Delete</button>

                            <form id="delete-form-{{ $product->id }}"
                                action="{{ route('admin.product.destroy', $product->id) }}" method="POST"
                                style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @php $i++ @endphp
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $products->links() }}
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