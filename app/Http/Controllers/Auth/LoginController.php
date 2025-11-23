<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\LoginRequestDTO;
use App\Http\Controllers\Controller;
use App\Services\Auth\LoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $loginService
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $loginData = new LoginRequestDTO(
            username: $request->input('username'),
            password: $request->input('password')
        );

        $user = $this->loginService->authenticate($loginData);

        if (!$user) {
            return back()->withErrors(['username' => 'بيانات الدخول غير صحيحة']);
        }

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/login');
    }
}