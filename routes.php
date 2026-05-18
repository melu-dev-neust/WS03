<?php

    $router->get('/','HomeController@index');
    $router->get('/listings','ListingsController@index');
    $router->get('/listings/create','ListingsController@create', ['auth']);
    $router->get('/listings/edit/{id}','ListingsController@edit', ['auth']);
    $router->get('/listings/search','ListingsController@search');
    $router->get('/listings/{id}','ListingsController@show');
    $router->post('/listings','ListingsController@store', ['auth']);
    $router->put('listings/{id}','ListingsController@update', ['auth']);
    $router->delete('/listings/{id}','ListingsController@destroy', ['auth']);

    $router->get('/auth/register','UserController@create', ['guess']);
    $router->get('/auth/login','UserController@login', ['guess']);

    $router->post('/auth/register','UserController@store', ['guess']);
    $router->post('/auth/logout','UserController@logout', ['auth']);
    $router->post('/auth/login','UserController@authenticate', ['guess']);





?>