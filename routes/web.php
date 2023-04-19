<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('compte')->attempt($credentials)) {
        $user = Auth::guard('compte')->user();

        // Check the user's type
        $type = $user->type;

        // Redirect the user to their respective dashboard based on their type
        if ($type == 'president') {
            return redirect('/president');
        } elseif ($type == 'vicedean') {
            return redirect('/vicedean');
        } elseif ($type == 'teacher') {
            return redirect('/teacher');
        } elseif ($type == 'candidate') {
            return redirect('/candidate');
        }

        // If the user's type is not recognized, redirect them to the default dashboard
        return redirect('/dashboard');
    }

    // If the authentication failed, redirect the user back to the login page with an error message
    return redirect('/login')->with('error', 'Invalid email or password.');
});


Route::get('/', function () {
    return view('welcome');
});

// Route::group(['middleware' => 'auth'], function () {
//     // Route for President dashboard
//     Route::get('/president', function () {
//         return view('president.dashboard');
//     })->middleware(['role:president']);

//     // Route for ViceDean dashboard
//     Route::get('/vicedean', function () {
//         return view('vicedean.dashboard');
//     })->middleware(['role:vicedean']);

//     // Route for Teacher dashboard
//     Route::get('/teacher', function () {
//         return view('teacher.dashboard');
//     })->middleware(['role:teacher']);

//     // Route for Candidate dashboard
//     Route::get('/candidate', function () {
//         return view('candidate.dashboard');
//     })->middleware(['role:candidate']);
// });


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
