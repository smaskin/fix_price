<?php

namespace App\Validators;


use App\Entities\Request;
use App\Services\UserService;

final class ActivityValidator extends Validator
{
    public function __construct(private UserService $users) {}

    private const PREMIUM_CUT = 100;
    private const LIMITED_CUT = 10;

    public function validate(Request $request): bool
    {
        $user = $request->getUser();
        if ($this->users->isAdmin($user)) {
            echo 'Unlimited access' . PHP_EOL;
            return parent::validate($request);
        }
        if ($this->users->inLimitedRange($user, self::LIMITED_CUT) || $this->users->inPremiumRange($user, self::PREMIUM_CUT)) {
            echo 'Activity is normal' . PHP_EOL;
            return parent::validate($request);
        }
        echo 'Excessive activity' . PHP_EOL;
        return false;
    }
}