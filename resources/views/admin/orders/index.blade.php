@extends('admin.layouts.master')

@push('title')
Order List
@endpush

@section('content')
<div class="row">
    <div class="col-6">
        <h6 class="mb-0 text-uppercase">Orders</h6>
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
            <table class="table table-striped table-hover table-bordered no-footer" id="orderList">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Order No</th>
                        <th>User</th>
                        <th>Products</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Order Status</th>
                        <th>Placed At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                        <td>{{ $order->product_names }}</td>
                        <td>₹{{ $order->final_amount }}</td>
                        <td>
                            {{ ucfirst($order->payment_method) }} <br>
                            <span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span>
                        </td>
                        <td><span class="badge bg-primary">{{ ucfirst($order->order_status) }}</span></td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                    @php $i++ @endphp
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
