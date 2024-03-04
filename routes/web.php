<?php
use App\Http\Controllers\CertificationController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/certification', [CertificationController::class, 'index'])->name('certification.index');

Route::post('/certification/validate', [CertificationController::class, 'validateCertification'])->name('certification.validate');

