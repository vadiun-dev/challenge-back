<?php

namespace Src\Application\Admin\User\Data;

use Spatie\LaravelData\Data;

class StoreUserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public array $roles
    ) {
    }
}
