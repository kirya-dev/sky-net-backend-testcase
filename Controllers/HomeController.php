<?php

namespace Controllers;


class HomeController
{
    public function index()
    {
        require dirname(__DIR__).'/views/index.php';
    }
}