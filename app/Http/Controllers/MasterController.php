<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MockDataService;

class MasterController extends Controller
{
    protected MockDataService $mockData;

    public function __construct(MockDataService $mockData)
    {
        $this->mockData = $mockData;
    }

    public function sales(Request $request)
    {
        $user = session('user');
        $salesList = $this->mockData->getSales($user);

        // Search & Filter
        if ($search = $request->query('search')) {
            $salesList = array_values(array_filter($salesList, fn($s) => 
                stripos($s['name'], $search) !== false || 
                stripos($s['npk'], $search) !== false || 
                stripos($s['area'], $search) !== false
            ));
        }

        return view('master.sales', compact('salesList', 'user'));
    }

    public function salesDetail($npk)
    {
        $user = session('user');
        $salesList = $this->mockData->getSales();
        $sales = null;
        foreach ($salesList as $s) {
            if ($s['npk'] === $npk) {
                $sales = $s;
                break;
            }
        }
        if (!$sales) abort(404, 'Sales not found');

        $outlets = array_values(array_filter($this->mockData->getOutlets(), fn($o) => strtolower($o['sales_name']) === strtolower($sales['name'])));
        $visits = array_values(array_filter($this->mockData->getVisits(), fn($v) => $v['sales_npk'] === $sales['npk']));
        $routes = array_values(array_filter($this->mockData->getRoutes(), fn($r) => $r['sales_npk'] === $sales['npk']));

        return view('master.sales_detail', compact('sales', 'outlets', 'visits', 'routes', 'user'));
    }

    public function outlet(Request $request)
    {
        $user = session('user');
        $outlets = $this->mockData->getOutlets($user);

        if ($search = $request->query('search')) {
            $outlets = array_values(array_filter($outlets, fn($o) => 
                stripos($o['card_name'], $search) !== false || 
                stripos($o['card_code'], $search) !== false || 
                stripos($o['address'], $search) !== false
            ));
        }

        if ($market = $request->query('market')) {
            $outlets = array_values(array_filter($outlets, fn($o) => $o['market'] === $market));
        }

        return view('master.outlet', compact('outlets', 'user'));
    }

    public function outletDetail($code)
    {
        $user = session('user');
        $outlets = $this->mockData->getOutlets();
        $outlet = null;
        foreach ($outlets as $o) {
            if ($o['card_code'] === $code) {
                $outlet = $o;
                break;
            }
        }
        if (!$outlet) abort(404, 'Outlet not found');

        $orders = array_values(array_filter($this->mockData->getSalesOrders(), fn($ord) => $ord['card_code'] === $outlet['card_code']));
        $visits = array_values(array_filter($this->mockData->getVisits(), fn($v) => $v['card_code'] === $outlet['card_code']));
        $products = $this->mockData->getProducts();

        return view('master.outlet_detail', compact('outlet', 'orders', 'visits', 'products', 'user'));
    }

    public function product(Request $request)
    {
        $user = session('user');
        $products = $this->mockData->getProducts();

        if ($search = $request->query('search')) {
            $products = array_values(array_filter($products, fn($p) => 
                stripos($p['item_name'], $search) !== false || 
                stripos($p['item_code'], $search) !== false
            ));
        }

        return view('master.product', compact('products', 'user'));
    }

    public function area()
    {
        $user = session('user');
        $areas = $this->mockData->getAreas();
        return view('master.area', compact('areas', 'user'));
    }

    public function route()
    {
        $user = session('user');
        $routes = $this->mockData->getRoutes($user);
        return view('master.route', compact('routes', 'user'));
    }

    public function vehicle()
    {
        $user = session('user');
        $vehicles = $this->mockData->getVehicles();
        return view('master.vehicle', compact('vehicles', 'user'));
    }

    public function market()
    {
        $user = session('user');
        $outlets = $this->mockData->getOutlets();
        $markets = [
            ['code' => 'GT', 'name' => 'General Trade (Toko / Warung Kelontong)', 'count' => count(array_filter($outlets, fn($o) => $o['market'] === 'GT'))],
            ['code' => 'MT', 'name' => 'Modern Trade (Supermarket / Minimarket)', 'count' => count(array_filter($outlets, fn($o) => $o['market'] === 'MT'))],
            ['code' => 'HOREKA', 'name' => 'Hotel, Restaurant, Cafe & Catering', 'count' => count(array_filter($outlets, fn($o) => $o['market'] === 'HOREKA'))],
        ];

        return view('master.market', compact('markets', 'outlets', 'user'));
    }
}
