<?php

namespace App\Validators;

use App\Entities\Request;

final class RoleValidator extends Validator
{
    public function validate(Request $request): bool
    {

        $result = $request->getUser()->hasRole();
        echo $result
            ? sprintf('Assigned %s role', $request->getUser()->getRole()) . PHP_EOL
            : 'Unknown role' . PHP_EOL;
        return $result && parent::validate($request);
    }
}