<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Route::post("login", [AuthController::class, "login"]);
Route::get("logout", [AuthController::class, "logout"])->name("logout");

Route::get('/home', function () {
    return view('dashboard');
})->middleware("auth");

Route::view("/projects", "projects.list.index")->name("projects.list");
Route::view("/projects/create", "projects.create.index")->name("projects.create");
Route::get("/projects/edit/{id}", [ProjectController::class, "edit"])->name("projects.edit");
Route::get("/projects/fetch", [ProjectController::class, "fetch"])->name("projects.fetch");
Route::get("/projects/fetch/all", [ProjectController::class, "fetchAll"])->name("projects.fetch.all");
Route::post("/projects/store", [ProjectController::class, "store"])->name("projects.store");
Route::post("/projects/update", [ProjectController::class, "update"])->name("projects.update");
Route::post("/projects/delete", [ProjectController::class, "delete"])->name("projects.delete");

Route::view("/directors", "directors.list.index")->name("directors.list");
Route::view("/directors/create", "directors.create.index")->name("directors.create");
Route::get("/directors/edit/{id}", [DirectorController::class, "edit"])->name("directors.edit");
Route::get("/directors/fetch", [DirectorController::class, "fetch"])->name("directors.fetch");
Route::post("/directors/store", [DirectorController::class, "store"])->name("directors.store");
Route::post("/directors/update", [DirectorController::class, "update"])->name("directors.update");
Route::post("/directors/delete", [DirectorController::class, "delete"])->name("directors.delete");

Route::view("/users", "users.list.index")->name("users.list");
Route::view("/users/create", "users.create.index")->name("users.create");
Route::get("/users/edit/{id}", [UserController::class, "edit"])->name("users.edit");
Route::get("/users/fetch", [UserController::class, "fetch"])->name("users.fetch");
Route::post("/users/store", [UserController::class, "store"])->name("users.store");
Route::post("/users/update", [UserController::class, "update"])->name("users.update");
Route::post("/users/delete", [UserController::class, "delete"])->name("users.delete");

Route::view("/home-order", "homeProjects.list.index")->name("home.index");
Route::view("/home-order/create", "homeProjects.create.index")->name("home.create");
Route::get("/home-order/fetch", [HomeController::class, "fetch"])->name("home.fetch");
Route::post("/home-order/store", [HomeController::class, "store"])->name("home.store");
Route::post("/home-order/update", [HomeController::class, "update"])->name("home.update");
Route::post("/home-order/delete", [HomeController::class, "delete"])->name("home.delete");

