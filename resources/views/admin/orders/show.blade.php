@extends('admin.layouts.master')

@push('title')
    Order Details
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-3">Order Information</h5>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Order No:</strong> {{ $order->order_number }}</p>
                    <p><strong>User:</strong> {{ $order->user->name ?? 'Guest' }} ({{ $order->user->email ?? '-' }})</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                    <p><strong>Payment Status:</strong>
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    <p><strong>Order Status:</strong>
                        <span class="badge bg-info">{{ ucfirst($order->order_status) }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Shipping Charge:</strong> ₹{{ number_format($order->shipping_charge, 2) }}</p>
                    <p><strong>Final Amount:</strong> ₹{{ number_format($order->final_amount, 2) }}</p>
                    <p><strong>Notes:</strong> {{ $order->notes ?? 'N/A' }}</p>
                </div>
            </div>

            <hr>

            <p><strong>Shipping Address:</strong><br> {{ $order->shipping_address }}</p>
            <p><strong>Billing Address:</strong><br> {{ $order->billing_address }}</p>

            <form method="POST" action="{{ route('admin.order.updateStatus', $order->id) }}" class="mt-4">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="order_status" class="form-label">Change Order Status</label>
                        <select name="order_status" class="form-select">
                            @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                <option value="{{ $status }}"
                                    {{ $order->order_status == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </div>
                </div>
            </form>

            <a href="{{ route('admin.order.invoice', $order->id) }}" class="btn btn-outline-dark btn-sm mt-3">
                Download Invoice
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Ordered Products</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th class="text-end">MRP (₹)</th>
                            <th class="text-end">Sale Price (₹)</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Total MRP (₹)</th>
                            <th class="text-end">Paid (₹)</th>
                            <th class="text-end text-success">Saving (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($detailedItems as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset($item->product_image) }}" width="60" height="60"
                                        alt="Product Image">
                                </td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->sku }}</td>
                                <td class="text-end">₹{{ number_format($item->mrp_price, 2) }}</td>
                                <td class="text-end">₹{{ number_format($item->sale_price, 2) }}</td>
                                <td class="text-end">{{ $item->quantity }}</td>
                                <td class="text-end">₹{{ number_format($item->total_mrp, 2) }}</td>
                                <td class="text-end">₹{{ number_format($item->total_paid, 2) }}</td>
                                <td class="text-end text-success">₹{{ number_format($item->saving, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
