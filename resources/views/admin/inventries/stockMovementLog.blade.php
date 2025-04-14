@extends('admin.layouts.master')

@push('title')
    Stock Movement Log
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-6">
            <h6 class="mb-0 text-uppercase">Moved Stock Log</h6>
        </div>
        {{-- <div class="col-6 text-end px-0 px-lg-3">
            <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary btn-sm px-3">
                <i class='bx bx-plus'></i> Add
            </a>
        </div> --}}
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered no-footer">
                    <thead class="table-light">
                        <tr>
                            <th>S No.</th>
                            <th>Product Name</th>
                            <th>Order Number</th>
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $sn++ }}</td>
                                <td>{{ $item->product_name ?? 'N/A' }}</td>
                                <td>{{ $item->order_number ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ ucwords($item->type) }}</td>
                                <td>{{ $item->reason ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
