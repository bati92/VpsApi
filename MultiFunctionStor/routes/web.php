<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\User;

use App\Http\Controllers\AppController;
use App\Http\Controllers\App;

use App\Http\Controllers\AppSectionContoller;
use App\Http\Controllers\AppSection;

use App\Http\Controllers\AppOrderController;
use App\Http\Controllers\AppOrder;

use App\Http\Controllers\VipController;
use App\Http\Controllers\Vip;

use App\Http\Controllers\TurkificationController;
use App\Http\Controllers\Turkification;

use App\Http\Controllers\TransferMoneyFirmController;
use App\Http\Controllers\TransferMoneyFirm;

use App\Http\Controllers\TransferMoneyFirmOrderController;
use App\Http\Controllers\TransferMoneyFirmOrder;

use App\Http\Controllers\GameSectionController;
use App\Http\Controllers\GameOrderController;
use App\Http\Controllers\GameController;



Route::get('/', function () {
    return view('backend.dashboard');});

Route::resource( 'user', UserController::class,);
    
Route::get('users/{id}/category', [UserController::class, 'show_category']);

Route::resource(  'app' , AppController::class,);
Route::resource('app-section' , AppSectionContoller::class,);
Route::resource( 'app-order' , AppOrderController::class,);



Route::resource( 'vip' , VipController::class,);



Route::resource('turkification' , TurkificationController::class,);



Route::resource( 'transfer-money-firm' , TransferMoneyFirmController::class,);
Route::resource('transfer-money-firm-order' , TransferMoneyFirmOrderController::class,);

 


Route::resource(  'game' , GameController::class,);
Route::resource('game-section' , GameSectionController::class,);
Route::resource( 'game-order' , GameOrderController::class,);