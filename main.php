<?php

/*
    Напишите: паттерн цепочка обязанностей для проверки запроса от клиента.
    - проверить статус пользователя
    - проверить роль пользователя
    - проверить наличие разрешения у пользователя
    - проверить чрезмерную активность пользователя для текущей роли и разрешения
    статусы, роли и разрешения на свое усмотрение, лимиты по активности произвольные, прерывать запрос, если не прошла хотя бы одна проверка.
 */

class Application
{
    private Validator $chain;

    /**
     * Сборка цепочки
     */
    public function __construct(Validator ...$validators)
    {
        $this->chain = array_shift($validators);
        $current = $this->chain;
        while (count($validators) > 0) {
            $current->next = array_shift($validators);
            $current = $current->next;
        }
    }

    /**
     * Проверка цепочки
     */
    public function check(array $request): bool
    {
        return $this->chain->validate($request);
    }
}

abstract class Validator
{
    public Validator $next;

    final public function validate(array $request): bool
    {
        return $this->check($request) && isset($this->next) && $this->next->validate($request);
    }

    abstract public function check(array $request): bool;
}

final class StatusValidator extends Validator
{
    public function check(array $request): bool
    {
        if ($request['status'] === 'enabled') {
            echo 'Status confirmed' . PHP_EOL;
            return true;
        }
        echo 'Incorrect status' . PHP_EOL;
        return false;
    }
}

final class RoleValidator extends Validator
{
    private const ROLES = ['admin', 'user'];

    public function check(array $request): bool
    {
        $result = in_array($request['role'], self::ROLES, true);
        echo $result
            ? sprintf('Assigned %s role', $request['role']) . PHP_EOL
            : 'Unknown role' . PHP_EOL;
        return $result;
    }
}

final class PermissionValidator extends Validator
{
    private const PERMISSIONS = ['limited', 'unlimited'];

    public function check(array $request): bool
    {
        $result = in_array($request['permission'], self::PERMISSIONS, true);
        echo $result
            ? 'Permission confirmed' . PHP_EOL
            : 'Unknown permissions' . PHP_EOL;
        return $result;
    }
}

final class ActivityValidator extends Validator
{
    public function check(array $request): bool
    {
        if ($request['role'] === 'admin') {
            echo 'Unlimited access' . PHP_EOL;
            return true;
        }
        if ($request['role'] === 'user') {
            if ($request['permission'] === 'unlimited' && $request['activity'] < 100) {
                echo 'Activity is normal' . PHP_EOL;
                return true;
            }
            if ($request['permission'] === 'limited' && $request['activity'] < 10) {
                echo 'Activity is normal' . PHP_EOL;
                return true;
            }
            echo 'Excessive activity' . PHP_EOL;
            return false;
        }
        echo 'User activity is not defined' . PHP_EOL;
        return false;
    }
}

$app = new Application(new StatusValidator, new RoleValidator, new PermissionValidator, new ActivityValidator);
$request = [
    'status' => 'enabled', //disabled
    'role' => 'user', //admin
    'permission' => 'limited', //unlimited
    'activity' => 9
];
$app->check($request);
