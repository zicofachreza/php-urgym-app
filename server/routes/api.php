<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Booking\CancelBookingController;
use App\Http\Controllers\Booking\CreateBookingController;
use App\Http\Controllers\Booking\GetMyBookingByIdController;
use App\Http\Controllers\Booking\GetMyBookingsController;
use App\Http\Controllers\Cashier\ScanMembershipBarcodeController;
use App\Http\Controllers\GymClass\GetAllGymClassController;
use App\Http\Controllers\GymClass\GetGymClassByIdController;
use App\Http\Controllers\MembershipPlan\GetAllMembershipPlanController;
use App\Http\Controllers\Payment\CreatePaymentController;
use App\Http\Controllers\Payment\MidtransCallbackController;
use App\Http\Controllers\User\GetMembershipBarcodeController;
use App\Http\Controllers\User\GetMyProfileController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post('/refresh', RefreshTokenController::class);
Route::post('/payments/midtrans/callback', MidtransCallbackController::class);

Route::middleware('auth:api')->group(function () {
    Route::get('/users/me', GetMyProfileController::class);
    Route::get('/gym-classes', GetAllGymClassController::class);
    Route::get('/gym-classes/{gymClass}', GetGymClassByIdController::class);
    Route::get('/bookings/me', GetMyBookingsController::class);
    Route::get('/bookings/{booking}', GetMyBookingByIdController::class);
    Route::post('/gym-classes/{gymClass}/book', CreateBookingController::class);
    Route::post('/bookings/{booking}/cancel', CancelBookingController::class)
        ->middleware('can:cancel,booking');
    Route::get('/membership-plans', GetAllMembershipPlanController::class);
    Route::post(
        '/membership-plans/{membershipPlan}/pay',
        CreatePaymentController::class
    );
    // Route::get('/users/membership/barcode', GetMembershipBarcodeController::class);
    Route::post(
        '/cashier/scan-barcode',
        ScanMembershipBarcodeController::class
    );
    Route::post('/logout', LogoutController::class);
});
