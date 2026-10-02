<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MockDataService;

class TransactionController extends Controller
{
    protected MockDataService $mockData;

    public function __construct(MockDataService $mockData)
    {
        $this->mockData = $mockData;
    }

    public function salesVisit()
    {
        $user = session('user');
        $visits = $this->mockData->getVisits($user);
        $outlets = $this->mockData->getOutlets($user);

        return view('transaksi.sales_visit', compact('visits', 'outlets', 'user'));
    }

    public function checkinGps()
    {
        $user = session('user');
        $gps = $this->mockData->getGpsData($user);
        $visits = $this->mockData->getVisits($user);

        return view('transaksi.checkin_gps', compact('gps', 'visits', 'user'));
    }

    public function salesOrder()
    {
        $user = session('user');
        $orders = $this->mockData->getSalesOrders($user);
        $outlets = $this->mockData->getOutlets($user);
        $products = $this->mockData->getProducts();
        $salesList = $this->mockData->getSales();

        return view('transaksi.sales_order', compact('orders', 'outlets', 'products', 'salesList', 'user'));
    }

    public function noo()
    {
        $user = session('user');
        $noo = $this->mockData->getNooData();

        return view('transaksi.noo', compact('noo', 'user'));
    }

    public function nop()
    {
        $user = session('user');
        $nop = $this->mockData->getNopData();

        return view('transaksi.nop', compact('nop', 'user'));
    }

    public function ro()
    {
        $user = session('user');
        $roData = $this->mockData->getRoData();
        $roaData = $this->mockData->getRoaData();

        return view('transaksi.ro', compact('roData', 'roaData', 'user'));
    }

    public function roItem()
    {
        $user = session('user');
        $roItems = $this->mockData->getRoItems();

        return view('transaksi.ro_item', compact('roItems', 'user'));
    }

    public function accountProposal()
    {
        $user = session('user');
        $proposals = $this->mockData->getAccountProposals();

        return view('transaksi.account_proposal', compact('proposals', 'user'));
    }
}
