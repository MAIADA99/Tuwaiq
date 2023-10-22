<?php

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WhyUsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\SendingEmailController;
use App\Http\Controllers\ExternalFacadesController;
use App\Http\Controllers\ManufacturingImageController;
use App\Http\Controllers\ManufacturingVedioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(HomeController::class)->group(function () {
    //user
    Route::get('tawique/home', 'home')->name('getallhome');
    Route::get('tawique/home/aboutus', 'homeaboutus')->name('getallhome');
});

Route::controller(AdminController::class)->group(function () {
    Route::Post('admin/login', 'login')->name('login');
    Route::get('admin/logout', 'logout')->name('logout')->middleware('jwt.verify');
});

//!static
Route::middleware('jwt.verify')->controller(ServiceController::class)->group(function () {
    Route::get('service/showall', 'index')->name('ShowServices')->withoutMiddleware('jwt.verify');
    Route::post('service/store', 'store')->name('StoreService');
    Route::post('service/show', 'show')->name('ShoworEditService');
    Route::post('service/update', 'update')->name('UpdateService');
    Route::delete('service/delete', 'destroy')->name('DestroyService');
});

//!static
Route::controller(ContactUsController::class)->group(function () {
    Route::get('contact/edit', 'show')->name('editdetails');
    Route::post('contact/update', 'update')->name('updatedetails')->middleware('jwt.verify');
});

Route::controller(SendingEmailController::class)->group(function () {
    Route::post('test/new/sendemail', 'SendingEmail')->name('SendingEmail');
});

Route::middleware('jwt.verify')->controller(ClientController::class)->group(function () {
    Route::get('cliects/showall', 'index')->name('showclients')->withoutMiddleware('jwt.verify');
    Route::post('clients/store', 'store')->name('storeclients');
    Route::delete('clients/destroy/{idclient}', 'destroy')->name('destroyclient');
});

//
Route::middleware('jwt.verify')->controller(ExternalFacadesController::class)->group(function () {
    Route::get('facade/showall', 'index')->name('showfacades')->withoutMiddleware('jwt.verify');
    Route::post('facade/store', 'store')->name('storefacade');
    Route::delete('facade/destroy', 'destroy')->name('destroyfacade');
});


//!static
Route::middleware('jwt.verify')->controller(AboutUsController::class)->group(function () {
    Route::post('aboutus/edit', 'show')->name('editaboutus');
    Route::post('aboutus/update', 'update')->name('updateaboutus');
});

Route::middleware('jwt.verify')->controller(WhyUsController::class)->group(function () {
    Route::get('whyus/showall', 'index')->name('Showwhyus');
    Route::post('whyus/store', 'store')->name('Storewhyus');
    Route::post('whyus/show', 'edit')->name('ShoworEditwhyus');
    Route::post('whyus/update', 'update')->name('Updatewhyus');
    Route::delete('whyus/delete', 'destroy')->name('Destroywhyus');
});
//middleware('jwt.verify')->
Route::controller(TeamController::class)->group(function () {
    Route::get('team/showall', 'index')->name('Showteam');
    Route::post('team/store', 'store')->name('Storeteam');
    Route::post('team/show', 'edit')->name('ShoworEditteam');
    Route::post('team/update', 'update')->name('Updateteam');
    Route::delete('team/delete', 'destroy')->name('Destroyteam');
});





Route::controller(BlogController::class)->group(function () {
    Route::get('blog/showall', 'index')->name('showaboutus');
    Route::post('blog/store', 'store')->name('storeblog')->middleware('jwt.verify');
    //show for user +for admin to show  blog+it's comment
    Route::post('blog/show', 'show')->name('showuserblog');
    Route::post('blog/update', 'update')->name('updateblog')->middleware('jwt.verify');
    Route::delete('blog/destroy', 'destroy')->name('destroyblog')->middleware('jwt.verify');
});

Route::controller(CommentController::class)->group(function () {
    //u
    Route::post('comment/store', 'store')->name('storecomment');
    //admin
    Route::delete('comment/destroy', 'destroy')->name('destroycomment')->middleware('jwt.verify');
});
//
Route::middleware('jwt.verify')->controller(ManufacturingImageController::class)->group(function () {
    Route::get('image/showall', 'index')->name('showimages')->withoutMiddleware('jwt.verify');
    Route::post('image/store', 'store')->name('storeimage');
    Route::delete('image/destroy', 'destroy')->name('destroyimage');
});


//
Route::middleware('jwt.verify')->controller(ManufacturingVedioController::class)->group(function () {
   //! Route::get('vedio/home', 'home')->name('showhome')->withoutMiddleware('jwt.verify');
    //u+a
    Route::get('vedio/showall', 'index')->name('showvedios')->withoutMiddleware('jwt.verify');
    Route::post('vedio/store', 'store')->name('storevedio');
    Route::delete('vedio/destroy', 'destroy')->name('destroyvedio');
});

//middleware('jwt.verify')->
Route::controller(SliderController::class)->group(function () {

    Route::get('Slider/showall', 'index')->name('ShowSlider')->withoutMiddleware('jwt.verify');
    Route::post('Slider/store', 'store')->name('StoreSlider');
    Route::post('Slider/show', 'edit')->name('ShoworEditSlider');
    Route::post('Slider/update', 'update')->name('UpdateSlider');
    Route::delete('Slider/delete', 'destroy')->name('DestroySlider');
});
