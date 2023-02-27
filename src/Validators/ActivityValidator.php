<?php

namespace App\Validators;


use App\Entities\Request;
use App\Output\LoggerInterface;
use App\Services\UserService;

final class ActivityValidator extends Validator
{
    public function __construct(public LoggerInterface $logger, private UserService $users) {}

    private const PREMIUM_CUT = 100;
    private const LIMITED_CUT = 10;

    public function validate(Request $request): bool
    {
        $user = $request->getUser();
        if ($this->users->isAdmin($user)) {
            $this->logger->log('Unlimited access');
            return parent::validate($request);
        }
        if ($this->users->inLimitedRange($user, self::LIMITED_CUT) || $this->users->inPremiumRange($user, self::PREMIUM_CUT)) {
            $this->logger->log('Activity is normal');
            return parent::validate($request);
        }
        $this->logger->error('Excessive activity');
        return false;
    }
}