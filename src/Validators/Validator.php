<?php

namespace App\Validators;

use App\Entities\Request;
use App\Output\LoggerInterface;

abstract class Validator
{
    public ?Validator $next = null;

    public function setNext(Validator $validator): Validator
    {
        $this->next = $validator;
        return $validator;
    }

    public function validate(Request $request): bool
    {
        return $this->next === null || $this->next->validate($request);
    }
}