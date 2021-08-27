<?php

use App\Http\Controllers\BranchActionController;
use App\Http\Controllers\GroupActionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/test', function () {
    return response()->json([
   "records" => [
         [
            "id" => 1,
            "name" => "П-12",
            "children_age" => 6,
            "fillName" => "Bulgaria",
             "fillId" => 2,
             "IsTest" => True,
         ],
       [
            "id" => 2,
            "name" => "П-12",
            "children_age" => 5,
            "fillName" => "Junkl",
             "fillId" => 3,
             "IsTest" => False,
         ],
      ],
   "total" => 2
]);
});

Route::get('/test2', function () {
    return response()->json([
        ["name"=>"Bulgaria", "id"=>2],
        ["name"=>"Junkl", "id"=>3],
        ["name"=>"ghk", "id"=>4]
    ]);
});

Route::get("/branch", [BranchActionController::class,"indexArray"]);

Route::apiResource("group",GroupActionController::class);

Route::get('/', function () {
    return view("pages-blank");
});

Route::get('/groups', function () {
    return view("groups");
})->name("groups");

Route::get('/children', function () {
    return view("pages-blank");
})->name("children");

Route::get('/staffs', function () {
    return view("pages-blank");
})->name("staffs");

Route::get('/card/children', function () {
    return view("pages-blank");
})->name("card.children");

Route::get('/card/staffs', function () {
    return view("pages-blank");
})->name("card.staffs");

Route::get('/journal/children', function () {
    return view("pages-blank");
})->name("journal.children");

Route::get('/journal/staffs', function () {
    return view("pages-blank");
})->name("journal.staffs");
