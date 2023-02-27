<?php

namespace App\Validators;

use App\Entities\Request;
use App\Output\LoggerInterface;

final class StatusValidator extends Validator
{
    public function __construct(public LoggerInterface $logger) {}

    public function validate(Request $request): bool
    {
        if ($request->getUser()->isEnabledStatus()) {
            $this->logger->log('Status confirmed');
            return parent::validate($request);
        }
        $this->logger->error('Incorrect status');
        return false;
    }
}