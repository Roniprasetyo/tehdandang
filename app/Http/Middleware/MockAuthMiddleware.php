<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\MockDataService;

class MockAuthMiddleware
{
    protected MockDataService $mockData;

    public function __construct(MockDataService $mockData)
    {
        $this->mockData = $mockData;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($request->has('switch_user')) {
            $username = $request->query('switch_user');
            $user = $this->mockData->getUserByUsername($username);
            if ($user) {
                session(['user' => $user]);
            }
            return redirect()->to($request->url());
        }

        if (!session()->has('user')) {
            $defaultUser = $this->mockData->getUserByUsername('owner') ?? $this->mockData->getUserByUsername('admin-pusat');
            session(['user' => $defaultUser]);
        }

        view()->share('authUser', session('user'));
        view()->share('allUsers', $this->mockData->getUsers());

        return $next($request);
    }
}
