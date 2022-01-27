<?php

use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AssetController;
use App\Models\AssetType;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){
    return view('welcome');
})->name('welcome');

Route::group(['middleware'=>'auth'],function(){
   
    Route::get('/dashboard',[HomeController::class,'dashboard'])->name('dashboard');
    
    //Asset Type controllers and routes
        //add assetType routes
        //Route::get('/Admin/AssetType/Add',[AssetTypeController::class,'add']);
        Route::view('admin.AddAssetType','admin.AddAssetType')->name('AddAssetType');
        Route::post('AddAssetTypePost',[AssetTypeController::class,'AddAssetTypePost'])->name('AddAssetTypePost');
        //display asset types
        Route::get('admin.ShowAssetType',[AssetTypeController::class,'ShowAssetType'])->name('ShowAssetType');
        //update asset types
        Route::get('UpdateAssetType/{id}',[AssetTypeController::class,'UpdateAssetType'])->name('UpdateAssetType');
        Route::post('UpdateAssetTypePost',[AssetTypeController::class,'UpdateAssetTypePost'])->name('UpdateAssetTypePost');
        //delete asset type
        Route::delete('/deleteAssetType', [AssetTypeController::class, 'deleteAssetType'])->name('deleteAssetType');
        


    //Asset controller and routes
        //Add assets
        Route::get('admin.AddAsset',[AssetController::class,'AddAsset'])->name('AddAsset');
        Route::post('AddAssetPost',[AssetController::class,'AddAssetPost'])->name('AddAssetPost');
        //show assets
        Route::get('admin.ShowAssets',[AssetController::class,'ShowAsset'])->name('ShowAsset');
        //show asset Images
        Route::get('ShowAssetImages/{id}',[AssetController::class,'ShowAssetImages'])->name('ShowAssetImages');
        //Delete assets
        Route::delete('/deleteAsset', [AssetController::class, 'deleteAsset'])->name('deleteAsset');
        //update asset view
        Route::get('UpdateAsset/{id}',[AssetController::class,'UpdateAsset'])->name('UpdateAsset');
        Route::post('UpdateAssetPost',[AssetController::class,'UpdateAssetPost'])->name('UpdateAssetPost');
        //Delete asset image
        Route::delete('/deleteAssetImage', [AssetController::class, 'deleteAssetImage'])->name('deleteAssetImage');
       
        

    
    
    
    
});


require __DIR__.'/auth.php';
