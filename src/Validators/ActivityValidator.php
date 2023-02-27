<?php

namespace App\Validators;


use App\Entities\Request;

final class ActivityValidator extends Validator
{
    private const UNLIMITED_RESTRICTION = 100;
    private const LIMITED_RESTRICTION = 10;

    public function validate(Request $request): bool
    {
        if ($request->getUser()->isAdmin()) {
            echo 'Unlimited access' . PHP_EOL;
            return parent::validate($request);
        }
        if ($request->getUser()->isClient()) {
            if ($request->getUser()->hasUnlimitedAccess() && $request->getUser()->getActivity() < self::UNLIMITED_RESTRICTION) {
                echo 'Activity is normal' . PHP_EOL;
                return parent::validate($request);
            }
            if ($request->getUser()->hasLimitedAccess() && $request->getUser()->getActivity() < self::LIMITED_RESTRICTION) {
                echo 'Activity is normal' . PHP_EOL;
                return parent::validate($request);
            }
            echo 'Excessive activity' . PHP_EOL;
            return false;
        }
        echo 'User activity is not defined' . PHP_EOL;
        return false;
    }
}