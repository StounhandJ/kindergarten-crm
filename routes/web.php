<?php

use App\Http\Controllers\Action\AuthActionController;
use App\Http\Controllers\Action\BranchActionController;
use App\Http\Controllers\Action\CategoryCostController;
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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Carbon;
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

Route::prefix("action")->middleware("position")->name("action.")->group(function () {
    Route::get("month", fn() => Carbon::now()->format("Y-m"));

    Route::get("branch-array", [BranchActionController::class, "indexArray"]);

    Route::apiResource("branches", BranchActionController::class);

    Route::apiResource("position", PositionActionController::class)->only("index");

    Route::apiResource("institution", InstitutionActionController::class)->only("index");

    Route::apiResource("group", GroupActionController::class);

    Route::get("group-array", [GroupActionController::class, "indexArray"]);

    Route::apiResource("children", ChildrenActionController::class);

    Route::apiResource("staff", StaffActionController::class);

    Route::apiResource("cost", CostActionController::class)
        ->only("index", "show", "store");

    Route::get("cost-cash", [CostActionController::class, "cash"]);

    Route::apiResource("journal-children", JournalChildrenActionController::class)
        ->only("index", "update");

    Route::apiResource("journal-staffs", JournalStaffActionController::class)
        ->only("index", "update");

    Route::apiResource("general-journal-child", GeneralChildActionController::class)
        ->only("index", "update");

    Route::apiResource("general-journal-staff", GeneralStaffActionController::class)
        ->only("index", "update");

    Route::apiResource("category-cost", CategoryCostController::class)->except("destroy", "show");

    Route::get("category-cost-array", [CategoryCostController::class, "indexArray"]);

    Route::post("notification", [GeneralChildActionController::class, "notification"]);
});

Route::get('/', function () {
    return view("pages-blank");
})->name("index")->middleware("position");

Route::get('/branches', function () {
    return view("branches");
})->name("branches")->middleware("position:director");

Route::get('/groups', function () {
    return view("groups");
})->name("groups")->middleware("position:director");

Route::get('/children', function () {
    return view("children");
})->name("children")->middleware("position:director,senior_tutor");

Route::get('/staffs', function () {
    return view("staffs");
})->name("staffs")->middleware("position:director,senior_tutor");

Route::get('/card/children', function () {
    return view("card-children");
})->name("card.children")->middleware("position:director,senior_tutor");

Route::get('/card/staffs', function () {
    return view("card-staffs");
})->name("card.staffs")->middleware("position:director,senior_tutor");

Route::get('/journal/children', function () {
    return view("journal-children");
})->name("journal.children")->middleware("position:senior_tutor,tutor,director");

Route::get('/journal/staffs', function () {
    return view("journal-staffs");
})->name("journal.staffs")->middleware("position:director,senior_tutor,tutor");

Route::get('/category-cost', function () {
    return view("category-cost");
})->name("category-cost")->middleware("position:director,senior_tutor");

Route::get('/income', function () {
    return view("income");
})->name("income")->middleware("position:director,senior_tutor");

Route::get('/login', [AuthController::class, "login"])->name("login.page")->middleware("guest");
Route::post('/login', [AuthActionController::class, "login"])->name("login")->middleware("guest");
Route::get('/logout', [AuthActionController::class, "logout"])->name("logout")->middleware("auth");

Route::get("/document/child", [DocumentController::class, "storeChild"])->middleware("position:director,senior_tutor")->name("document.child");
Route::get("/document/vedomosty", [DocumentController::class, "storeVedomosty"])->middleware("position:director,senior_tutor")->name("document.child");
//Route::post("134gs/sms/callback", [GeneralChildActionController::class, "notification"])->name("sms.callback");
