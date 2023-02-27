<?php

require 'vendor/autoload.php';

use App\Application;
use App\Entities\Request;
use App\Entities\User;
use App\Output\ConsoleLogger;
use App\Services\UserService;
use App\Validators\ActivityValidator;
use App\Validators\PermissionValidator;
use App\Validators\RoleValidator;
use App\Validators\StatusValidator;

/*
    Напишите: паттерн цепочка обязанностей для проверки запроса от клиента.
    - проверить статус пользователя
    - проверить роль пользователя
    - проверить наличие разрешения у пользователя
    - проверить чрезмерную активность пользователя для текущей роли и разрешения
    статусы, роли и разрешения на свое усмотрение, лимиты по активности произвольные, прерывать запрос, если не прошла хотя бы одна проверка.
 */

$log = new ConsoleLogger;
$app = new Application($log);
$validator = new StatusValidator($log);
$validator
    ->setNext(new RoleValidator($log))
    ->setNext(new PermissionValidator($log))
    ->setNext(new ActivityValidator($log, new UserService));
$app->setValidator($validator);

$request = new Request(new User('disabled', 'user', 'limited', 9));
$app->run($request);
$request = new Request(new User('enabled', 'user', 'limited', 19));
$app->run($request);
$request = new Request(new User('enabled', 'user', 'limited', 9));
$app->run($request);
$request = new Request(new User('enabled', 'admin', 'limited', 9));
$app->run($request);
