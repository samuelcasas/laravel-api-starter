<?php

$api->get('/', function(){});

$api->group(['middleware'=> 'api:auth'], function ($api){
    $api->group(['namespace' => 'Clients'], function($api){
        $api->get('clients/validate/prefix/{prefix}', ['uses' => 'ClientAPIController@validatePrefix']);
        $api->resource('clients', 'ClientAPIController');

        $api->get('clients/{clientID}/telephones/primary', ['uses' => 'ClientTelephonesAPIController@getPrimary']);
        $api->put('clients/{clientID}/telephones/{telephoneID}/primary', ['uses' => 'ClientTelephonesAPIController@makePrimary']);
        $api->resource('clients.telephones', 'ClientTelephonesAPIController');

        $api->get('clients/{clientID}/emails/primary', ['uses' => 'ClientEmailsAPIController@getPrimary']);
        $api->put('clients/{clientID}/emails/{telephoneID}/primary', ['uses' => 'ClientEmailsAPIController@makePrimary']);
        $api->resource('clients.emails', 'ClientEmailsAPIController');
    });

    $api->group(['namespace' => 'Contacts'], function($api){
        $api->resource('contacts', 'ContactAPIController');
    });

    $api->resource('quotes', 'QuoteAPIController');
    $api->resource('items', 'ItemAPIController');
});