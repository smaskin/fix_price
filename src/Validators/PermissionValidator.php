<?php

namespace App\Validators;

use App\Entities\Request;
use App\Output\LoggerInterface;

final class PermissionValidator extends Validator
{
    public function __construct(public LoggerInterface $logger) {}

    public function validate(Request $request): bool
    {
        if($request->getUser()->checkPermission()){
            $this->logger->log(sprintf('User has %s permission', $request->getUser()->getPermission()));
            return parent::validate($request);
        }
        $this->logger->error('Unknown permissions');
        return false;
    }
}