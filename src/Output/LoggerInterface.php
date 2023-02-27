<?php

namespace App\Output;
interface LoggerInterface
{
    public function log(string $message): void;
    public function error(string $message): void;
}