<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Src\Domain\User\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
       # \Artisan::call('shield:generate');
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $user  = User::factory()->create(
            [
                'name'              => 'super_admin',
                'email'             => 'hitoceanadmin@admin.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('Hitocean3684533!')
            ]
        );
        $user_admin  = User::factory()->create(
            [
                'name'              => 'admin',
                'email'             => 'admin@admin.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('admin1234')
            ]
        );

        $user->assignRole(['super_admin']);
        $user_admin->assignRole(['admin']);

        #$this->addPermissionToRole($admin, 'user');
    }

    private function addPermissionToRole(Role $role, string $resource): void
    {
        echo "\033[93m Add permissions for resource:$resource to role:{$role->name}\n";

        $role->givePermissionTo([
                                    'view_' . $resource,
                                    'view_any_' . $resource,
                                    'create_' . $resource,
                                    'delete_' . $resource,
                                    'delete_any_' . $resource,
                                    'update_' . $resource,
                                    'export_' . $resource,
                                ]);
    }
}
