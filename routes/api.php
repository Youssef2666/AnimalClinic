<?php

use App\Models\User;
use Illuminate\Http\Request;
use function Pest\Laravel\json;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SurgeryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AnimalCategoryController;
use App\Http\Controllers\SurgeryCategoryController;
use App\Http\Controllers\MedicineCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SadadController;
use App\Http\Controllers\VaccinationCategoryController;
use Faker\Provider\ar_EG\Payment;

Route::get('/test',function(){
    return "GOOOOOOOOOOOO";
})->middleware(['auth:sanctum', 'verified']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// Route::post('/forgot-password', [PasswordController::class, 'forgotPassword']);
// Route::post('/reset-password', [PasswordController::class, 'resetPassword']);
Route::post('/forget-password', [PasswordController::class, 'sendResetLinkEmail']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);



// Routes for authenticated users
Route::middleware(['auth:sanctum', 'status'])->group(function () {
    Route::get('authme', [AuthController::class, 'authme']);
    Route::delete('logout', [AuthController::class, 'logout']);
    Route::apiResources([
        'animals' => AnimalController::class,
        'doctors' => DoctorController::class,
        'medical_records' => MedicalRecordController::class,
        'animals_category' => AnimalCategoryController::class,
        'surgeries_category' => SurgeryCategoryController::class,
        'vaccinations_category' => VaccinationCategoryController::class,
        'medicines_category' => MedicineCategoryController::class,
        'surgeries' => SurgeryController::class,
        'medicines' => MedicineController::class,
        'vaccinations' => VaccinationController::class,
        'appointments' => AppointmentController::class,
        'products' => ProductController::class,
        'orders' => OrderController::class,
    ]);
    Route::get('animals/{id}/medical-record', [AnimalController::class, 'getMedicalRecordByAnimalId']);
    Route::get('appointments/{id}/doctor', [AppointmentController::class, 'getDoctorAppointments']);
    Route::post('orders/{id}/add-products', [OrderController::class, 'addProductsToOrder']);
});

Route::get('/animals/{id}/user', [AnimalController::class, 'getUserAnimals']);

// Routes for admin users
Route::middleware(['auth:sanctum', 'role:admin', 'status'])->group(function () {
    Route::get('check', function () {
        return 'Yes, I am Admin';
    });
});
Route::get('users', [AuthController::class, 'index']);

// Fallback route for handling 404 errors
Route::fallback(function () {
    return response()->json(['message' => 'Page Not Found.'], 404);
});

// Public route for ZoomController
Route::get('zoom', [ZoomController::class, 'index']);


//adfali
Route::post('adfali', [PaymentController::class, 'adfali']);
Route::post('adfali/confirm', [PaymentController::class, 'confirmPayment']);


//sadad
Route::post('sadad', [SadadController::class, 'sadad']);
Route::post('sadad/confirm', [SadadController::class, 'confirmPayment']);