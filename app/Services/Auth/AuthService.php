<?php
namespace App\Services\Auth;

use App\Services\User\UserService;

class AuthService
{
    protected $userService;

    public function __construct()
    {
       $this->userService = new UserService;
    }

    public function registerAdminUser(Array $data)
    {
        
    }
}