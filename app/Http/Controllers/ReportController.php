<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MockDataService;

class ReportController extends Controller
{
    protected MockDataService $mockData;

    public function __construct(MockDataService $mockData)
    {
        $this->mockData = $mockData;
    }

    public function index(Request $request)
    {
        $user = session('user');
        $type = $request->query('type', 'sales');

        $areas = $this->mockData->getAreas();
        $salesList = $this->mockData->getSales();
        $products = $this->mockData->getProducts();
        $outlets = $this->mockData->getOutlets();

        $roRaw = $this->mockData->getRoData();
        $roaRaw = $this->mockData->getRoaData();
        $gpsRaw = $this->mockData->getGpsData();
        $ewRaw = $this->mockData->getEarlyWarnings();

        // Data arrays for all 13 report types normalized cleanly
        $reportData = [
            'sales' => $this->mockData->getSalesOrders(),
            'outlet' => $outlets,
            'product' => $products,
            'ro' => $roRaw['outlet_ro_list'] ?? [],
            'roa' => $roaRaw['outlet_roa_list'] ?? [],
            'ro_item' => $this->mockData->getRoItems(),
            'gps' => $gpsRaw['vehicles'] ?? [],
            'route' => $this->mockData->getRoutes(),
            'performance' => $salesList,
            'sap' => $this->mockData->getSalesOrders(),
            'early_warning' => $ewRaw['warnings'] ?? [],
            'daily' => $this->mockData->getVisits(),
            'closing' => $this->mockData->getSalesOrders(),
        ];

        return view('report.index', compact(
            'type',
            'reportData',
            'areas',
            'salesList',
            'products',
            'outlets',
            'user'
        ));
    }
}
