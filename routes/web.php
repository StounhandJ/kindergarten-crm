<?php

use App\Http\Controllers\Action\BranchActionController;
use App\Http\Controllers\Action\ChildrenActionController;
use App\Http\Controllers\Action\CostActionController;
use App\Http\Controllers\Action\GeneralChildActionController;
use App\Http\Controllers\Action\GeneralStaffActionController;
use App\Http\Controllers\Action\GroupActionController;
use App\Http\Controllers\Action\InstitutionActionController;
use App\Http\Controllers\Action\JournalChildrenActionController;
use App\Http\Controllers\Action\JournalStaffActionController;
use App\Http\Controllers\Action\PositionActionController;
use App\Http\Controllers\Action\StaffActionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix("action")->name("action.")->group(function () {

    Route::apiResource("branch", BranchActionController::class)->only("index");

    Route::apiResource("position", PositionActionController::class)->only("index");

    Route::apiResource("institution", InstitutionActionController::class)->only("index");

    Route::apiResource("group", GroupActionController::class);

    Route::get("group-array", [GroupActionController::class, "indexArray"]);

    Route::apiResource("children", ChildrenActionController::class);

    Route::apiResource("staff", StaffActionController::class);

    Route::apiResource("cost", CostActionController::class)
        ->only("index", "show", "store");

    Route::apiResource("journal-children", JournalChildrenActionController::class)
        ->only("index", "update");

    Route::apiResource("journal-staff", JournalStaffActionController::class)
        ->only("index", "update");

    Route::apiResource("general-journal-child", GeneralChildActionController::class)
        ->only("index", "update");

    Route::apiResource("general-journal-staff", GeneralStaffActionController::class)
        ->only("index", "update");
});

Route::get('/', function () {
    return view("pages-blank");
});

Route::get('/groups', function () {
    return view("groups");
})->name("groups");

Route::get('/children', function () {
    return view("children");
})->name("children");

Route::get('/staffs', function () {
    return view("staffs");
})->name("staffs");

Route::get('/card/children', function () {
    return view("pages-blank");
})->name("card.children");

Route::get('/card/staffs', function () {
    return view("pages-blank");
})->name("card.staffs");

Route::get('/journal/children', function () {
    return view("journal-children");
})->name("journal.children");

Route::get('/journal/staffs', function () {
    return view("journal-staff");
})->name("journal.staffs");
