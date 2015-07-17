<?php
/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 15/7/15
 * Time: 10:55 AM
 */

Route::get('audit',function(){
    echo "hello";
});

Route::get('create', 'Focalworks\Audit\Http\Controllers\TestController@create');

Route::get('pre', 'Focalworks\Audit\Http\Controllers\TestController@pre');