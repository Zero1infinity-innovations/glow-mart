@extends('admin.layouts.master')
@push('title')
    Banner List
@endpush
@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Banner</h6>
    </div>
    <div class="col-6 text-end px-0 px-lg-3">
        <a href="{{route('admin.banner.create')}}" class="btn btn-primary btn-sm px-3"><i class='bx bx-plus'></i>Add</a>
    </div>
</div>
<hr />
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered no-footer" id="bannerList">
                <thead class="table-light">
                    <tr id="thead-html">
                        <th>S no.</th>
                        <th>Banner Type</th>
                        <th>Banner Image</th>
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
            table = $("#bannerList").DataTable({
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
                ajax: "{{route('admin.banner.index')}}",
                columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable:false},
                    {data: 'banner_type', name: 'banner_type', orderable: false, searchable:false},
                    {data: 'image', name: 'image', orderable: false, searchable:false},
                    {data: 'status', name: 'status', orderable: false, searchable:false},
                    {data: 'action', name: 'action', orderable: false, searchable:false},
                ]
            })
        });
    </script>
@endpush