<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProductRejected; // Buat notifikasi ini nanti
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Exports\ProductDetailExport;

class SuperadminProductController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Manajemen Produk';
        $tab = $request->input('tab', 'Traveler');
        $filter = $request->input('filter');
        $search = $request->input('search');

        $query = Product::with(['submiter', 'category']);

        if ($tab === 'Traveler') {
            $query->whereHas('submiter', fn($q) => $q->where('role', 'traveler'));
        } elseif ($tab === 'Customer') {
            $query->whereHas('submiter', fn($q) => $q->where('role', 'customer'));
        }

        if ($filter === 'Validasi') {
            $query->where('approval', 'pending');
        } elseif ($filter === 'Disetujui') {
            $query->where('approval', 'approved');
        } elseif ($filter === 'Ditolak') {
            $query->where('approval', 'declined');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('submiter', fn($sq) => $sq->where('name', 'like', "%{$search}%"))
                ->orWhereHas('category', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        $products = $query->latest()->paginate(10);
        $products->appends($request->query());

        return view('_superadmin.products.index', compact('title', 'products', 'tab'));
    }

    public function detail(Request $request)
    {
        $title = 'Detail Produk';
        $tab = $request->input('tab', 'Traveler');
        $product_id = $request->input('product_id');

        if (!$product_id) {
            return redirect()->route('superadmin.products');
        }

        $product = Product::with(['submiter', 'category'])->findOrFail($product_id);

        return view('_superadmin.products.detail', compact('title', 'product', 'tab'));
    }

    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['approval' => 'approved']);

        // Kirim notif ke submiter (opsional)
        // Notification::send($product->submiter, new ProductApproved($product));

        return back()->with('success', 'Produk berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        $product = Product::findOrFail($id);
        $product->update([
            'approval' => 'declined',
            'reject_reason' => $request->reason
        ]);

        // Kirim notifikasi ke submiter (sesuai BRD: "Kirim alasan penolakan")
        try {
            Notification::send($product->submiter, new ProductRejected($product, $request->reason));
        } catch (\Exception $e) {
            // Log error kalau perlu
        }

        return back()->with('success', 'Produk ditolak. Alasan telah dikirim ke ' . $product->submiter->name);
    }

    public function export(Request $request)
    {
        $tab = $request->input('tab', 'Traveler');
        $filter = $request->input('filter');
        $product_id = $request->input('product_id');

        if ($product_id) {
            // Export 1 produk dari detail
            $product = Product::with(['submiter', 'category'])->findOrFail($product_id);
            return Excel::download(new ProductDetailExport($product), 'detail_produk_' . $product->name . '_' . now()->format('Ymd_His') . '.xlsx');
        } else {
            // Export daftar produk dengan filter
            return Excel::download(new ProductsExport($tab, $filter), 'daftar_produk_' . $tab . '_' . now()->format('Ymd_His') . '.xlsx');
        }
    }
}