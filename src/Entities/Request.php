<?php

namespace App\Entities;

class Request
{
    public function __construct(public User $user) {}

    public function getUser(): User
    {
        return $this->user;
    }
}