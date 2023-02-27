<?php

namespace App\Output;
interface LoggerInterface
{
    public function log(string $message);
    public function error(string $string);
}