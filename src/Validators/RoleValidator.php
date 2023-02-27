<?php

namespace App\Validators;

use App\Entities\Request;
use App\Output\LoggerInterface;

final class RoleValidator extends Validator
{
    public function __construct(public LoggerInterface $logger) {}

    public function validate(Request $request): bool
    {
        if($request->getUser()->hasRole()){
            $this->logger->log(sprintf('Assigned %s role', $request->getUser()->getRole()));
            return parent::validate($request);
        }
        $this->logger->error('Unknown role');
        return false;
    }
}