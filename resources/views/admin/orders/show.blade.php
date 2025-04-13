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
            <h5>Order Info</h5>
            <p><strong>Order No:</strong> {{ $order->order_number }}</p>
            <p><strong>User:</strong> {{ $order->user->name ?? 'Guest' }} ({{ $order->user->email ?? '-' }})</p>
            <p><strong>Total:</strong> ₹{{ number_format($order->final_amount, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Payment Status:</strong>
                <span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span>
            </p>
            <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Billing Address:</strong> {{ $order->billing_address }}</p>
            <p><strong>Notes:</strong> {{ $order->notes ?? 'N/A' }}</p>

            <form method="POST" action="{{ route('admin.order.updateStatus', $order->id) }}" class="mt-3">
                @csrf
                <label>Change Order Status</label>
                <div class="d-flex gap-2">
                    <select name="order_status" class="form-select w-auto">
                        @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary">Update</button>
                </div>
            </form>

            <a href="{{ route('admin.order.invoice', $order->id) }}" class="btn btn-outline-dark btn-sm mt-3">Download
                Invoice</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Ordered Products</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th class="text-end">MRP (₹)</th>
                        <th class="text-end">Sale Price (₹)</th>
                        <th class="text-end">Quantity</th>
                        <th class="text-end">Total (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->orderItems as $item)
                        <tr>
                            <td>
                                <img src="{{ asset($item->product->product_image) }}" width="60" alt="Product Image">
                            </td>
                            <td>{{ $item->product->product_name }}</td>
                            <td class="text-end">₹{{ number_format($item->product->mrp_price, 2) }}</td>
                            <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No products found in this order.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($order->orderItems->count())
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                            <td class="text-end">₹{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Shipping:</strong></td>
                            <td class="text-end">₹{{ number_format($order->shipping_charge, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Final Total:</strong></td>
                            <td class="text-end"><strong>₹{{ number_format($order->final_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
@endsection
