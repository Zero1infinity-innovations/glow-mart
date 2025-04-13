<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);

        foreach ($orders as $order) {
            $productIds = explode(',', $order->product_ids);
            $products = Product::whereIn('id', $productIds)->pluck('product_name')->toArray();
            $order->product_names = implode(', ', $products);
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id);

        $productIds = explode(',', $order->product_ids);
        $products = Product::whereIn('id', $productIds)->get();

        return view('admin.orders.show', compact('order', 'products'));
    }


    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }


    public function generateInvoice($orderId)
    {
        // Fetch order with related user and order items
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($orderId);
        $filename = "invoice-{$order->order_number}.pdf";

        // Check if invoice already exists
        $invoiceData = Invoice::where('order_number', $order->order_number)->first();

        if (!$invoiceData) {
            $invoiceData = Invoice::create([
                'order_number' => $order->order_number,
                'user_id' => $order->user_id,
                'file_path' => "invoices/" . $filename
            ]);
        }

        $invoiceId = $invoiceData->id;

        // Initialize values
        $subtotal = 0;
        $taxPercentage = $order->tax_amount ?? 0;
        $taxAmount = 0;
        $totalSavings = 0;

        // Loop through order items
        foreach ($order->orderItems as $orderItem) {
            $quantity = $orderItem->quantity;
            $mrp = $orderItem->product->mrp_price ?? 0;
            $salePrice = $orderItem->product->sale_price ?? 0;

            $subtotal += $quantity * $salePrice;

            // Calculate saving: (MRP - Sale Price) * Quantity
            if ($mrp > $salePrice) {
                $totalSavings += ($mrp - $salePrice) * $quantity;
            }
        }

        // Tax Calculation
        $taxAmount = ($subtotal * $taxPercentage) / 100;
        $total = $subtotal + $taxAmount;

        // Load and save PDF
        $pdf = PDF::loadView('admin.orders.invoice', compact(
            'order',
            'taxPercentage',
            'taxAmount',
            'subtotal',
            'total',
            'invoiceId',
            'totalSavings'
        ));

        $publicPath = public_path("invoices/{$filename}");

        if (!file_exists(public_path('invoices'))) {
            mkdir(public_path('invoices'), 0777, true);
        }

        $pdf->save($publicPath);

        return response()->download($publicPath);
    }
}
