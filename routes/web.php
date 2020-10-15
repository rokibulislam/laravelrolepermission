<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request as $request;

Route::get('/', function ( \Illuminate\Http\Request $request) {
    // $user = $request->user();
    // dump( $user->hasRole('Admin', 'User'));
    // dd( $user->can('delete post'));
    // dd( $user->givePermissionTo('delete User'));
    // dd( $user->updatePermissionTo('delete post'));
    // dd( $user->withdrawPermissionTo('delete post'));
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([ 'middleware' => 'role:Admin,delete User'], function() {

    Route::group([ 'middleware' => 'role:Admin,edit posts'], function() {
        Route::get('/admin/users', function() {
            return 'delete Admin Panel';
        });
    });

    Route::get('/admin', function() {
        return 'Admin Panel';
    });
});
