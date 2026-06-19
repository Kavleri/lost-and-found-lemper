<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use App\Models\Notification;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    /**
     * Halaman Klaim Saya (Tracker)
     */
    public function index()
    {
        $claims = Claim::where('claimant_id', auth()->id())
            ->with(['item.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung Statistik
        $stats = [
            'proses'  => $claims->whereIn('status', ['pending', 'verified'])->count(),
            'selesai' => $claims->where('status', 'approved')->count(),
            'total'   => $claims->count(),
        ];

        // Pisahkan klaim aktif dan riwayat
        $activeClaims = $claims->whereIn('status', ['pending', 'verified', 'approved']);
        $historyClaims = $claims->where('status', 'rejected');

        return view('claim.index', compact('stats', 'activeClaims', 'historyClaims'));
    }

    /**
     * Detail Klaim & Tampilkan QR Code
     */
    public function show(Claim $claim)
    {
        if ($claim->claimant_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke klaim ini.');
        }

        $claim->load(['item', 'item.category']);

        return view('claim.detail-klaim', compact('claim'));
    }

    /**
     * Upload Bukti Tambahan
     */
    public function uploadBukti(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'bukti_tambahan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan'        => 'nullable|string|max:500',
        ], [
            'bukti_tambahan.required' => 'File bukti wajib diunggah.',
            'bukti_tambahan.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $request->file('bukti_tambahan')->store('public/claims');

        $claim->update([
            'proof_details' => $claim->proof_details . "\n\n[Bukti Tambahan]: " . $path . "\n[Catatan]: " . ($validated['catatan'] ?? '-'),
            'status'        => 'pending', 
        ]);

        Notification::create([
            'user_id' => 1,
            'title' => 'Bukti Tambahan Klaim',
            'message' => "User " . auth()->user()->name . " mengunggah bukti tambahan untuk klaim #" . $claim->id,
            'type' => 'in_app',
            'related_claim_id' => $claim->id,
            'related_item_id' => $claim->item_id,
        ]);

        return back()->with('success', 'Bukti tambahan berhasil diunggah! Admin akan meninjau kembali.');
    }
}
