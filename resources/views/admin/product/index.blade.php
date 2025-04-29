{{-- {{ dd($products) }} --}}
@extends('admin.layouts.master')
@push('title')
    Product List
@endpush
<style>
    .image-preview-scroll {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        gap: 10px;
        scroll-behavior: smooth;
    }

    .image-box {
        position: relative;
        display: inline-block;
    }

    .image-box img {
        height: 100px;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .remove-btn {
        position: absolute;
        top: -6px;
        right: -6px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 14px;
        cursor: pointer;
        line-height: 18px;
        text-align: center;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-6">
            <h6 class="mb-0 text-uppercase">Product</h6>
        </div>
        <div class="col-6 text-end px-0 px-lg-3">
            <a href="javascript:void(0);" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal"
                data-bs-target="#productVariantModal">
                <i class='bx bx-plus'></i> Add Product Variant
            </a>
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm px-3">
                <i class='bx bx-plus'></i>Add
            </a>
        </div>
    </div>
    <hr />
    @if (session('success'))
        <div class="alert alert-success mt-3 mb-2">
            {{ session('success') }}
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="productVariantModal" tabindex="-1" aria-labelledby="productVariantModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productVariantModalLabel">Add Product Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="variantForm" enctype="multipart/form-data">
                        @csrf
                        <!-- Product Select Dropdown with Search -->
                        <div class="mb-3">
                            <label for="productSelect" class="form-label">Select Product</label><br />
                            <select style="width: 100%;" id="productSelect" name="productSelect" name="product_id"
                                class="form-control form-select" required>
                                <option value="">Choose a product...</option>
                                @if ($products->isEmpty())
                                    <option>No products available</option>
                                @else
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->product_name }}">
                                            {{ $product->product_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Variant Name Input -->
                        <div class="mb-3">
                            <label for="variantName" class="form-label">Variant Name</label>
                            <input type="text" class="form-control" id="variantName" name="variant_name"
                                placeholder="EX : Size/color" required>
                        </div>

                        <!-- Variant Input -->
                        <div class="mb-3">
                            <label for="variant" class="form-label">Variant</label>
                            <input type="text" class="form-control" id="variant" name="variant"
                                placeholder="Ex : 1KG/Red" required>
                        </div>

                        <!-- Quantity Input -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Sale Price</label>
                            <input type="number" class="form-control" id="sale_price" name="sale_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">MRP Price</label>
                            <input type="number" class="form-control" id="mrp_price" name="mrp_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Upload Images</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple
                                accept="image/*">
                        </div>

                        <!-- Image preview area -->
                        <div id="imagePreview" class="image-preview-scroll mb-3 mt-2"></div>

                        <button type="submit" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm me-1 d-none" id="spinner" role="status"
                                aria-hidden="true"></span>
                            Save Variant
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                                    <img src="{{ asset($product->product_image) }}" width="50" height="50"
                                        alt="Product Image">
                                </td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->sale_price }}</td>
                                <td>{{ $product->mrp_price }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->category ? $product->categoryName->category_name : 'N/A' }}</td>
                                <td>
                                    @if ($product->product_status == 1)
                                        Active
                                    @else
                                        Inactive
                                    @endif
                                </td>
                                <td>
                                    @if ($product->payment_method == 'cod_only')
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
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $('#variantForm').on('submit', function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Get selected product info
                let selectedProduct = $('#productSelect').find(':selected');
                let productSalePrice = selectedProduct.data('price');

                formData.append('product_name', productSalePrice);

                // Show spinner and disable button
                $('#spinner').removeClass('d-none');
                $('#submitBtn').attr('disabled', true).css('opacity', 0.6);

                // Append multiple images manually if needed (optional - already covered by formData)
                let images = $('#images')[0].files;
                for (let i = 0; i < images.length; i++) {
                    formData.append('images[]', images[i]);
                }

                $.ajax({
                    url: "{{ route('admin.product.variance.store') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Variant added successfully!');
                        $('#variantForm')[0].reset();
                        $('#productSelect').val('').trigger('change');
                        $('#imagePreview').empty();

                        // Hide spinner and enable button
                        $('#spinner').addClass('d-none');
                        $('#submitBtn').attr('disabled', false).css('opacity', 1);
                    },
                    error: function(xhr) {
                        $('#spinner').addClass('d-none');
                        $('#submitBtn').attr('disabled', false).css('opacity', 1);

                        if (xhr.status === 500) {
                            // Laravel validation error
                            let errors = xhr.responseJSON.errors;
                            let msg = '';
                            for (let field in errors) {
                                msg += `${errors[field][0]}\n`;
                            }
                            alert(msg);
                        } else {
                            alert('Something went wrong! Try again.');
                            console.error(xhr.responseText);
                        }
                    }
                });
            });

        });
        $('#productVariantModal').on('shown.bs.modal', function() {
            $('#productSelect').select2({
                dropdownParent: $('#productVariantModal'),
                placeholder: "Search for a product",
                allowClear: true
            });
        });

        let selectedFiles = [];

        document.getElementById('images').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            selectedFiles = [...selectedFiles, ...files]; // add new ones

            renderPreview();
        });

        function renderPreview() {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = ''; // clear previous

            selectedFiles.forEach((file, index) => {
                const imgUrl = URL.createObjectURL(file);

                const box = document.createElement('div');
                box.className = 'image-box';

                const img = document.createElement('img');
                img.src = imgUrl;

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '&times;';
                removeBtn.className = 'remove-btn';
                removeBtn.onclick = () => {
                    selectedFiles.splice(index, 1);
                    renderPreview();
                };

                box.appendChild(img);
                box.appendChild(removeBtn);
                preview.appendChild(box);
            });
        }
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
    <script>
        $(document).ready(function() {
            $('#categoryList').DataTable({
                "pageLength": 17,
                "lengthChange": true,
                "ordering": true,
                "searching": true,
                "responsive": true
            });
        });
    </script>
@endpush
