<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';*/

Route::middleware(['web'])->group(function(){
    Route::get('/', function(){
        return view('welcome');
    });

    Route::controller(UserController::class)->group(function(){
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'signin')->name('user.login');
        Route::get('/logout', 'logout')->name('logout')->middleware('auth');
    });
});

Route::middleware(['web', 'auth'])->group(function(){
    Route::get('/backend/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/user/branch/update', [UserController::class, 'updateBranch'])->name('user.branch.update');
});

Route::middleware(['web', 'auth', 'branch'])->group(function(){

    Route::prefix('/ajax')->controller(AjaxController::class)->group(function(){          
        Route::post('/appointment/time', 'getAppointmentTime')->name('ajax.appointment.time');
    });

    Route::prefix('/backend/pdf')->controller(PdfController::class)->group(function(){          
        Route::get('/opt/{id}', 'opt')->name('pdf.opt');
        Route::get('/prescription/{id}', 'prescription')->name('pdf.prescription');
        Route::get('/consultation/receipt/{id}', 'cReceipt')->name('pdf.consultation.receipt');
        Route::get('/mrecord/{id}', 'medicalRecord')->name('pdf.mrecord');
    });

    Route::prefix('/backend/user')->controller(UserController::class)->group(function(){          
        Route::get('/', 'index')->name('users');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/save', 'store')->name('user.save');
        Route::get('/edit/{id}', 'edit')->name('user.edit');
        Route::post('/edit/{id}', 'update')->name('user.update');
        Route::get('/delete/{id}', 'destroy')->name('user.delete');
    });

    Route::prefix('/backend/role')->controller(RoleController::class)->group(function(){          
        Route::get('/', 'index')->name('roles');
        Route::get('/create', 'create')->name('role.create');
        Route::post('/save', 'store')->name('role.save');
        Route::get('/edit/{id}', 'edit')->name('role.edit');
        Route::post('/edit/{id}', 'update')->name('role.update');
        Route::get('/delete/{id}', 'destroy')->name('role.delete');
    });

    Route::prefix('/backend/branch')->controller(BranchController::class)->group(function(){          
        Route::get('/', 'index')->name('branches');
        Route::get('/create', 'create')->name('branch.create');
        Route::post('/save', 'store')->name('branch.save');
        Route::get('/edit/{id}', 'edit')->name('branch.edit');
        Route::post('/edit/{id}', 'update')->name('branch.update');
        Route::get('/delete/{id}', 'destroy')->name('branch.delete');
    });

    Route::prefix('/backend/doctor')->controller(DoctorController::class)->group(function(){          
        Route::get('/', 'index')->name('doctors');
        Route::get('/create', 'create')->name('doctor.create');
        Route::post('/save', 'store')->name('doctor.save');
        Route::get('/edit/{id}', 'edit')->name('doctor.edit');
        Route::post('/edit/{id}', 'update')->name('doctor.update');
        Route::get('/delete/{id}', 'destroy')->name('doctor.delete');
    });

    Route::prefix('/backend/patient')->controller(PatientController::class)->group(function(){          
        Route::get('/', 'index')->name('patients');
        Route::get('/create/{type}/{type_id}', 'create')->name('patient.create');
        Route::post('/save', 'store')->name('patient.save');
        Route::get('/edit/{id}', 'edit')->name('patient.edit');
        Route::post('/edit/{id}', 'update')->name('patient.update');
        Route::get('/delete/{id}', 'destroy')->name('patient.delete');
    });

    Route::prefix('/backend/consultation')->controller(ConsultationController::class)->group(function(){          
        Route::get('/', 'index')->name('consultations');
        Route::get('/create/{pid}', 'create')->name('consultation.create');
        Route::post('/save', 'store')->name('consultation.save');
        Route::get('/edit/{id}', 'edit')->name('consultation.edit');
        Route::post('/edit/{id}', 'update')->name('consultation.update');
        Route::get('/delete/{id}', 'destroy')->name('consultation.delete');
    });

    Route::prefix('/backend/medical-record')->controller(MedicalRecordController::class)->group(function(){
        Route::get('/', 'index')->name('mrecords');          
        Route::get('/create/{id}', 'create')->name('mrecord.create');
        Route::post('/save', 'store')->name('mrecord.save');
        Route::get('/edit/{id}', 'edit')->name('mrecord.edit');
        Route::post('/edit/{id}', 'update')->name('mrecord.update');
        Route::get('/delete/{id}', 'destroy')->name('mrecord.delete');
    });

    Route::prefix('/backend/appointment')->controller(AppointmentController::class)->group(function(){
        Route::get('/', 'index')->name('appointments');          
        Route::get('/create', 'create')->name('appointment.create');
        Route::post('/save', 'store')->name('appointment.save');
        Route::get('/edit/{id}', 'edit')->name('appointment.edit');
        Route::post('/edit/{id}', 'update')->name('appointment.update');
        Route::get('/delete/{id}', 'destroy')->name('appointment.delete');
    });

    Route::prefix('/backend/camp')->controller(CampController::class)->group(function(){
        Route::get('/', 'index')->name('camps');          
        Route::get('/create', 'create')->name('camp.create');
        Route::post('/save', 'store')->name('camp.save');
        Route::get('/edit/{id}', 'edit')->name('camp.edit');
        Route::post('/edit/{id}', 'update')->name('camp.update');
        Route::get('/delete/{id}', 'destroy')->name('camp.delete');
    });

});
