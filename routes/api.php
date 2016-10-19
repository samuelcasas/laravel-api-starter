<?php

$api->get('/', function(){
    return ['ping' => 'pong'];
});

$api->group(['middleware'=> 'api:auth'], function ($api){
    $api->get('me', function(\Illuminate\Http\Request $req){
        return $req->user();
    });
});