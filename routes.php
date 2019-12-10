<?php
/**
 * Array of struct: pattern => action
 */

return [
    'GET /' => 'HomeController@index',
    'GET /users' => 'UserController@index',
    'GET /users/{id}' => 'UserController@getById',
    'GET /users/{user_id}/services/{service_id}/tarifs' => 'UserController@tarifs',
];
