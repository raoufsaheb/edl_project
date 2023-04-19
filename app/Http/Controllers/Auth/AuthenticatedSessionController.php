<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */

    //  public function redirectTo() {
    //     if (Auth::guard('vicedean')->check()) {
    //         return route('vicedean.dashboard');
    //     }
    
    //     if (Auth::guard('teacher')->check()) {
    //         return route('teacher.dashboard');
    //     }
    
    //     if (Auth::guard('condidate')->check()) {
    //         return route('condidate.dashboard');
    //     }
    
    //     if (Auth::guard('president')->check()) {
    //         return route('president.dashboard');
    //     }
    
    //     return route('home');
    // }
    
    // protected function authenticate(Request $request, $user)
    // {
    //     if ($user->role == 'vicedean') {
    //         return redirect()->route('vicedean.dashboard');
    //     } elseif ($user->role == 'teacher') {
    //         return redirect()->route('teacher.dashboard');
    //     } elseif ($user->role == 'condidat') {
    //         return redirect()->route('condidat.dashboard');
    //     } elseif ($user->role == 'president') {
    //         return redirect()->route('president.dashboard');
    //     } else {
    //         // Default redirect
    //         return redirect('/home');
    //     }
    // }







    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

    $request->session()->regenerate();

    $user = Auth::user();
        if ($user->role == 'vicedean') {
            return redirect()->route('vicedean.dashboard');
        } elseif ($user->role == 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->role == 'condidate') {
            return redirect()->route('condidate.dashboard');
        } elseif ($user->role == 'president') {
            return redirect()->route('president.dashboard');
        } else {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
