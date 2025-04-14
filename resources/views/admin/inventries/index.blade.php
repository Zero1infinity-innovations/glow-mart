@extends('admin.layouts.master')

@push('title')
    Stock List
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-6">
            <h6 class="mb-0 text-uppercase">Add Stock</h6>
        </div>
        <div class="col-6 text-end px-0 px-lg-3">
            @if (Auth::user()->role_id != 3)
                <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary btn-sm px-3">
                    <i class='bx bx-plus'></i> Add
                </a>
            @endif
        </div>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered no-footer">
                    <thead class="table-light">
                        <tr id="thead-html">
                            <th>S no.</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sn = 1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.inventory.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
