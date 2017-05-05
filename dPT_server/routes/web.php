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

#Returns projects list
Route::get('/api/projects', 'HomeController@getProjects');

#Returns a project
Route::get('/api/projects/{name}', ['uses' => 'HomeController@getProject']);


#Saves a new project
Route::post('/api/projects', ['uses' => 'HomeController@newProject']);


#Open new project view
Route::get('/projects/new', 'HomeController@newProject');

#Load a project
Route::get('/projects/{name}', ['uses' => 'HomeController@loadProject']);


#Save changes on a project
Route::put('/projects/{name}', function () {

});

Auth::routes();

Route::get('/home', 'HomeController@index');
