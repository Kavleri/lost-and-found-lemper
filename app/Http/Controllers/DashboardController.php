<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Claim;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Halaman Dashboard Utama
     */
    public function index(Request $request)
    {
        // Statistik
        $stats = [
            'total_items' => Item::count(),
            'found_items' => Item::where('status', 'ditemukan')->count(),
            'lost_items' => Item::where('status', 'hilang')->count(),
            'claimed_items' => Item::where('status', 'diklaim')->count(),
        ];

        // Kategori untuk filter
        $categories = Category::all();

        // Query untuk items
        $query = Item::with(['category', 'reporter']);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location_found', 'like', "%{$search}%")
                  ->orWhere('location_lost', 'like', "%{$search}%");
            });
        }

        // Get items dengan pagination
        $items = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        // Barang terbaru untuk carousel/highlight
        $latestItems = Item::with(['category'])
            ->where('status', 'ditemukan')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('dashboard', compact(
            'stats',
            'items',
            'categories',
            'latestItems'
        ));
    }

    /**
     * Tampilkan detail item (bisa juga menggunakan ItemController@show)
     */
    public function showItem($id)
    {
        $item = Item::with(['category', 'reporter', 'finder', 'claims.claimant'])
            ->findOrFail($id);

        // Barang serupa
        $similarItems = Item::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->where('status', 'ditemukan')
            ->limit(3)
            ->get();

        return view('item.detail-barang', compact('item', 'similarItems'));
    }
}
