@extends('admin.layouts.master')
@push('title')
    Category List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Category</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.category.create')}}" class="btn btn-primary btn-sm px-3"><i class='bx bx-plus'></i>Add</a>
    </div>
</div>
<hr />
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered no-footer" id="categoryList">
                <thead class="table-light">
                    <tr id="thead-html">
                        <th>S no.</th>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Slug</th>
                        <th>SEO Title</th>
                        <th>SEO Description</th>
                        <th>GMC Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        var table;
        $(function() {
            table = $("#categoryList").DataTable({
                processing: true,
                scrollY: true,
                scrollX: true,
                serverSide: true,
                autoWidth: false,
                scrollCollapse: true,
                bSearchable: true,
                "bFilter": false,
                "sDom": 'fBtlpi',
                "ordering": true,
                ajax: "{{route('admin.category.index')}}",
                columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable:false},
                    {data: 'category_name', name: 'category_name', orderable: false, searchable:false},
                    {data: 'category_image', name: 'category_image', orderable: false, searchable:false},
                    {data: 'slug', name: 'slug', orderable: false, searchable:false},
                    {data: 'seo_title', name: 'seo_title', orderable: false, searchable:false},
                    {data: 'seo_description', name: 'seo_description', orderable: false, searchable:false},
                    {data: 'gmc_category', name: 'gmc_category', orderable: false, searchable:false},
                    {data: 'status', name: 'status', orderable: false, searchable:false},
                    {data: 'action', name: 'action', orderable: false, searchable:false},
                ]
            })
        });
    </script>
@endpush