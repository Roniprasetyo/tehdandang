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
        $matrix = [
            'Sales' => ['own_data_only' => true, 'dashboard' => 'Sales', 'master' => ['Outlet'], 'transaksi' => ['Visit', 'GPS Check-in', 'Sales Order', 'NOO', 'NOP', 'RO', 'RO Item'], 'report' => ['My Performance']],
            'Admin Area' => ['own_data_only' => false, 'area_scope' => 'Single City / Area', 'master' => ['Sales', 'Outlet', 'Product', 'Route'], 'transaksi' => ['All Area Transactions'], 'report' => ['Area Reports']],
            'Admin Pusat' => ['own_data_only' => false, 'area_scope' => 'All Indonesia', 'master' => ['All'], 'transaksi' => ['All'], 'report' => ['All Reports'], 'admin' => ['User Management', 'Integration Monitoring', 'Audit Log']],
            'ASM' => ['own_data_only' => false, 'area_scope' => 'Subordinates (Sales)', 'master' => ['Sales', 'Outlet', 'Route'], 'transaksi' => ['View Subordinates'], 'report' => ['Team Reports']],
            'Manager' => ['own_data_only' => false, 'area_scope' => 'Region / Area', 'master' => ['Sales', 'Outlet', 'Area', 'Route'], 'transaksi' => ['View Region'], 'report' => ['Region Performance']],
            'GM' => ['own_data_only' => false, 'area_scope' => 'All Indonesia', 'master' => ['View All'], 'transaksi' => ['View All'], 'report' => ['Executive Reports', 'Early Warning']],
            'Finance' => ['own_data_only' => false, 'area_scope' => 'National Finance', 'master' => ['Outlet SAP', 'Product Price'], 'transaksi' => ['Sales Order SAP'], 'report' => ['SAP Financial Reports']],
            'Fleet Admin' => ['own_data_only' => false, 'area_scope' => 'National Vehicles', 'master' => ['Vehicle', 'Route'], 'transaksi' => ['Check-in GPS', 'Route Live Map'], 'report' => ['GPS Compliance Report']],
            'IT' => ['own_data_only' => false, 'area_scope' => 'System Admin', 'master' => ['All System Data'], 'transaksi' => ['All'], 'report' => ['System & Integration Log'], 'admin' => ['Full Access']]
        ];

        return view('administration.role_permission', compact('matrix', 'user'));
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
