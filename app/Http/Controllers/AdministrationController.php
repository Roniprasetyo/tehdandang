<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MockDataService;

class AdministrationController extends Controller
{
    protected MockDataService $mockData;

    public function __construct(MockDataService $mockData)
    {
        $this->mockData = $mockData;
    }

    public function user()
    {
        $user = session('user');
        $users = $this->mockData->getUsers();
        return view('administration.user', compact('users', 'user'));
    }

    public function rolePermission()
    {
        $user = session('user');
        $tasks = $this->mockData->getTasks();
        $tasksByCategory = [
            'Master Data' => array_values(array_filter($tasks, fn($t) => $t['kategori'] === 'Master Data')),
            'Transaksi Data' => array_values(array_filter($tasks, fn($t) => $t['kategori'] === 'Transaksi Data')),
            'Dashboard Data' => array_values(array_filter($tasks, fn($t) => $t['kategori'] === 'Dashboard Data')),
        ];

        $matrix = [
            'Owner' => [
                'area_scope' => 'Nasional (Seluruh Indonesia)',
                'dashboard' => ['Dashboard Owner', 'Dashboard GM', 'Dashboard RSM', 'Dashboard ASM', 'Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Master Wilayah', 'Master Area', 'Master Outlet / Mitra', 'Master Produk'],
                'transaksi' => ['Transaksi Penjualan', 'Transaksi Registered Outlet Active (ROA)', 'Transaksi Riwayat Warning'],
                'keterangan' => 'Penyajian ringkasan performa bisnis secara keseluruhan, tren penjualan, pencapaian target, dan evaluasi RO/ROA.'
            ],
            'GM' => [
                'area_scope' => 'Nasional (Seluruh Indonesia)',
                'dashboard' => ['Dashboard General Manager', 'Dashboard Regional Sales Manager', 'Dashboard Area Sales Manager', 'Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Master Karyawan', 'Master Struktur', 'Master Wilayah', 'Master Area', 'Master Jabatan', 'Master Outlet / Mitra', 'Master Produk', 'Master Jenis Program Promosi', 'Master Parameter Early Warning'],
                'transaksi' => ['Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi AP', 'Transaksi Lacak Kendaraan', 'Transaksi Setting Target', 'Transaksi Arahan Warning'],
                'keterangan' => 'Pemantauan performa penjualan lintas wilayah, pencapaian target bisnis, tren penjualan, status outlet aktif, serta rangkuman warning prioritas.'
            ],
            'Manager' => [
                'area_scope' => 'Regional (Provinsi / Wilayah)',
                'dashboard' => ['Dashboard Regional Sales Manager', 'Dashboard Area Sales Manager', 'Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Master Karyawan', 'Master Wilayah', 'Master Area', 'Master Outlet / Mitra', 'Master Produk', 'Master Produk per Sales', 'Master Jenis Program Promosi'],
                'transaksi' => ['Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi Hasil Kunjungan', 'Transaksi AP', 'Transaksi Lacak Kendaraan', 'Transaksi Setting Target'],
                'keterangan' => 'Pemantauan dan perbandingan performa penjualan antararea dalam wilayah regional, target bisnis, dan penanganan warning.'
            ],
            'ASM' => [
                'area_scope' => 'Area / Tim Sales Binaan',
                'dashboard' => ['Dashboard Area Sales Manager', 'Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Master Karyawan', 'Master Area', 'Master Outlet / Mitra', 'Master Produk', 'Master Produk per Sales', 'Master Jenis Program Promosi'],
                'transaksi' => ['Transaksi Registrasi Outlet', 'Transaksi Manajemen Outlet', 'Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi Jadwal Kunjungan', 'Transaksi Check-in Outlet', 'Transaksi Hasil Kunjungan', 'Transaksi AP', 'Transaksi Pemasangan MMT Geber', 'Transaksi Riwayat Warning'],
                'keterangan' => 'Pemantauan performa penjualan, produktivitas Sales, status RO/ROA, realisasi kunjungan, serta warning outlet area ASM.'
            ],
            'Admin Area' => [
                'area_scope' => '1 Area / Kota / Depo Terdaftar',
                'dashboard' => ['Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Master Area', 'Master Outlet / Mitra', 'Master Produk', 'Master Produk per Sales', 'Master Kendaraan', 'Master Tipe Pasar'],
                'transaksi' => ['Transaksi Registrasi Outlet', 'Transaksi Manajemen Outlet', 'Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi Jadwal Kunjungan', 'Transaksi Check-in Outlet', 'Transaksi Hasil Kunjungan', 'Transaksi AP', 'Transaksi Riwayat Rute'],
                'keterangan' => 'Pemantauan aktivitas Sales harian, persetujuan outlet, pencapaian target, dan administrasi operasional area.'
            ],
            'Sales' => [
                'area_scope' => 'Rute & Outlet Sendiri (Data Pribadi)',
                'dashboard' => ['Dashboard Sales'],
                'master' => ['Master Outlet / Mitra', 'Master Produk'],
                'transaksi' => ['Transaksi Registrasi Outlet', 'Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi Jadwal Kunjungan', 'Transaksi Check-in Outlet', 'Transaksi Hasil Kunjungan', 'Transaksi AP', 'Transaksi Pemasangan MMT Geber', 'Transaksi Konsumsi Bahan Bakar', 'Transaksi Tindak Lanjut Outlet Tidak Aktif'],
                'keterangan' => 'Pencatatan kunjungan fisik, pesanan penjualan (SO), pembukaan outlet baru (NOO), NOP, dan aktivasi ROA.'
            ],
            'Admin Pusat' => [
                'area_scope' => 'Seluruh Sistem & Regional',
                'dashboard' => ['Dashboard Owner', 'Dashboard GM', 'Dashboard RSM', 'Dashboard ASM', 'Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Semua 18 Master Data'],
                'transaksi' => ['Semua 22 Transaksi Data'],
                'keterangan' => 'Pengelolaan master data terpusat, otorisasi peran, pemantauan sistem, dan integrasi lintas departemen.'
            ],
            'Finance' => [
                'area_scope' => 'Finansial & SAP B1 Nasional',
                'dashboard' => ['Dashboard General Manager', 'Dashboard Regional Sales Manager'],
                'master' => ['Master Outlet / Mitra', 'Master Produk', 'Master Harga Produk SAP'],
                'transaksi' => ['Transaksi Penjualan', 'Transaksi AP', 'Transaksi Konsumsi Bahan Bakar', 'Transaksi Log Perpanjangan Kendaraan', 'Transaksi Log Sewa Kendaraan', 'Transaksi Integrasi SAP Business One'],
                'keterangan' => 'Verifikasi pesanan penjualan, sinkronisasi SAP Business One, klaim promosi AP, dan biaya operasional armada.'
            ],
            'Fleet Admin' => [
                'area_scope' => 'Armada Kendaraan Operasional',
                'dashboard' => ['Dashboard Admin Area'],
                'master' => ['Master Kendaraan', 'Master Area'],
                'transaksi' => ['Transaksi Check-in Outlet', 'Transaksi Lacak Kendaraan', 'Transaksi Riwayat Rute', 'Transaksi Log Perpanjangan Kendaraan', 'Transaksi Log Sewa Kendaraan', 'Transaksi Konsumsi Bahan Bakar', 'Transaksi Sinkronisasi GPS'],
                'keterangan' => 'Pemantauan GPS armada real-time, kesesuaian rute salesman, perawatan kendaraan, pajak STNK, dan BBM.'
            ],
            'IT' => [
                'area_scope' => 'Seluruh Infrastruktur & Aplikasi',
                'dashboard' => ['Seluruh 6 Dashboard Data'],
                'master' => ['Seluruh 18 Master Data'],
                'transaksi' => ['Seluruh 22 Transaksi Data'],
                'keterangan' => 'Pengelolaan Master Menu, Role, Role Access, User, Aplikasi, Sinkronisasi GPS Concox, dan Integrasi SAP Business One.'
            ]
        ];

        return view('administration.role_permission', compact('matrix', 'tasks', 'tasksByCategory', 'user'));
    }

