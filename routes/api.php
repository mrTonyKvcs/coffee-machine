<?php

use Illuminate\Http\Request;

Route::get('machines/{machine}', 'Api\MachinesController@getMachine');
Route::post('order-product/{machine}/{product}', 'Api\MachinesController@productMaking');
