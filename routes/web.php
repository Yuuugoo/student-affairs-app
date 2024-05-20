<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use App\Filament\StudentOfficer\Resources\AccreditationResource\Pages\CreateAccreditation;
use App\Filament\StudentOfficer\Resources\AccreditationResource\Pages\EditAccreditation;
use App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages\CreateReaccreditation;
use App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages\EditReaccreditation;
use App\Filament\StudentOfficer\Resources\RequestActOffResource\Pages\CreateRequestActOff;
use App\Filament\StudentOfficer\Resources\RequestActOffResource\Pages\EditRequestActOff;
use App\Filament\StudentOfficer\Resources\RequestActResource\Pages\CreateRequestAct;

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


Route::get('acrrednotif', function() {
    $recipient = auth()->user();
    $notificationPage = app(EditAccreditation::class);
    $notificationPage->sendNotification($recipient);
    
    dd('notification was sent successfully');
})->middleware('auth')->name('acrrednotif');

// Route::get('acrrednotif', function() {
//     $recipient = auth()->user();
//     $notificationPage = app(EditAccreditation::class);
//     $notificationPage = app(CreateAccreditation::class);
//     $notificationPage = app(CreateReaccreditation::class);
//     $notificationPage = app(EditReaccreditation::class);
//     $notificationPage = app(CreateRequestActOff::class);
//     $notificationPage = app(EditRequestActOff::class);
//     $notificationPage = app(CreateRequestAct::class);
//     $notificationPage->sendNotification($recipient);
    
//     dd('notification was sent successfully');
// })->middleware('auth')->name('acrrednotif');