    public function integration()
    {
        $user = session('user');
        $sapMapping = [
            'Business Partner' => [
                'table' => 'OCRD',
                'fields' => ['CardCode', 'CardName', 'CardType', 'GroupCode', 'SlpCode', 'Address', 'City', 'Province', 'Phone', 'Email', 'Active']
            ],
            'Item Master' => [
                'table' => 'OITM / OITB / ITM1',
                'fields' => ['ItemCode', 'ItemName', 'ItmsGrpCod', 'InvntryUom', 'SalUnitMsr', 'BuyUnitMsr', 'AvgPrice', 'Price', 'Active']
            ],
            'Sales Order' => [
                'table' => 'ORDR (Header) & RDR1 (Lines)',
                'fields' => ['DocEntry', 'DocNum', 'DocDate', 'CardCode', 'CardName', 'SlpCode', 'ItemCode', 'Dscription', 'Quantity', 'Price', 'LineTotal', 'DocTotal']
            ],
            'Delivery' => [
                'table' => 'ODLN & DLN1',
                'fields' => ['DocEntry', 'DocNum', 'DocDate', 'CardCode', 'ItemCode', 'Quantity']
            ],
            'Invoice' => [
                'table' => 'OINV & INV1',
                'fields' => ['DocEntry', 'DocNum', 'DocDate', 'CardCode', 'ItemCode', 'Quantity', 'LineTotal', 'DocTotal']
            ]
        ];

        $tracksolid = [
            'status' => 'Connected & Receiving Webhooks',
            'api_endpoint' => 'https://api.tracksolidpro.com/v2/route/live',
            'sync_frequency' => 'Real-time (Every 60s)',
            'last_sync' => '2026-10-01 10:05:12',
            'active_devices' => 42,
            'deviation_alerts' => 2
        ];

        return view('administration.integration', compact('sapMapping', 'tracksolid', 'user'));
    }

    public function auditLog()
    {
        $user = session('user');
        $logs = [
            ['timestamp' => '2026-10-01 10:02:15', 'username' => 'sales01', 'role' => 'Sales', 'action' => 'Create Sales Order', 'details' => 'DocNum #202609001 - Toko Berkah Utama', 'ip' => '180.252.12.44'],
            ['timestamp' => '2026-10-01 09:45:00', 'username' => 'admin-cirebon', 'role' => 'Admin Area', 'action' => 'Update Route Plan', 'details' => 'RT002 - Budi Raharjo', 'ip' => '114.124.21.10'],
            ['timestamp' => '2026-10-01 09:12:30', 'username' => 'gm', 'role' => 'GM', 'action' => 'Export Executive Report', 'details' => 'Export PDF Regional Jabar', 'ip' => '103.10.22.1'],
            ['timestamp' => '2026-10-01 08:30:11', 'username' => 'it-admin', 'role' => 'IT', 'action' => 'Trigger SAP B1 Sync Test', 'details' => 'Sync 5 Master Items', 'ip' => '127.0.0.1']
        ];

        return view('administration.audit_log', compact('logs', 'user'));
    }
}
