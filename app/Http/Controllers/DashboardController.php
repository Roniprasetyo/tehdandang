<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MockDataService;

class DashboardController extends Controller
{
    protected MockDataService $mockData;

    public function __construct(MockDataService $mockData)
    {
        $this->mockData = $mockData;
    }

    public function index()
    {
        $user = session('user');
        
        // Auto adapt primary view per role
        if ($user['role'] === 'Sales') {
            return redirect()->route('dashboard.sales');
        } elseif ($user['role'] === 'Fleet Admin') {
            return redirect()->route('transaksi.checkin-gps');
        }
        
        return $this->executive();
    }

    public function executive()
    {
        $user = session('user');
        $dashboardData = $this->mockData->getDashboardData();
        $earlyWarnings = $this->mockData->getEarlyWarnings();
        $salesList = $this->mockData->getSales($user);
        $outlets = $this->mockData->getOutlets($user);

        return view('dashboard.executive', compact('dashboardData', 'earlyWarnings', 'salesList', 'outlets', 'user'));
    }

    public function sales()
    {
        $user = session('user');
        $salesData = $this->mockData->getSales($user)[0] ?? null;
        $visits = $this->mockData->getVisits($user);
        $outlets = $this->mockData->getOutlets($user);

        return view('dashboard.sales', compact('salesData', 'visits', 'outlets', 'user'));
    }

    public function area()
    {
        $user = session('user');
        $areas = $this->mockData->getAreas();
        $salesList = $this->mockData->getSales($user);

        return view('dashboard.area', compact('areas', 'salesList', 'user'));
    }

    public function earlyWarning()
    {
        $user = session('user');
        $warnings = $this->mockData->getEarlyWarnings();
        $salesList = $this->mockData->getSales($user);
        $areas = $this->mockData->getAreas();

        return view('dashboard.early_warning', compact('warnings', 'salesList', 'areas', 'user'));
    }

    public function drilldown()
    {
        $user = session('user');
        $areas = $this->mockData->getAreas();
        $salesList = $this->mockData->getSales($user);
        $outlets = $this->mockData->getOutlets($user);
        $products = $this->mockData->getProducts();

        return view('dashboard.drilldown', compact('areas', 'salesList', 'outlets', 'products', 'user'));
    }
}
