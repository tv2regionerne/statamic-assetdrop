<?php

use Tv2regionerne\StatamicAssetdrop\Http\Controllers\CP\AssetdropController;

Route::middleware('statamic.cp.authenticated')->name('assetdrop.')->group(function () {
    Route::get('assetdrop', [AssetdropController::class, 'index'])->name('index');
    Route::post('assetdrop', [AssetdropController::class, 'queue'])->name('queue');
});
