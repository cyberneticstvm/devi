<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\CampPatientController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PharmacyOrderController;
use App\Http\Controllers\ProductFrameController;
use App\Http\Controllers\ProductLensController;
use App\Http\Controllers\ProductPharmacyController;
use App\Http\Controllers\ProductServiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoreOrderController;
use App\Http\Controllers\SupplierController;
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

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('backend.login');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'signin')->name('user.login');
        Route::get('/logout', 'logout')->name('logout')->middleware('auth');
    });
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/backend/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/user/branch/update', [UserController::class, 'updateBranch'])->name('user.branch.update');
});

Route::middleware(['web', 'auth', 'branch'])->group(function () {

    Route::prefix('/ajax')->controller(AjaxController::class)->group(function () {
        Route::post('/appointment/time', 'getAppointmentTime')->name('ajax.appointment.time');
        Route::get('/product/{category}', 'getProductsByCategory')->name('ajax.product.get');
        Route::get('/productprice/{product}', 'getProductPrice')->name('ajax.productprice.get');
    });

    Route::prefix('/backend/export')->controller(ImportExportController::class)->group(function () {
        Route::get('/appointments/today', 'exportTodayAppointments')->name('export.today.appointments');
        Route::get('/camp/patient/list/{id}', 'exportCampPatientList')->name('export.camp.patient');
        Route::get('/product/pharmacy', 'exportProductPharmacy')->name('export.product.pharmacy');
        Route::get('/product/lens', 'exportProductLens')->name('export.product.lens');
        Route::get('/product/frame', 'exportProductFrame')->name('export.product.frame');
    });
    Route::prefix('/backend/pdf')->controller(PdfController::class)->group(function () {
        Route::get('/opt/{id}', 'opt')->name('pdf.opt');
        Route::get('/prescription/{id}', 'prescription')->name('pdf.prescription');
        Route::get('/consultation/receipt/{id}', 'cReceipt')->name('pdf.consultation.receipt');
        Route::get('/mrecord/{id}', 'medicalRecord')->name('pdf.mrecord');
        Route::get('/appointment', 'exportTodaysAppointment')->name('pdf.appointment');
        Route::get('/camp/patient/list/{id}', 'exportCampPatientList')->name('pdf.camp.patient');
        Route::get('/camp/patient/mrecord/{id}', 'exportCampPatientMedicalRecord')->name('pdf.camp.patient.mrecord');
        Route::get('/product/pharmacy', 'exportProductPharmacy')->name('pdf.product.pharmacy');
        Route::get('/product/lens', 'exportProductLens')->name('pdf.product.lens');
        Route::get('/product/frame', 'exportProductFrame')->name('pdf.product.frame');
        Route::get('/order/receipt/{id}', 'exportOrderReceipt')->name('pdf.order.receipt');
    });

    Route::prefix('/backend/user')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('users');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/save', 'store')->name('user.save');
        Route::get('/edit/{id}', 'edit')->name('user.edit');
        Route::post('/edit/{id}', 'update')->name('user.update');
        Route::get('/delete/{id}', 'destroy')->name('user.delete');
    });

    Route::prefix('/backend/role')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('roles');
        Route::get('/create', 'create')->name('role.create');
        Route::post('/save', 'store')->name('role.save');
        Route::get('/edit/{id}', 'edit')->name('role.edit');
        Route::post('/edit/{id}', 'update')->name('role.update');
        Route::get('/delete/{id}', 'destroy')->name('role.delete');
    });

    Route::prefix('/backend/branch')->controller(BranchController::class)->group(function () {
        Route::get('/', 'index')->name('branches');
        Route::get('/create', 'create')->name('branch.create');
        Route::post('/save', 'store')->name('branch.save');
        Route::get('/edit/{id}', 'edit')->name('branch.edit');
        Route::post('/edit/{id}', 'update')->name('branch.update');
        Route::get('/delete/{id}', 'destroy')->name('branch.delete');
    });

    Route::prefix('/backend/doctor')->controller(DoctorController::class)->group(function () {
        Route::get('/', 'index')->name('doctors');
        Route::get('/create', 'create')->name('doctor.create');
        Route::post('/save', 'store')->name('doctor.save');
        Route::get('/edit/{id}', 'edit')->name('doctor.edit');
        Route::post('/edit/{id}', 'update')->name('doctor.update');
        Route::get('/delete/{id}', 'destroy')->name('doctor.delete');
    });

    Route::prefix('/backend/patient')->controller(PatientController::class)->group(function () {
        Route::get('/', 'index')->name('patients');
        Route::get('/create/{type}/{type_id}', 'create')->name('patient.create');
        Route::post('/save', 'store')->name('patient.save');
        Route::get('/edit/{id}', 'edit')->name('patient.edit');
        Route::post('/edit/{id}', 'update')->name('patient.update');
        Route::get('/delete/{id}', 'destroy')->name('patient.delete');
    });

    Route::prefix('/backend/consultation')->controller(ConsultationController::class)->group(function () {
        Route::get('/', 'index')->name('consultations');
        Route::get('/create/{pid}', 'create')->name('consultation.create');
        Route::post('/save', 'store')->name('consultation.save');
        Route::get('/edit/{id}', 'edit')->name('consultation.edit');
        Route::post('/edit/{id}', 'update')->name('consultation.update');
        Route::get('/delete/{id}', 'destroy')->name('consultation.delete');
    });

    Route::prefix('/backend/medical-record')->controller(MedicalRecordController::class)->group(function () {
        Route::get('/', 'index')->name('mrecords');
        Route::get('/create/{id}', 'create')->name('mrecord.create');
        Route::post('/save', 'store')->name('mrecord.save');
        Route::get('/edit/{id}', 'edit')->name('mrecord.edit');
        Route::post('/edit/{id}', 'update')->name('mrecord.update');
        Route::get('/delete/{id}', 'destroy')->name('mrecord.delete');
    });

    Route::prefix('/backend/appointment')->controller(AppointmentController::class)->group(function () {
        Route::get('/', 'index')->name('appointments');
        Route::get('/list', 'show')->name('appointment.list');
        Route::get('/create', 'create')->name('appointment.create');
        Route::post('/save', 'store')->name('appointment.save');
        Route::get('/edit/{id}', 'edit')->name('appointment.edit');
        Route::post('/edit/{id}', 'update')->name('appointment.update');
        Route::get('/delete/{id}', 'destroy')->name('appointment.delete');
    });

    Route::prefix('/backend/camps')->controller(CampController::class)->group(function () {
        Route::get('/', 'index')->name('camps');
        Route::get('/create', 'create')->name('camp.create');
        Route::post('/save', 'store')->name('camp.save');
        Route::get('/edit/{id}', 'edit')->name('camp.edit');
        Route::post('/edit/{id}', 'update')->name('camp.update');
        Route::get('/delete/{id}', 'destroy')->name('camp.delete');
    });

    Route::prefix('/backend/camp/patient')->controller(CampPatientController::class)->group(function () {
        Route::get('/list/{id}', 'index')->name('camp.patients');
        Route::get('/create/{id}', 'create')->name('camp.patient.create');
        Route::post('/save', 'store')->name('camp.patient.save');
        Route::get('/edit/{id}', 'edit')->name('camp.patient.edit');
        Route::post('/edit/{id}', 'update')->name('camp.patient.update');
        Route::get('/delete/{id}', 'destroy')->name('camp.patient.delete');
    });

    Route::prefix('/backend/document')->controller(DocumentController::class)->group(function () {
        Route::get('/', 'index')->name('documents');
        Route::post('/', 'fetch')->name('document.fetch');
        Route::get('/proceed', '')->name('document.proceed');
        Route::get('/create/{id}', 'show')->name('document.create');
        Route::post('/create', 'store')->name('document.save');
        Route::get('/delete/{id}', 'destroy')->name('document.delete');
    });

    Route::prefix('/backend/supplier')->controller(SupplierController::class)->group(function () {
        Route::get('/', 'index')->name('suppliers');
        Route::get('/create', 'create')->name('supplier.create');
        Route::post('/create', 'store')->name('supplier.save');
        Route::get('/edit/{id}', 'edit')->name('supplier.edit');
        Route::post('/edit/{id}', 'update')->name('supplier.update');
        Route::get('/delete/{id}', 'destroy')->name('supplier.delete');
    });

    Route::prefix('/backend/manufacturer')->controller(ManufacturerController::class)->group(function () {
        Route::get('/', 'index')->name('manufacturers');
        Route::get('/create', 'create')->name('manufacturer.create');
        Route::post('/create', 'store')->name('manufacturer.save');
        Route::get('/edit/{id}', 'edit')->name('manufacturer.edit');
        Route::post('/edit/{id}', 'update')->name('manufacturer.update');
        Route::get('/delete/{id}', 'destroy')->name('manufacturer.delete');
    });

    Route::prefix('/backend/product/pharmacy')->controller(ProductPharmacyController::class)->group(function () {
        Route::get('/', 'index')->name('product.pharmacy');
        Route::get('/create', 'create')->name('product.pharmacy.create');
        Route::post('/create', 'store')->name('product.pharmacy.save');
        Route::get('/edit/{id}', 'edit')->name('product.pharmacy.edit');
        Route::post('/edit/{id}', 'update')->name('product.pharmacy.update');
        Route::get('/delete/{id}', 'destroy')->name('product.pharmacy.delete');
    });

    Route::prefix('/backend/product/lens')->controller(ProductLensController::class)->group(function () {
        Route::get('/', 'index')->name('product.lens');
        Route::get('/create', 'create')->name('product.lens.create');
        Route::post('/create', 'store')->name('product.lens.save');
        Route::get('/edit/{id}', 'edit')->name('product.lens.edit');
        Route::post('/edit/{id}', 'update')->name('product.lens.update');
        Route::get('/delete/{id}', 'destroy')->name('product.lens.delete');
    });

    Route::prefix('/backend/product/frame')->controller(ProductFrameController::class)->group(function () {
        Route::get('/', 'index')->name('product.frame');
        Route::get('/create', 'create')->name('product.frame.create');
        Route::post('/create', 'store')->name('product.frame.save');
        Route::get('/edit/{id}', 'edit')->name('product.frame.edit');
        Route::post('/edit/{id}', 'update')->name('product.frame.update');
        Route::get('/delete/{id}', 'destroy')->name('product.frame.delete');
    });

    Route::prefix('/backend/product/service')->controller(ProductServiceController::class)->group(function () {
        Route::get('/', 'index')->name('product.service');
        Route::get('/create', 'create')->name('product.service.create');
        Route::post('/create', 'store')->name('product.service.save');
        Route::get('/edit/{id}', 'edit')->name('product.service.edit');
        Route::post('/edit/{id}', 'update')->name('product.service.update');
        Route::get('/delete/{id}', 'destroy')->name('product.service.delete');
    });

    Route::prefix('/backend/store/order')->controller(StoreOrderController::class)->group(function () {
        Route::get('/', 'index')->name('store.order');
        Route::post('/', 'fetch')->name('store.order.fetch');
        Route::get('/proceed', '')->name('store.order.proceed');
        Route::get('/create/{id}', 'create')->name('store.order.create');
        Route::post('/create', 'store')->name('store.order.save');
        Route::get('/edit/{id}', 'edit')->name('store.order.edit');
        Route::post('/edit/{id}', 'update')->name('store.order.update');
        Route::get('/delete/{id}', 'destroy')->name('store.order.delete');
    });

    Route::prefix('/backend/pharmacy/order')->controller(PharmacyOrderController::class)->group(function () {
        Route::get('/', 'index')->name('pharmacy.order');
        Route::get('/create', 'create')->name('pharmacy.order.create');
        Route::post('/create', 'store')->name('pharmacy.order.save');
        Route::get('/edit/{id}', 'edit')->name('pharmacy.order.edit');
        Route::post('/edit/{id}', 'update')->name('pharmacy.order.update');
        Route::get('/delete/{id}', 'destroy')->name('pharmacy.order.delete');
    });

    Route::prefix('/backend/payment')->controller(PaymentController::class)->group(function () {
        Route::get('/', 'index')->name('payments');
        Route::get('/create', 'create')->name('payment.create');
        Route::post('/create', 'store')->name('payment.save');
        Route::get('/edit/{id}', 'edit')->name('payment.edit');
        Route::post('/edit/{id}', 'update')->name('payment.update');
        Route::get('/delete/{id}', 'destroy')->name('payment.delete');
    });
});
