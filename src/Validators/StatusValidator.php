<?php

namespace App\Validators;

use App\Entities\Request;

final class StatusValidator extends Validator
{
    public function validate(Request $request): bool
    {
        if ($request->getUser()->isEnabledStatus()) {
            echo 'Status confirmed' . PHP_EOL;
            return parent::validate($request);
        }
        echo 'Incorrect status' . PHP_EOL;
        return false;
    }
}