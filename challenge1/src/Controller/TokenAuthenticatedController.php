<?php

namespace App\Controller;

use App\DTO\CreateUserDTO;
use Symfony\Component\HttpFoundation\Request;

interface TokenAuthenticatedControler
{
    public function createUser(CreateUserDTO $data, Request $req);
}
