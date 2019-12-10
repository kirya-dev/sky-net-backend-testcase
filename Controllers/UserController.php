<?php

namespace Controllers;


class UserController
{
    public function index()
    {
        return 'This users page';
    }

    public function getById()
    {
        return 'getById';
    }

    public function tarifs($userId, $serviceId)
    {
        return 'Bingo! tarifs';
    }
}