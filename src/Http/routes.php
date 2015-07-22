<?php
/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 15/7/15
 * Time: 10:55 AM
 */

Route::get('create', 'Focalworks\Audit\Http\Controllers\TestController@create');

Route::get('previous', 'Focalworks\Audit\Http\Controllers\TestController@pre');

Route::get('demo', 'Focalworks\Audit\Http\Controllers\TestController@demo');

Route::get('audit/{type}/{id}', 'Focalworks\Audit\Http\Controllers\AuditController@audit');

Route::get('diff/{id}', 'Focalworks\Audit\Http\Controllers\AuditController@diff');

Route::get('audit-history/{all?}', 'Focalworks\Audit\Http\Controllers\AuditController@history');