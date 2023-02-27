<?php

namespace App;

use App\Entities\Request;
use App\Output\LoggerInterface;
use App\Validators\Validator;

class Application
{
    public Validator $validator;

    public function __construct(private LoggerInterface $logger) {}


    public function setValidator(Validator $validator): void
    {
        $this->validator = $validator;
    }

    public function run(Request $request): void
    {
        $this->logger->log('--- Start request validation ---');
        $this->validator->validate($request)
            ? $this->logger->log('SUCCESS request')
            : $this->logger->error('FAILED request');
    }
}