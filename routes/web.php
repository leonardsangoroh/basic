<?php

use Illuminate\Support\Facades\Route;

//Using the ContactController
use App\Http\Controllers\ContactController;

//Using the User Model
use App\Models\User;

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


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    //Eloquent ORM 

    //Getting all user data
    $users = User::all();
    
    //Passing data to view
    return view('dashboard', compact('users'));
})->name('dashboard');
