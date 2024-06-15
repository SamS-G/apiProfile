<?php

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\CreateProfileController;
    use App\Http\Controllers\EditProfileController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\DeleteProfileController;
    use App\Http\Controllers\ShowProfileController;
    use Illuminate\Support\Facades\Route;

// Secured endpoints, need active account and logged in

    Route::prefix('profile')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            {
                Route::post('/name', [ShowProfileController::class, 'showByName'])->name('name');
                Route::post('/create', [CreateProfileController::class, 'create'])->name('create');
                Route::put('/edit', [EditProfileController::class, 'edit'])->name('edit');
                Route::delete('/delete/{id}', [DeleteProfileController::class, 'delete'])->name('delete');
            }
        });
    });

// Public endpoints

    // This endpoint show all actives profiles without "status" column if current user are not logged in
    Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout']);


