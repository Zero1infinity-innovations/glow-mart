@extends('admin.layouts.master')

@push('title')
    Shop Stock List
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-6">
            <h6 class="mb-0 text-uppercase">Stock List</h6>
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
                <table id="data-table" class="table table-striped table-hover table-bordered no-footer">
                    <thead class="table-light">
                        <tr id="thead-html">
                            <th>S no.</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
