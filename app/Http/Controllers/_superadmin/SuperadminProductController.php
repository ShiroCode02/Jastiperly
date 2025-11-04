<?php

namespace App\Http\Controllers\_superadmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProductRejected; // Buat notifikasi ini nanti

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

        // === TAMBAH PENCARIAN ===
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

    public function show($id)
    {
        $product = Product::with(['submiter', 'category'])->findOrFail($id);
        $title = 'Detail Produk';

        return view('_superadmin.products.detail', compact('product', 'title'));
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
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $product = Product::findOrFail($id);
        $product->update(['approval' => 'declined']); // HANYA UPDATE approval

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

        $products = $query->get();

        $filename = "products_export_" . now()->format('Ymd_His') . ".csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama', 'Deskripsi', 'Harga', 'Submiter', 'Kategori', 'Status', 'Approval']);

            foreach ($products as $p) {
                fputcsv($file, [
                    $p->id,
                    $p->name,
                    strip_tags($p->description ?? '-'),
                    number_format($p->price, 0, ',', '.'),
                    $p->submiter->name ?? '-',
                    $p->category->name ?? '-',
                    ucfirst($p->status),
                    ucfirst(str_replace(['pending', 'approved', 'declined'], ['Validasi', 'Disetujui', 'Ditolak'], $p->approval))
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}