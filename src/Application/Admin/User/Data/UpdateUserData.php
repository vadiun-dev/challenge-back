<?php

namespace Src\Application\Admin\User\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class UpdateUserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public int $id,
        public array $roles
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->name,
            email: $request->email,
            id: $request->route('user'),
            roles: $request->roles
        );
    }
}
