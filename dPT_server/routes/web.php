<?php

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

Route::get('/info', function () {
    return view('info');
});

#Get projects list
Route::get('/projects', function ($n) {

    return view('list');
});

#Load a project
Route::get('/projects/{name}', function ($n) {

    $project = DB::table('projects')->find($n);
    return view('project', project);
});

#Create a new project
Route::post('/projects/{name}', function () {
    
});

#Save changes on a project
Route::put('/projects/{name}', function () {
    
});