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

Route::get('book', 'Focalworks\Audit\Http\Controllers\TestController@book');

Route::get('pre', 'Focalworks\Audit\Http\Controllers\TestController@pre');