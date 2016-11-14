<?php

$api->get('/', function(){});

$api->group(['middleware'=> 'api:auth'], function ($api){
    $api->get('clients/validate/prefix/{prefix}', ['uses' => 'ClientAPIController@validatePrefix']);
    $api->resource('clients', 'ClientAPIController');

    $api->get('clients/{clientID}/telephones/primary', ['uses' => 'ClientTelephonesAPIController@getPrimary']);
    $api->put('clients/{clientID}/telephones/{telephoneID}/primary', ['uses' => 'ClientTelephonesAPIController@makePrimary']);
    $api->resource('clients.telephones', 'ClientTelephonesAPIController');

    $api->resource('contacts', 'ContactAPIController');
    $api->resource('quotes', 'QuoteAPIController');
    $api->resource('items', 'ItemAPIController');
});