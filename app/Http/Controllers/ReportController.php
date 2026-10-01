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

        // Data arrays for various report types
        $reportData = [
            'sales' => $this->mockData->getSalesOrders(),
            'outlet' => $outlets,
            'product' => $products,
            'ro' => $this->mockData->getRoData(),
            'roa' => $this->mockData->getRoaData(),
            'ro_item' => $this->mockData->getRoItems(),
            'gps' => $this->mockData->getGpsData(),
            'route' => $this->mockData->getRoutes(),
            'performance' => $salesList,
            'sap' => $this->mockData->getSalesOrders(),
            'early_warning' => $this->mockData->getEarlyWarnings(),
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
