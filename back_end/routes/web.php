<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\QrCodeController;
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
Route::get('/storage', function () { 
    Artisan::call('storage:link');
  
    return '✅ Laravel cache cleared';
});
Route::get('/login', [UserController::class,'login_page'])->name('login_page');
Route::Post('/login', [UserController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    // Add your web routes here
        Route::resource('companies', CompanyController::class);
    // Route::get('companies/create', [CompanyController::class, 'create'])->name('companies.create');
    // Route::post('companies/store', [CompanyController::class, 'store'])->name('companies.store');
    // Route::get('companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    // Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

    // Route::get('companies/data', [CompanyController::class, 'getdata'])->name('companies.data');
    Route::resource('ads_',AdsController::class);
    Route::get('AllAds',[AdsController::class , 'getAll'])->name('all_ads');
    Route::resource('cats',CategoryController::class);
    
    Route::resource('products',ProductController::class);
    Route::resource('ads_details',DetailsController::class);
    Route::get('visits_details',[DetailsController::class, 'visit_details'])->name('details.visits');

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::resource('users',UserController::class);

    Route::get('excel/upload', [ExcelController::class, 'uploadForm'])->name('excel.files');
    Route::post('excel/upload', [ExcelController::class, 'upload'])->name('excel.upload');
    Route::get('getData/{id}',[CompanyController::class , 'checkData'])->name('checkData');
    Route::get('allAds/data', [AdsController::class, 'getdata'])->name('allAds.data');
    Route::get('excel/export/{id}', [ExcelController::class, 'excelExport'])->name('excel.export');

    // Route::get('/export-details', function () {
    //           return Excel::download(new ExcelController, 'details.xlsx');
    // });

    // Route::resource('domain', DomainController::class);
    Route::get('/domain/getdata', [DomainController::class, 'getdata'])->name('domain.getdata');
    Route::get('/domain', [DomainController::class, 'index'])->name('domain.index');
    Route::post('/domain/store', [DomainController::class, 'store'])->name('domain.store');
    Route::get('/domain/create', [DomainController::class, 'create'])->name('domain.create');
    Route::get('/domain/{id}/edit', [DomainController::class, 'edit'])->name('domain.edit');
    Route::put('/domain/{id}', [DomainController::class, 'update'])->name('domain.update');
    Route::delete('/domain/{id}', [DomainController::class, 'destroy'])->name('domain.destroy');


    Route::get('/qr-code/generate/{id?}', [QrCodeController::class, 'generate'])->name('qr-code.generate');
    Route::get('/qr-code/download/{id}', [QrCodeController::class, 'download'])->name('qr-code.download');

});
Route::get('/ads/{slug}', [AdsController::class,'show']) ->name('ads.show');
Route::get('/cats/{slug}', [CategoryController::class,'show']) ->name('cats.show');
Route::post('/ads/start-now/{id}', [AdsController::class, 'startNow'])->name('ads.startNow');


Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('home');
