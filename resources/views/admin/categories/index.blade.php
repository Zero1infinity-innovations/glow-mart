@extends('admin.layouts.master')
@push('title')
Product List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Category</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.category.create')}}" class="btn btn-primary btn-sm px-3"><i
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
                        <th>Category Name</th>
                        <th>Category Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <img src="{{ asset($category->category_image) }}" style="border-radius:50px;" width="50" height="50" alt="Shop Image">
                        </td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->category_dis }}</td>
                        <td>
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @php $i++ @endphp
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No Category Record.</td>
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