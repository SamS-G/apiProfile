<?php

    use App\Http\Controllers\Authenticate\AuthController;
    use App\Http\Controllers\Profile\CreateProfileController;
    use App\Http\Controllers\Profile\DeleteProfileController;
    use App\Http\Controllers\Profile\EditProfileController;
    use App\Http\Controllers\Profile\IndexProfileController;
    use App\Http\Controllers\Profile\ShowProfileController;
    use Illuminate\Support\Facades\Route;

// Public endpoints

    // This endpoint show all actives profiles without "status" column if current user are not logged in
    Route::get('/profiles', [IndexProfileController::class, 'index'])->name('profiles');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

// Secured endpoints, need active account and logged in

    Route::prefix('profile')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            {
                Route::get('/name', [ShowProfileController::class, 'showByName'])->name('name');
                Route::post('/create', [CreateProfileController::class, 'create'])->name('create');
                Route::put('/edit', [EditProfileController::class, 'edit'])->name('edit');
                Route::delete('/delete/{id}', [DeleteProfileController::class, 'delete'])->name('delete');
            }
        });
    });



