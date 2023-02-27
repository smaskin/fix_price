<?php

namespace App;

use App\Entities\Request;
use App\Validators\Validator;

class Application
{
    public Validator $validator;

    public function setValidator(Validator $validator): void
    {
        $this->validator = $validator;
    }

    public function run(Request $request): void
    {
        echo '--- Start request validation ---' . PHP_EOL;
        echo $this->validator->validate($request)
            ? 'SUCCESS validation' . PHP_EOL
            : 'FAILED validation' . PHP_EOL;
    }
}