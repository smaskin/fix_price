<?php

namespace App\Output;
class ConsoleLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        $this->out($message);
    }

    public function error(string $message): void
    {
        $this->out('Error - ' . $message);
    }

    private function out($message): void
    {
        echo $message . PHP_EOL;
    }
}