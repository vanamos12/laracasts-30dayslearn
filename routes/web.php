<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Mail\JobPosted;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use App\Models\Job;
use Illuminate\Support\Facades\Mail;

Route::get('test', function(){
    return new JobPosted(Job::firstOrFail());

    //Mail::to('pokatchoneng@gmail.com')->send(new JobPosted(Job::firstOrFail()));
    
    //return 'Done!';

});

Route::view('/', 'home');

Route::get('/contact', function () {
    return view("contact");
});

//Route::resource('jobs', JobController::class, [
    //'only' => ['update']
//])->middleware('auth');

Route::get('/register', [RegisteredUserController::class, 'create']);

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');

Route::post('/login', [SessionController::class, 'store']);

Route::post('/logout', [SessionController::class, 'destroy']);

Route::controller(JobController::class)->group(function (){

    Route::get('/jobs', 'index');

    Route::get('/jobs/create', 'create');

    Route::get('/jobs/{job}', 'show');

    Route::post('/jobs', 'store')->middleware('auth');

    // Edit
    // Route::get('/jobs/{job}/edit', 'edit')->middleware(['auth', 'can:edit-job,job']);
    // Route::get('/jobs/{job}/edit', 'edit')->middleware('auth')->can('edit-job', 'job');
    Route::get('/jobs/{job}/edit', 'edit')->middleware('auth')->can('edit', 'job');

    // Update
    Route::patch('/jobs/{job}', 'update');

    // Destroy
    Route::delete('/jobs/{job}', 'destroy');


});









