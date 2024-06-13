<?php

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;


    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login'])->name('login');

//    Route::apiResource('/profiles', ProfileController::class);
    Route::get('/profile/{id}', [ProfileController::class,'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create',[ProfileController::class,'create'])->name('create');
        Route::put('/update/{id}',[ProFileController::class,'update'])->name('update');
        Route::delete('/delete/{id}',[ProfileController::class,'delete'])->name('delete');
        Route::post('/logout',[AuthController::class,'logout']);
    });

