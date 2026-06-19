<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Claim;
use App\Models\Notification;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data user secara dinamis
        $budi = User::where('email', 'budi@student.campus.edu')->first();
        $saya = User::where('email', 'saya@student.campus.edu')->first();
        $admin = User::where('email', 'admin@campus.edu')->first();
        $satpam = User::where('email', 'satpam@campus.edu')->first();

        // Ambil kategori secara dinamis
        $elektronik = Category::where('name', 'Elektronik')->first();
        $dokumen = Category::where('name', 'Dokumen')->first();
        $pakaian = Category::where('name', 'Pakaian/Aksesoris')->first();
        $lainnya = Category::where('name', 'Lainnya')->first();

        if (!$budi || !$saya || !$admin || !$satpam) {
            return;
        }

        // 1. Seed Tabel Items (Barang Hilang & Ditemukan)
        
        // Item 1: Laptop ASUS ROG (Status: Hilang - dilaporkan oleh Budi)
        $item1 = Item::firstOrCreate(
            ['name' => 'Laptop ASUS ROG G14'],
            [
                'item_code' => 'LF-' . mt_rand(100000, 999999),
                'category_id' => $elektronik->id,
                'reporter_id' => $budi->id,
                'description' => 'Laptop ASUS ROG Zephyrus G14 warna abu-abu gelap, terdapat stiker GitHub di bagian belakang layar. Hilang sekitar jam 2 siang.',
                'location_lost' => 'Perpustakaan Utama Lantai 2 (Area Belajar)',
                'date_lost' => Carbon::now()->subDays(5),
                'status' => 'hilang',
                'is_confidential' => false,
            ]
        );

        // Item 2: Kunci Motor Honda Vario (Status: Ditemukan - dilaporkan oleh Satpam)
        $item2 = Item::firstOrCreate(
            ['name' => 'Kunci Motor Honda Vario'],
            [
                'item_code' => 'LF-' . mt_rand(100000, 999999),
                'category_id' => $lainnya->id,
                'reporter_id' => $satpam->id,
                'finder_id' => $satpam->id,
                'description' => 'Ditemukan kunci motor Honda dengan gantungan hitam. Ditemukan tergantung di stop kontak tiang parkiran.',
                'location_found' => 'Parkiran Motor Barat',
                'date_found' => Carbon::now()->subDays(3),
                'status' => 'ditemukan',
                'is_confidential' => true,
                'hidden_details' => 'Ada gantungan kunci berbentuk boneka karet beruang coklat kecil.',
                'drop_off_location' => 'Pos Satpam Gerbang Utama',
            ]
        );

        // Item 3: Dompet Kulit Coklat (Status: Selesai - ditemukan oleh Saya, diklaim oleh Budi)
        $item3 = Item::firstOrCreate(
            ['name' => 'Dompet Kulit Levi\'s Coklat'],
            [
                'item_code' => 'LF-' . mt_rand(100000, 999999),
                'category_id' => $pakaian->id,
                'reporter_id' => $saya->id,
                'finder_id' => $saya->id,
                'description' => 'Ditemukan dompet kulit pria warna coklat merk Levi\'s tergeletak di kursi kantin.',
                'location_found' => 'Kantin Gedung C',
                'date_found' => Carbon::now()->subDays(2),
                'status' => 'selesai',
                'is_confidential' => true,
                'hidden_details' => 'Di dalamnya berisi kartu mahasiswa atas nama Budi Santoso dan uang tunai Rp 120.000.',
                'drop_off_location' => 'Layanan Informasi Gedung C',
                'verified_by' => $admin->id,
                'verified_at' => Carbon::now()->subDay(),
            ]
        );

        // Item 4: Botol Tumbler Corkcicle (Status: Hilang - dilaporkan oleh Saya)
        $item4 = Item::firstOrCreate(
            ['name' => 'Tumbler Corkcicle Biru Tosca'],
            [
                'item_code' => 'LF-' . mt_rand(100000, 999999),
                'category_id' => $lainnya->id,
                'reporter_id' => $saya->id,
                'description' => 'Tumbler Corkcicle 16oz warna biru tosca (turquoise) tertinggal di ruang kelas setelah kuliah pemrograman.',
                'location_lost' => 'Gedung B Ruang Kelas 402',
                'date_lost' => Carbon::now()->subDay(),
                'status' => 'hilang',
                'is_confidential' => false,
            ]
        );

        // Item 5: Jas Hujan Eiger Merah (Status: Diklaim - ditemukan oleh Satpam)
        $item5 = Item::firstOrCreate(
            ['name' => 'Jas Hujan Eiger Merah'],
            [
                'item_code' => 'LF-' . mt_rand(100000, 999999),
                'category_id' => $pakaian->id,
                'reporter_id' => $satpam->id,
                'finder_id' => $satpam->id,
                'description' => 'Jas hujan setelan (celana + jaket) warna merah merk Eiger tertinggal di gantungan lobi pos keamanan.',
                'location_found' => 'Lobi Pos Keamanan Utama',
                'date_found' => Carbon::now()->subDays(4),
                'status' => 'diklaim',
                'is_confidential' => false,
                'drop_off_location' => 'Pos Satpam Gerbang Utama',
            ]
        );

        // 2. Seed Tabel Claims (Klaim Barang)

        // Klaim 1: Budi mengklaim Jas Hujan Eiger Merah (Status: Pending)
        $claim1 = Claim::firstOrCreate(
            [
                'item_id' => $item5->id,
                'claimant_id' => $budi->id,
            ],
            [
                'description' => 'Jas hujan merah saya tertinggal kemarin waktu berteduh di pos satpam saat hujan lebat.',
                'proof_details' => 'Di bagian punggung ada robekan kecil yang sudah ditambal dengan lakban hitam.',
                'status' => 'pending',
            ]
        );

        // Klaim 2: Budi mengklaim Dompet Kulit Levi\'s Coklat (Status: Approved / Selesai)
        $claim2 = Claim::firstOrCreate(
            [
                'item_id' => $item3->id,
                'claimant_id' => $budi->id,
            ],
            [
                'description' => 'Saya kehilangan dompet di kantin saat makan siang. Dompet itu berisi KTM saya.',
                'proof_details' => 'KTM di dalamnya atas nama saya Budi Santoso, jurusan Teknik Informatika.',
                'status' => 'approved',
                'verified_by' => $admin->id,
                'verified_at' => Carbon::now()->subDay(),
                'notes' => 'Bukti KTM sangat cocok, barang sudah diambil langsung oleh pemilik.',
            ]
        );

        // Klaim 3: Saya mengklaim Kunci Motor Honda Vario (Status: Rejected)
        $claim3 = Claim::firstOrCreate(
            [
                'item_id' => $item2->id,
                'claimant_id' => $saya->id,
            ],
            [
                'description' => 'Kunci motor vario saya hilang hari selasa kemarin di parkiran barat.',
                'proof_details' => 'Gantungan kuncinya warna hitam polos tanpa mainan.',
                'status' => 'rejected',
                'verified_by' => $admin->id,
                'verified_at' => Carbon::now()->subDays(2),
                'rejection_reason' => 'Bukti gantungan kunci tidak cocok dengan gantungan beruang coklat pada barang asli.',
            ]
        );

        // 3. Seed Tabel Notifications (Notifikasi)

        // Notifikasi untuk Budi tentang klaim dompet disetujui
        Notification::firstOrCreate(
            [
                'user_id' => $budi->id,
                'title' => 'Klaim Dompet Disetujui',
            ],
            [
                'message' => 'Selamat, klaim Anda untuk "Dompet Kulit Levi\'s Coklat" telah disetujui oleh admin. Silakan ambil barang di Layanan Informasi Gedung C.',
                'type' => 'both',
                'is_read' => true,
                'related_item_id' => $item3->id,
                'related_claim_id' => $claim2->id,
            ]
        );

        // Notifikasi untuk Saya tentang klaim kunci ditolak
        Notification::firstOrCreate(
            [
                'user_id' => $saya->id,
                'title' => 'Klaim Kunci Motor Ditolak',
            ],
            [
                'message' => 'Maaf, klaim Anda untuk "Kunci Motor Honda Vario" ditolak oleh admin karena bukti yang Anda berikan kurang cocok.',
                'type' => 'in_app',
                'is_read' => false,
                'related_item_id' => $item2->id,
                'related_claim_id' => $claim3->id,
            ]
        );

        // Notifikasi untuk Satpam tentang adanya klaim baru jas hujan
        Notification::firstOrCreate(
            [
                'user_id' => $satpam->id,
                'title' => 'Pengajuan Klaim Baru',
            ],
            [
                'message' => 'Ada pengajuan klaim baru untuk barang "Jas Hujan Eiger Merah" oleh Budi Santoso. Harap periksa di dashboard verifikasi.',
                'type' => 'both',
                'is_read' => false,
                'related_item_id' => $item5->id,
                'related_claim_id' => $claim1->id,
            ]
        );
    }
}
