<?php

use App\Http\Controllers\BranchActionController;
use App\Http\Controllers\ChildrenActionController;
use App\Http\Controllers\CostActionController;
use App\Http\Controllers\GroupActionController;
use App\Http\Controllers\InstitutionActionController;
use App\Http\Controllers\JournalChildrenActionController;
use App\Http\Controllers\PositionActionController;
use App\Http\Controllers\StaffActionController;
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
    return view("pages-blank");
})->name("journal.staffs");
