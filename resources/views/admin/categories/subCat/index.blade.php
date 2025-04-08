@extends('admin.layouts.master')
@push('title')
Product List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Sub Category</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.sub-category.create')}}" class="btn btn-primary btn-sm px-3"><i
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
                        <th>Sub Category</th>
                        <th>Parent Category</th>
                        <th>Sub Category Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($subCates as $subCate)
                    <tr>
                        <td>{{ $subCate->id }}</td>
                        <td>
                            <img src="{{ asset($subCate->subcate_image) }}" style="border-radius:50px;" width="50" height="50" alt="Shop Image">
                        </td>
                        <td>{{ $subCate->subcate_name }}</td>
                        <td>{{ $subCate->parentCategory->category_name ?? 'No Parent' }}</td>
                        <td>{{ $subCate->subcate_discription }}</td>
                        <td>
                            <a href="{{ route('admin.sub-category.edit', $subCate->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.sub-category.destroy', $subCate->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No Category Record.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $subCates->links() }}
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