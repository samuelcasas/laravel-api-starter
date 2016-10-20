<?php

$api->group(['middleware'=> 'api:auth'], function ($api){
    //
});

























Route::resource('tasks', 'TaskAPIController');