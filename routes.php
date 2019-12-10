<?php
/**
 * Array of struct: pattern => action
 */

return [
    'GET /' => 'HomeController@index',
    'GET /users' => 'UserController@index',
    'GET /users/{user_id}/services/{service_id}/tarifs' => 'ServiceController@getTarifs',
    'PUT /users/{user_id}/services/{service_id}/tarif' => 'ServiceController@store',
];
