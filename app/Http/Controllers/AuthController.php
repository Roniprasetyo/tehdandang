<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MockDataService;

class AuthController extends Controller
{
    protected MockDataService $mockData;

    public function __construct(MockDataService $mockData)
    {
        $this->mockData = $mockData;
    }

    public function loginView()
    {
        return view('auth.login', [
            'users' => $this->mockData->getUsers()
        ]);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $user = $this->mockData->getUserByUsername($username);

        if ($user) {
            session(['user' => $user]);
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'User not found in mock list');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }

    public function switchRole(Request $request)
    {
        $username = $request->input('username');
        $user = $this->mockData->getUserByUsername($username);

        if ($user) {
            session(['user' => $user]);
        }

        return redirect()->back()->with('success', 'Switched role to ' . $user['role']);
    }
}
