<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Models\User;
use App\Models\General;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| ステートフルなurlはここに書く
| postならデフォルトでcsrfが有効
|
*/

Auth::routes();

// 共通
Route::prefix('/utility')->group(function () {
    Route::post('/empty_table_columns', [Controllers\UtilityController::class, 'getEmptyTableColumns']);
    Route::get('/general_code', function () {
        return App\Libs\Consts::getConstants();
    });
    Route::get('/general_code_value', function () {
        return App\Libs\Consts::getFlipConstants();
    });
});


// ↓ 公開画面用
Route::get('/', function () {
    return view('content.agree');
});
// 同意画面
Route::get('/agree', [Controllers\Content\AgreeController::class, 'index'])->name('agree');
// 申込画面
Route::prefix('reception')->group(function () {
    Route::post('/', [Controllers\Content\ReceptionController::class, 'index'])->name('reception')->middleware('agree');
    Route::get('/kyogis', [Controllers\Content\ReceptionController::class, 'getKyogis']);
    Route::get('/kyogis_nm', [Controllers\Content\ReceptionController::class, 'getKyogiNms']);
    Route::post('/validation', [Controllers\Content\ReceptionController::class, 'validation']);
    Route::post('/init_data', [Controllers\Content\ReceptionController::class, 'getInputData']);
});
// 確認画面
Route::prefix('confirmation')->group(function () {
    Route::get('/', [Controllers\Content\ConfirmationController::class, 'index'])->name('confirmation');
    // 管理ユーザーのみ申込み情報を表示させる。
    Route::get('/{reception_id}', [Controllers\Content\ConfirmationController::class, 'adminIndex']);
    Route::post('/create', [Controllers\Content\ConfirmationController::class, 'create']);
});
// 完了画面
Route::get('/complete', [Controllers\Content\CompleteController::class, 'index'])->name('complete');
// ↑ 公開画面用



// ↓ 管理画面用
Route::get('/admin', [Controllers\Admin\AdminController::class, 'index'])->name('admin');

// 認証ユーザー情報取得
Route::middleware('auth:web')->get('auth/user', function () {
    return Auth::user();
});

// ログアウト
Route::middleware('auth:web')->get('api/logout', function () {
    return Auth::logout();
});

// 管理画面spa用
Route::get('/admin/{any}', function () {
    return view('admin');
})->where('any', '.*');

// 汎用マスタ
Route::group(['prefix' => 'general', 'middleware' => 'auth'], function () {
    Route::post('/index', [Controllers\Admin\Master\GeneralController::class, 'index']);
    Route::post('/store', [Controllers\Admin\Master\GeneralController::class, 'store']); 
    Route::delete('/{id}', [Controllers\Admin\Master\GeneralController::class, 'destroy']); 
    Route::put('/{id}', [Controllers\Admin\Master\GeneralController::class, 'update']); 
    Route::post('/set_conds', [Controllers\Admin\Master\GeneralController::class, 'setConds']);
    Route::post('/get_conds', [Controllers\Admin\Master\GeneralController::class, 'getConds']);
    Route::post('/export_excel', [Controllers\Admin\Master\GeneralController::class, 'exportExcel']);
});

// 競技マスタ
Route::group(['prefix' => 'kyogi', 'middleware' => 'auth'], function () {
    Route::post('/index', [Controllers\Admin\Master\KyogiController::class, 'index']);
    Route::post('/store', [Controllers\Admin\Master\KyogiController::class, 'store']); 
    Route::delete('/{id}', [Controllers\Admin\Master\KyogiController::class, 'destroy']); 
    Route::put('/{id}', [Controllers\Admin\Master\KyogiController::class, 'update']); 
    Route::post('/set_conds', [Controllers\Admin\Master\KyogiController::class, 'setConds']);
    Route::post('/get_conds', [Controllers\Admin\Master\KyogiController::class, 'getConds']);
    Route::post('/export_excel', [Controllers\Admin\Master\KyogiController::class, 'exportExcel']);
});

// 競技予定
Route::group(['prefix' => 'kyogi_plan', 'middleware' => 'auth'], function () {
    Route::post('/index', [Controllers\Admin\KyogiPlanController::class, 'index']);
    Route::post('/store', [Controllers\Admin\KyogiPlanController::class, 'store']); 
    Route::delete('/{id}', [Controllers\Admin\KyogiPlanController::class, 'destroy']); 
    Route::post('/set_conds', [Controllers\Admin\KyogiPlanController::class, 'setConds']);
    Route::post('/get_conds', [Controllers\Admin\KyogiPlanController::class, 'getConds']);
});

// 申込状況
Route::group(['prefix' => 'reception_status', 'middleware' => 'auth'], function () {
    Route::post('/index', [Controllers\Admin\ReceptionStatusController::class, 'index']);
    Route::delete('/{id}', [Controllers\Admin\ReceptionStatusController::class, 'destroy']); 
    Route::post('/set_conds', [Controllers\Admin\ReceptionStatusController::class, 'setConds']);
    Route::post('/get_conds', [Controllers\Admin\ReceptionStatusController::class, 'getConds']);
});
// ↑ 管理画面用