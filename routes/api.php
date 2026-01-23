
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RraMiddlewareController;

Route::prefix('rra')->group(function () {
    Route::post('/init', [RraMiddlewareController::class, 'init']);
    Route::post('/items', [RraMiddlewareController::class, 'saveItems']);
    Route::post('/sales', [RraMiddlewareController::class, 'saveSales']);
    Route::post('/invoice', [RraMiddlewareController::class, 'signInvoice']);
    Route::get('/status/{docNo}', [RraMiddlewareController::class, 'status']);
    Route::post('/saveStockMaster', [RraMiddlewareController::class, 'saveStockMaster']);
    Route::get('/selectItems', [RraMiddlewareController::class, 'selectItems']);
    Route::get('/stock/selectStockItems', [RraMiddlewareController::class, 'selectStockItems']);
    Route::get('/imports/selectImportItems', [RraMiddlewareController::class, 'selectImportItems']);

    Route::get('/code/selectCodes', [RraMiddlewareController::class, 'selectCodes']);
    Route::get('/itemClass/selectItemsClass', [RraMiddlewareController::class, 'selectItemsClass']);
    Route::get('/customers/selectCustomer', [RraMiddlewareController::class, 'selectCustomer']);
    Route::get('/branches/selectBranches', [RraMiddlewareController::class, 'selectBranches']);
    Route::get('/notices/selectNotices', [RraMiddlewareController::class, 'selectNotices']);
});
