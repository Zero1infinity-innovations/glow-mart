<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'shop'])->orderBy('created_at', 'desc')->paginate(10);

        foreach ($orders as $order) {
            $productIds = explode(',', $order->product_ids);
            $products = Product::whereIn('id', $productIds)->pluck('product_name')->toArray();
            $order->product_names = implode(', ', $products);

            // Shop name nikal lo
            $order->shop_name = optional($order->shop)->shop_name ?? 'N/A';
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'orderItems'])->findOrFail($id);
        $skus = $order->orderItems->pluck('sku')->unique();

        $variants = ProductVariant::whereIn('sku', $skus)->get()->keyBy('sku');
        $products = Product::whereIn('id', $variants->pluck('product_id'))->get()->keyBy('id');

        $detailedItems = [];
        $totalMrp = 0;
        $totalPaid = 0;

        foreach ($order->orderItems as $item) {
            $variant = $variants[$item->sku] ?? null;

            if ($variant) {
                $product = $products[$variant->product_id] ?? null;
                $mrp = $variant->mrp_price;
                $sale = $variant->sale_price;
            } else {
                $product = Product::where('sku', $item->sku)->first();
                $mrp = $product->mrp_price ?? 0;
                $sale = $product->sale_price ?? 0;
            }

            $total_mrp_item = $mrp * $item->quantity;
            $total_paid_item = $item->price * $item->quantity;

            $totalMrp += $total_mrp_item;
            $totalPaid += $total_paid_item;

            $detailedItems[] = (object)[
                'product_name' => $product->product_name ?? 'Unknown',
                'product_image' => $product->product_image ?? null,
                'sku' => $item->sku,
                'quantity' => $item->quantity,
                'mrp_price' => $mrp,
                'sale_price' => $sale,
                'price' => $item->price,
                'total_mrp' => $total_mrp_item,
                'total_paid' => $total_paid_item,
                'saving' => $total_mrp_item - $total_paid_item,
            ];
        }

        $orderSummary = [
            'tax_amount' => $order->tax_amount,
            'discount' => $order->discount,
            'total_mrp' => $totalMrp,
            'total_paid' => $totalPaid,
            'grand_total' => $totalPaid + $order->tax_amount - $order->discount,
            'total_saving' => ($totalMrp - $totalPaid) + $order->discount,
        ];
        // dd($detailedItems);

        return view('admin.orders.show', compact('order', 'detailedItems', 'orderSummary'));
    }


    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }


    // public function generateInvoice($orderId)
    // {
    //     // Fetch order with related user and order items
    //     $order = Order::with(['user', 'orderItems.product'])->findOrFail($orderId);
    //     dd($order);
    //     $filename = "invoice-{$order->order_number}.pdf";

    //     // Check if invoice already exists
    //     $invoiceData = Invoice::where('order_number', $order->order_number)->first();

    //     if (!$invoiceData) {
    //         $invoiceData = Invoice::create([
    //             'order_number' => $order->order_number,
    //             'user_id' => $order->user_id,
    //             'file_path' => "invoices/" . $filename
    //         ]);
    //     }

    //     $invoiceId = $invoiceData->id;

    //     // Initialize values
    //     $subtotal = 0;
    //     $taxPercentage = $order->tax_amount ?? 0;
    //     $taxAmount = 0;
    //     $totalSavings = 0;

    //     // Loop through order items
    //     foreach ($order->orderItems as $orderItem) {
    //         $quantity = $orderItem->quantity;
    //         $mrp = $orderItem->product->mrp_price ?? 0;
    //         $salePrice = $orderItem->product->sale_price ?? 0;

    //         $subtotal += $quantity * $salePrice;

    //         // Calculate saving: (MRP - Sale Price) * Quantity
    //         if ($mrp > $salePrice) {
    //             $totalSavings += ($mrp - $salePrice) * $quantity;
    //         }
    //     }

    //     // Tax Calculation
    //     $taxAmount = ($subtotal * $taxPercentage) / 100;
    //     $total = $subtotal + $taxAmount;

    //     // Load and save PDF
    //     $pdf = PDF::loadView('admin.orders.invoice', compact(
    //         'order',
    //         'taxPercentage',
    //         'taxAmount',
    //         'subtotal',
    //         'total',
    //         'invoiceId',
    //         'totalSavings'
    //     ));

    //     $publicPath = public_path("invoices/{$filename}");

    //     if (!file_exists(public_path('invoices'))) {
    //         mkdir(public_path('invoices'), 0777, true);
    //     }

    //     $pdf->save($publicPath);

    //     return response()->download($publicPath);
    // }

    public function generateInvoice($orderId)
    {
        // Load order, user, orderItems, and product variants via SKU
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($orderId);
        // dd($order->user->name);
        $filename = "invoice-{$order->order_number}.pdf";

        // Check if invoice already exists
        $invoiceData = Invoice::firstOrCreate(
            ['order_number' => $order->order_number],
            ['user_id' => $order->user_id, 'file_path' => "invoices/" . $filename]
        );

        $invoiceId = $invoiceData->id;

        // Initialize
        $subtotal = 0;
        $totalSavings = 0;
        $taxPercentage = $order->tax_amount ?? 0;

        // We'll fetch variants in one query using SKUs
        $skus = $order->orderItems->pluck('sku')->filter()->unique()->toArray();

        $variants = DB::table('product_variants')
            ->whereIn('sku', $skus)
            ->get()
            ->keyBy('sku');
        // Calculate totals
        foreach ($order->orderItems as $item) {
            $quantity = $item->quantity;
            $mrp = $item->product->mrp_price ?? 0;
            $salePrice = $item->product->sale_price ?? 0;

            $subtotal += $quantity * $salePrice;

            if ($mrp > $salePrice) {
                $totalSavings += ($mrp - $salePrice) * $quantity;
            }
        }

        $taxAmount = ($subtotal * $taxPercentage) / 100;
        $total = $subtotal + $taxAmount;

        $receivedAmount = $order->paid_amount ?? 0;

        $pdf = PDF::loadView('admin.orders.invoice', compact(
            'order',
            'invoiceId',
            'subtotal',
            'taxPercentage',
            'taxAmount',
            'total',
            'totalSavings',
            'receivedAmount',
            'variants'
        ));

        $publicPath = public_path("invoices/{$filename}");

        if (!file_exists(public_path('invoices'))) {
            mkdir(public_path('invoices'), 0777, true);
        }

        $pdf->save($publicPath);

        return response()->download($publicPath);
    }
}
