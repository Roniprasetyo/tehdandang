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
                'code' => 'Owner',
                'title' => 'Owner',
                'responsibility' => 'Pemilik PT, melihat performa bisnis secara keseluruhan dan dashboard eksekutif',
                'area_scope' => 'Nasional (Seluruh Indonesia)',
                'action_rights' => 'View (V) pada seluruh dashboard eksekutif, master wilayah/produk/outlet, serta pemantauan penjualan & ROA nasional.',
                'keterangan' => 'Pemilik PT, melihat performa bisnis secara keseluruhan dan dashboard eksekutif'
            ],
            'General Manager (GM)' => [
                'code' => 'GM',
                'title' => 'General Manager (GM)',
                'responsibility' => 'Memantau performa bisnis lintas regional dan menangani masalah prioritas',
                'area_scope' => 'Nasional (Seluruh Wilayah & Regional)',
                'action_rights' => 'View (V) seluruh data bisnis, View & Approve (VA) untuk Proposal Akun (AP) & Setting Target, serta Create/Edit (CE) arahan notifikasi.',
                'keterangan' => 'Memantau performa bisnis lintas regional dan menangani masalah prioritas'
            ],
            'Regional Sales Manager (RSM)' => [
                'code' => 'RSM',
                'title' => 'Regional Sales Manager (RSM)',
                'responsibility' => 'Memantau performa penjualan pada wilayah regional',
                'area_scope' => 'Regional (Provinsi / Seluruh Area dalam Region)',
                'action_rights' => 'View (V) performa regional, View & Approve (VA) untuk Proposal Akun (AP) & Setting Target, Create/Edit (CE) arahan warning & outlet non-aktif.',
                'keterangan' => 'Memantau performa penjualan pada wilayah regional'
            ],
            'Area Sales Manager (ASM)' => [
                'code' => 'ASM',
                'title' => 'Area Sales Manager (ASM)',
                'responsibility' => 'Memantau dan mengelola aktivitas Sales pada area tanggung jawabnya',
                'area_scope' => 'Area Tertentu (Kota/Depo & Tim Sales Binaan)',
                'action_rights' => 'View & Approve (VA) Registrasi/Manajemen Outlet, NOP, AP, MMT, BBM, Target; Create/Edit (CE) Jadwal Kunjungan, Log Kendaraan, Arahan Warning.',
                'keterangan' => 'Memantau dan mengelola aktivitas Sales pada area tanggung jawabnya'
            ],
            'Sales' => [
                'code' => 'Sales',
                'title' => 'Sales',
                'responsibility' => 'Menjalankan aktivitas penjualan, kunjungan outlet, check-in, dan pencatatan hasil kunjungan',
                'area_scope' => 'Rute Kunjungan & Outlet Sendiri (Data Pribadi)',
                'action_rights' => 'Create & Edit (CE) untuk Registrasi Outlet, Pesanan Penjualan (SO), NOP, Jadwal, Check-in, Hasil Kunjungan, AP, MMT, dan Reimburse BBM.',
                'keterangan' => 'Menjalankan aktivitas penjualan, kunjungan outlet, check-in, dan pencatatan hasil kunjungan'
            ],
            'Admin' => [
                'code' => 'Admin',
                'title' => 'Admin',
                'responsibility' => 'Mengelola master data, akun pengguna, konfigurasi sistem, dan operasional administrasi',
                'area_scope' => 'Sistem Nasional (Master Data, User, Integrasi, & Operasional)',
                'action_rights' => 'Full CRUD untuk 18 Master Data (Karyawan, User, Menu, Role, Setting, Aplikasi, Produk, Wilayah, dll) serta transaksi operasional administrasi.',
                'keterangan' => 'Mengelola master data, akun pengguna, konfigurasi sistem, dan operasional administrasi'
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
            ['timestamp' => '2026-10-01 09:45:00', 'username' => 'asm-bandung', 'role' => 'Area Sales Manager', 'action' => 'Approve Account Proposal', 'details' => 'AP-2026-004 - Program Display Lebaran', 'ip' => '114.124.21.10'],
            ['timestamp' => '2026-10-01 09:12:30', 'username' => 'gm', 'role' => 'General Manager', 'action' => 'Export Executive Report', 'details' => 'Export PDF Regional Jabar & Jateng', 'ip' => '103.10.22.1'],
            ['timestamp' => '2026-10-01 08:30:11', 'username' => 'admin', 'role' => 'Admin', 'action' => 'Trigger SAP B1 Sync Test', 'details' => 'Sync 5 Master Items', 'ip' => '127.0.0.1']
        ];

        return view('administration.audit_log', compact('logs', 'user'));
    }
}
