<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Claim;
use App\Models\Notification;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Tampilkan daftar semua barang (halaman Cari Barang)
     */
    public function index(Request $request)
    {
        $query = Item::query()->with(['category', 'reporter']);

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
                    ->orWhere('location_found', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        $categories = Category::all();
        return view('item.index', compact('items', 'categories'));
    }

    /**
     * Tampilkan form tambah barang
     */
    public function create(Request $request)
    {
        $type = $request->type ?? 'hilang';

        if (!in_array($type, ['hilang', 'ditemukan'])) {
            abort(404);
        }

        $categories = Category::all();
        return view('item.create-barang', compact('type', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:hilang,ditemukan',
            'location_found' => 'nullable|required_if:status,ditemukan|string|max:100',
            'location_lost' => 'nullable|required_if:status,hilang|string|max:100',
            'date_found' => 'nullable|date',
            'date_lost' => 'nullable|date',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'hidden_details' => 'nullable|string',
        ]);

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("image{$i}")) {
                $validated["image{$i}"] = $request->file("image{$i}")->store('items', 'public');
            }
        }

        $validated['reporter_id'] = auth()->id();
        $validated['item_code'] = 'LF-' . strtoupper(substr(md5(time() . rand()), 0, 6));

        // Buat item baru
        $item = Item::create($validated);

        // ============================================
        // 🔔 AUTO NOTIFIKASI SETELAH LAPORAN DIBUAT
        // ============================================

        // 1. Notifikasi untuk Reporter (Konfirmasi)
        Notification::create([
            'user_id' => auth()->id(),
            'title' => $item->status === 'hilang' ? 'Laporan Kehilangan Diterima' : 'Laporan Barang Ditemukan Diterima',
            'message' => "Laporan '{$item->name}' ({$item->item_code}) telah berhasil dibuat. Kami akan segera mencari kecocokan.",
            'type' => 'in_app',
            'related_item_id' => $item->id,
        ]);

        // 2. Notifikasi untuk Admin/Satpam (Laporan Baru)
        $admins = \App\Models\User::whereIn('role', ['admin', 'satpam'])->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Laporan Baru Masuk',
                'message' => auth()->user()->name . " melaporkan " .
                    ($item->status === 'hilang' ? 'kehilangan' : 'menemukan') .
                    " '{$item->name}' di " .
                    ($item->status === 'hilang' ? ($item->location_lost ?? 'lokasi tidak diketahui') : ($item->location_found ?? 'lokasi tidak diketahui')),
                'type' => 'in_app',
                'related_item_id' => $item->id,
            ]);
        }

        // 3. 🔥 FITUR MATCHING: Cari barang yang cocok dengan laporan
        if ($item->status === 'ditemukan') {
            // Jika user menemukan barang, cari user yang melaporkan kehilangan barang serupa
            $matchingLostItems = Item::where('status', 'hilang')
                ->where('category_id', $item->category_id)
                ->where('reporter_id', '!=', $item->reporter_id) // Bukan reporter sendiri
                ->where('created_at', '>=', now()->subDays(30)) // Laporan 30 hari terakhir
                ->with('reporter')
                ->get();

            foreach ($matchingLostItems as $lostItem) {
                Notification::create([
                    'user_id' => $lostItem->reporter_id,
                    'title' => '🎯 Item Match Found!',
                    'message' => "Sistem kami menemukan barang yang mirip dengan '{$lostItem->name}' yang Anda laporkan hilang. Segera cek kesesuaian barang tersebut!",
                    'type' => 'in_app',
                    'related_item_id' => $item->id,
                ]);
            }
        } elseif ($item->status === 'hilang') {
            // Jika user melaporkan kehilangan, cari barang ditemukan yang serupa
            $matchingFoundItems = Item::where('status', 'ditemukan')
                ->where('category_id', $item->category_id)
                ->where('reporter_id', '!=', $item->reporter_id)
                ->where('created_at', '>=', now()->subDays(30))
                ->get();

            foreach ($matchingFoundItems as $foundItem) {
                Notification::create([
                    'user_id' => $foundItem->reporter_id,
                    'title' => '🎯 Potensi Kecocokan Barang',
                    'message' => "Ada user yang melaporkan kehilangan barang dengan kategori yang sama dengan '{$foundItem->name}' yang Anda temukan. Periksa apakah itu barang yang sama.",
                    'type' => 'in_app',
                    'related_item_id' => $item->id,
                ]);
            }
        }

        return redirect()->route('items.index')->with('success', 'Laporan berhasil dibuat!');
    }

    public function edit(Item $item)
    {
        if ($item->reporter_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $categories = Category::all();
        return view('item.edit-barang', compact('item', 'categories'));
    }

    public function show(Item $item)
    {
        $item->load(['category', 'reporter', 'finder']);

        // Barang serupa
        $similarItems = Item::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->where('status', 'ditemukan')
            ->limit(3)
            ->get();

        // Cek apakah user sudah mengklaim
        $userClaim = auth()->check() ? \App\Models\Claim::where('item_id', $item->id)
            ->where('claimant_id', auth()->id())->first() : null;

        return view('item.detail-barang', compact('item', 'similarItems', 'userClaim'));
    }

    /**
     * Update barang
     */
    public function update(Request $request, Item $item)
    {
        if ($item->reporter_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location_found' => 'nullable|string|max:100',
            'location_lost' => 'nullable|string|max:100',
            'date_found' => 'nullable|date',
            'date_lost' => 'nullable|date',
            'hidden_details' => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()->route('items.show', $item)->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Hapus barang
     */
    public function destroy(Item $item)
    {
        if ($item->reporter_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * AJUKAN KLAIM dari halaman detail barang
     */
    public function submitClaim(Request $request, Item $item)
    {
        // Cek apakah barang masih bisa diklaim
        if (!in_array($item->status, ['ditemukan', 'hilang'])) {
            return back()->with('error', 'Barang ini tidak dapat diklaim.');
        }

        // Cek apakah user sudah pernah mengklaim
        $existingClaim = Claim::where('item_id', $item->id)
            ->where('claimant_id', auth()->id())
            ->first();

        if ($existingClaim) {
            return back()->with('error', 'Anda sudah pernah mengajukan klaim untuk barang ini.');
        }

        // Validasi input klaim
        $validated = $request->validate([
            'description' => 'required|string|max:500',
            'proof_details' => 'required|string|max:1000',
        ]);

        // Buat klaim baru
        $claim = Claim::create([
            'item_id' => $item->id,
            'claimant_id' => auth()->id(),
            'description' => $validated['description'],
            'proof_details' => $validated['proof_details'],
            'status' => 'pending',
        ]);

        // Update status barang menjadi 'diklaim'
        $item->update(['status' => 'diklaim']);

        // Buat notifikasi untuk user
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Klaim Diajukan',
            'message' => "Klaim Anda untuk '{$item->name}' sedang dalam proses verifikasi admin.",
            'type' => 'in_app',
            'related_item_id' => $item->id,
            'related_claim_id' => $claim->id,
        ]);

        // Buat notifikasi untuk admin/satpam
        $admins = \App\Models\User::whereIn('role', ['admin', 'satpam'])->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Klaim Baru Masuk',
                'message' => "Ada klaim baru untuk barang '{$item->name}' dari " . auth()->user()->name,
                'type' => 'in_app',
                'related_item_id' => $item->id,
                'related_claim_id' => $claim->id,
            ]);
        }

        return back()->with('success', 'Permintaan klaim berhasil diajukan! Admin akan meninjau dalam 24 jam.');
    }
}
