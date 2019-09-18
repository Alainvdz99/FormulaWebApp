<?php

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface CrudControllerInterface
{
    public function index();

    public function create(Request $request);

    public function delete(int $id);
}