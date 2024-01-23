<?php

namespace Src\Application\Admin\User\Controllers;

use Illuminate\Support\Facades\Hash;
use Src\Application\Admin\User\Data\StoreUserData;
use Src\Application\Admin\User\Data\UpdateUserData;
use Src\Application\Admin\User\Resources\UserResource;
use Src\Domain\User\Models\User;

class UserController
{
    public function store(StoreUserData $data): void
    {
        \DB::transaction(function () use ($data): void {
            $user = User::create(
                [
                    'name' => $data->name,
                    'email' => $data->email,
                    'password' => Hash::make($data->password),
                ]
            );

            $user->assignRole($data->roles);
        });
    }

    public function update(UpdateUserData $data): void
    {
        \DB::transaction(function () use ($data): void {
            $user = User::findOrFail($data->id);
            $user->update(
                [
                    'name' => $data->name,
                    'email' => $data->email,

                ]
            );
            $user->roles()->detach();
            $user->assignRole($data->roles);
        });

    }

    public function destroy(int $user_id): void
    {
        \DB::transaction(fn () => User::destroy($user_id));
    }

    public function show(int $user_id): UserResource
    {
        return new UserResource(User::with('roles')->findOrFail($user_id));
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection(User::with('roles')->get());
    }
}
