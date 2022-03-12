<?php

use Illuminate\Support\Facades\Route;

//Using the ContactController
use App\Http\Controllers\ContactController;

//Using the User Model (Eloquent ORM)
use App\Models\User;

//Using the DB facade (for the query builder)
use Illuminate\Support\Facades\DB;

//Using the CategoryController
use App\Http\Controllers\CategoryController;

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
});

Route::get('/home', function () {
    echo "This is the home page";
});

Route::get('/about', function () {
    return view ('about');
});//->middleware('check');

//naming a route                                               route name
Route::get('/contact',[ContactController::class,'index'])->name('con');

//Category Controller
Route::get('/category/all',[CategoryController::class,'Allcat'])->name('all.category');

Route::post('/category/add',[CategoryController::class,'AddCat'])->name('store.category');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    //Eloquent ORM 

    //Getting all user data
    //$users = User::all();

    //Query builder
    $users = DB::table('users')->get();
    
    //Passing data to view
    return view('dashboard', compact('users'));
})->name('dashboard');


?>