<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected function attemptLogin(Request $request)
{
    $result = $this->guard()->attempt(
        $this->credentials($request), $request->filled('remember')
    );

    if ($result && $this->guard()->user()->role == 'vicedean') {
        return redirect()->route('vicedean.dashboard');
    } elseif ($result && $this->guard()->user()->role == 'teacher') {
        return redirect()->route('teacher.dashboard');
    } elseif ($result && $this->guard()->user()->role == 'condidate') {
        return redirect()->route('condidate.dashboard');
    } elseif ($result && $this->guard()->user()->role == 'president') {
        return redirect()->route('president.dashboard');
    }

    return $result;
}

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'vicedean') {
            return redirect()->route('vicedean.dashboard');
        } elseif ($user->role == 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->role == 'condidat') {
            return redirect()->route('condidat.dashboard');
        } elseif ($user->role == 'president') {
            return redirect()->route('president.dashboard');
        } else {
            // Default redirect
            return redirect('/home');
        }
    }
}
