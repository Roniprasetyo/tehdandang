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
                'dashboard' => ['Dashboard Owner', 'Dashboard General Manager', 'Dashboard Regional Sales Manager', 'Dashboard Area Sales Manager', 'Dashboard Sales'],
                'master' => ['Master Wilayah', 'Master Area', 'Master Outlet / Mitra', 'Master Produk', 'Master Menu', 'Master Role', 'Master Setting'],
                'transaksi' => ['Transaksi Penjualan', 'Transaksi Registered Outlet Active (ROA)', 'Transaksi Riwayat Warning', 'Transaksi Integrasi SAP Business One'],
                'keterangan' => 'Penyajian ringkasan performa bisnis secara keseluruhan, meliputi tren penjualan, pencapaian target, perkembangan RO dan ROA, performa wilayah, serta masalah utama yang memerlukan perhatian manajemen.'
            ],
            'General Manager' => [
                'area_scope' => 'Nasional (Seluruh Wilayah & Area)',
                'dashboard' => ['Dashboard General Manager', 'Dashboard Regional Sales Manager', 'Dashboard Area Sales Manager', 'Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Master Karyawan', 'Master Struktur', 'Master Wilayah', 'Master Area', 'Master Jabatan', 'Master Outlet / Mitra', 'Master Produk', 'Master Kendaraan', 'Master Jenis Program Promosi', 'Master Parameter Early Warning', 'Master Setting'],
                'transaksi' => ['Transaksi Manajemen Outlet', 'Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi AP', 'Transaksi Lacak Kendaraan', 'Transaksi Setting Target', 'Transaksi Arahan Notifikasi', 'Transaksi Riwayat Warning', 'Transaksi Integrasi SAP Business One'],
                'keterangan' => 'Pemantauan performa penjualan lintas wilayah, pencapaian target bisnis, tren penjualan, status outlet aktif, serta rangkuman warning prioritas.'
            ],
            'Regional Sales Manager' => [
                'area_scope' => 'Regional (Provinsi / Multi-Area)',
                'dashboard' => ['Dashboard Regional Sales Manager', 'Dashboard Area Sales Manager', 'Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Master Karyawan', 'Master Wilayah', 'Master Area', 'Master Outlet / Mitra', 'Master Produk', 'Master Produk per Sales', 'Master Kendaraan', 'Master Jenis Program Promosi'],
                'transaksi' => ['Transaksi Registrasi Outlet', 'Transaksi Manajemen Outlet', 'Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi Check-in Outlet', 'Transaksi Hasil Kunjungan', 'Transaksi AP', 'Transaksi Lacak Kendaraan', 'Transaksi Riwayat Rute', 'Transaksi Setting Target'],
                'keterangan' => 'Pemantauan dan perbandingan performa penjualan antararea dalam wilayah regional, pencapaian target, serta warning yang memerlukan tindak lanjut.'
            ],
            'Area Sales Manager' => [
                'area_scope' => 'Area Tertentu (Kota/Depo & Tim Sales Binaan)',
                'dashboard' => ['Dashboard Area Sales Manager', 'Dashboard Admin Area', 'Dashboard Sales'],
                'master' => ['Master Karyawan', 'Master Area', 'Master Outlet / Mitra', 'Master Produk', 'Master Produk per Sales', 'Master Kendaraan', 'Master Tipe Pasar'],
                'transaksi' => ['Transaksi Registrasi Outlet', 'Transaksi Manajemen Outlet', 'Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi Jadwal Kunjungan', 'Transaksi Check-in Outlet', 'Transaksi Hasil Kunjungan', 'Transaksi AP', 'Transaksi Pemasangan MMT Geber', 'Transaksi Riwayat Warning'],
                'keterangan' => 'Pemantauan performa penjualan, produktivitas Sales, status RO dan ROA, realisasi kunjungan, serta warning outlet pada area yang dikelola ASM.'
            ],
            'Sales' => [
                'area_scope' => 'Rute Kunjungan & Outlet Sendiri',
                'dashboard' => ['Dashboard Sales'],
                'master' => ['Master Outlet / Mitra', 'Master Produk'],
                'transaksi' => ['Transaksi Registrasi Outlet', 'Transaksi Penjualan', 'Transaksi ROA', 'Transaksi NOP', 'Transaksi Jadwal Kunjungan', 'Transaksi Check-in Outlet', 'Transaksi Hasil Kunjungan', 'Transaksi AP', 'Transaksi Pemasangan MMT Geber', 'Transaksi Konsumsi Bahan Bakar', 'Transaksi Tindak Lanjut Outlet Tidak Aktif'],
                'keterangan' => 'Pemantauan target penjualan, realisasi penjualan, status RO dan ROA, penambahan NOP, serta realisasi kunjungan outlet oleh Sales.'
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
