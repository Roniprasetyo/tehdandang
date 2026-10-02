<?php

namespace App\Services;

class MockDataService
{
    protected function getJsonData(string $filename)
    {
        $path = resource_path("data/{$filename}.json");
        if (!file_exists($path)) {
            return [];
        }
        $content = file_get_contents($path);
        return json_decode($content, true) ?: [];
    }

    public function getUsers()
    {
        return $this->getJsonData('users');
    }

    public function getUserByUsername(string $username)
    {
        $users = $this->getUsers();
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        return $users[0] ?? null;
    }

    public function getSales($user = null)
    {
        $sales = $this->getJsonData('sales');
        if (!$user) return $sales;

        if ($user['role'] === 'Sales') {
            return array_values(array_filter($sales, fn($s) => $s['npk'] === $user['npk']));
        }
        if ($user['role'] === 'Admin Area') {
            return array_values(array_filter($sales, fn($s) => strtolower($s['area']) === strtolower($user['area'])));
        }
        if ($user['role'] === 'ASM' || $user['role'] === 'Manager') {
            return array_values(array_filter($sales, fn($s) => strtolower($s['region']) === strtolower($user['region'])));
        }
        return $sales;
    }

    public function getOutlets($user = null)
    {
        $outlets = $this->getJsonData('outlets');
        if (!$user) return $outlets;

        if ($user['role'] === 'Sales') {
            return array_values(array_filter($outlets, fn($o) => strtolower($o['sales_name']) === strtolower($user['name'])));
        }
        if ($user['role'] === 'Admin Area') {
            return array_values(array_filter($outlets, fn($o) => strtolower($o['city']) === strtolower($user['area']) || strtolower($o['kabupaten']) === strtolower($user['area'])));
        }
        if ($user['role'] === 'ASM' || $user['role'] === 'Manager') {
            return array_values(array_filter($outlets, fn($o) => strtolower($o['province']) === strtolower($user['region'])));
        }
        return $outlets;
    }

    public function getProducts()
    {
        return $this->getJsonData('products');
    }

    public function getAreas()
    {
        return $this->getJsonData('areas');
    }

    public function getRoutes($user = null)
    {
        $routes = $this->getJsonData('routes');
        if (!$user) return $routes;

        if ($user['role'] === 'Sales') {
            return array_values(array_filter($routes, fn($r) => $r['sales_npk'] === $user['npk']));
        }
        if ($user['role'] === 'Admin Area') {
            return array_values(array_filter($routes, fn($r) => strtolower($r['area']) === strtolower($user['area'])));
        }
        return $routes;
    }

    public function getVehicles($user = null)
    {
        $vehicles = $this->getJsonData('vehicles');
        if (!$user) return $vehicles;

        if ($user['role'] === 'Sales') {
            return array_values(array_filter($vehicles, fn($v) => ($v['sales_npk'] ?? '') === $user['npk'] || stripos($v['assigned_sales'] ?? '', $user['name']) !== false));
        }
        if ($user['role'] === 'Admin Area') {
            return array_values(array_filter($vehicles, fn($v) => stripos($v['area'] ?? '', $user['area']) !== false));
        }
        if ($user['role'] === 'ASM' || $user['role'] === 'Manager') {
            return array_values(array_filter($vehicles, fn($v) => stripos($v['area'] ?? '', $user['region']) !== false || stripos($v['area'] ?? '', $user['area']) !== false));
        }
        return $vehicles;
    }

    public function getSalesOrders($user = null)
    {
        $orders = $this->getJsonData('sales_orders');
        if (!$user) return $orders;

        if ($user['role'] === 'Sales') {
            return array_values(array_filter($orders, fn($o) => $o['slp_name'] === $user['name']));
        }
        if ($user['role'] === 'Admin Area') {
            return array_values(array_filter($orders, fn($o) => strtolower($o['area']) === strtolower($user['area'])));
        }
        return $orders;
    }

    public function getVisits($user = null)
    {
        $visits = $this->getJsonData('visits');
        if (!$user) return $visits;

        if ($user['role'] === 'Sales') {
            return array_values(array_filter($visits, fn($v) => $v['sales_npk'] === $user['npk']));
        }
        if ($user['role'] === 'Admin Area') {
            return array_values(array_filter($visits, fn($v) => strtolower($v['area']) === strtolower($user['area'])));
        }
        return $visits;
    }

    public function getRoData()
    {
        return $this->getJsonData('ro');
    }

    public function getRoaData()
    {
        return $this->getJsonData('roa');
    }

    public function getRoItems()
    {
        return $this->getJsonData('ro_items');
    }

    public function getNooData()
    {
        return $this->getJsonData('noo');
    }

    public function getNopData()
    {
        return $this->getJsonData('nop');
    }

    public function getAccountProposals()
    {
        return $this->getJsonData('account_proposals');
    }

    public function getGpsData($user = null)
    {
        $gps = $this->getJsonData('gps');
        if (!$user || !isset($gps['vehicles'])) {
            return $gps;
        }

        $allVehicles = $gps['vehicles'];
        $filteredVehicles = $allVehicles;

        if ($user['role'] === 'Sales') {
            $filteredVehicles = array_values(array_filter($allVehicles, function ($v) use ($user) {
                return (isset($v['sales_npk']) && $v['sales_npk'] === $user['npk']) || 
                       (isset($v['driver_sales']) && stripos($v['driver_sales'], $user['name']) !== false);
            }));
        } elseif ($user['role'] === 'Admin Area') {
            $filteredVehicles = array_values(array_filter($allVehicles, function ($v) use ($user) {
                return isset($v['area']) && stripos($v['area'], $user['area']) !== false;
            }));
        } elseif ($user['role'] === 'ASM' || $user['role'] === 'Manager') {
            $filteredVehicles = array_values(array_filter($allVehicles, function ($v) use ($user) {
                return isset($v['area']) && (
                    stripos($v['area'], $user['region']) !== false ||
                    stripos($v['area'], $user['area']) !== false
                );
            }));
        }

        $gps['vehicles'] = $filteredVehicles;
        $gps['total_vehicles'] = count($filteredVehicles);
        $gps['active_gps'] = count(array_filter($filteredVehicles, fn($v) => strtolower($v['status']) !== 'offline'));
        $gps['offline_gps'] = count(array_filter($filteredVehicles, fn($v) => strtolower($v['status']) === 'offline'));
        $gps['moving_gps'] = count(array_filter($filteredVehicles, fn($v) => strtolower($v['status_code'] ?? '') === 'moving'));
        $gps['idle_gps'] = count(array_filter($filteredVehicles, fn($v) => strtolower($v['status_code'] ?? '') === 'idle'));
        $gps['parked_gps'] = count(array_filter($filteredVehicles, fn($v) => strtolower($v['status_code'] ?? '') === 'parked'));
        $gps['sales_on_route'] = count($filteredVehicles);

        return $gps;
    }

    public function getEarlyWarnings()
    {
        return $this->getJsonData('early_warnings');
    }

    public function getDashboardData()
    {
        return $this->getJsonData('dashboard');
    }
}
