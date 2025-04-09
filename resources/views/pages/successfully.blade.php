@extends('layout.index')
@section('title', 'Order Placed Successfully')
<style>
    .btn-primary{
        background-color: #2E7D32 !important;
        border-color: #2E7D32 !important;
    }
</style>
@section('bodyContent')
<div class="container text-center" style="padding-top: 80px; padding-bottom: 60px;">

    <!-- Success Message -->
    <div style="font-size: 100px; color: green;">✅</div>
    <h2 class="text-success">Your order has been placed successfully!</h2>
    <p class="mt-3">Thank you for shopping with us. We will process your order shortly.</p>

    <a href="{{ url('/') }}" class="btn btn-primary mt-4">Continue Shopping</a>
</div>
@endsection
