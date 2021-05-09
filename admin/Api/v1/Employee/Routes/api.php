<?php

Route::prefix('api/v1/')
->namespace('Api\v1\Employee\Controllers')
->middleware([])
->group(function () {
    Route::resource('employees','EmployeeController');
    Route::post('employee-update/{id}','EmployeeController@update');
});
