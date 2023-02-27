<?php

namespace App\Validators;

use App\Entities\Request;

final class PermissionValidator extends Validator
{
    public function validate(Request $request): bool
    {
        $result = $request->getUser()->hasPermission();
        echo $result
            ? sprintf('User has %s confirmed', $request->getUser()->getPermission()) . PHP_EOL
            : 'Unknown permissions' . PHP_EOL;
        return $result && parent::validate($request);
    }
}