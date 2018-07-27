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

use App\Reservation;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function(){
    // Artisan::call('migrate:refresh');
    Artisan::call('queue:listen');
});


Route::get('/elastic/{fullname}', function($fullname) {
    $reservations = Reservation::complexSearch(array(
        'body' => array(
            'query' => array(
                'match' => array(
                    'fullname' => array(
                        'query' => $fullname,
                        'fuzziness' => 2,
                        'prefix_length' => 1
                    )
                )
            )
        )
    ));
    return view('elastic', [
        'reservations' => $reservations
    ]);
});


Route::get('/customers', function() {
    $customers = Reservation::complexSearch(array(
        'body' => array(
            'aggs' => array(
                'customers' => array(
                    'terms' => array(
                        'field' => 'fullname'
                    )
                )
            )
        )
    ));

    return $customers;
});