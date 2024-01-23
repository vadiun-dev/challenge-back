<?php

namespace Application\Admin\User\Controllers;

use Illuminate\Support\Facades\Hash;
use Src\Application\Admin\User\Controllers\UserController;
use Src\Domain\User\Enums\Roles;
use Src\Domain\User\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->withRole(Roles::ADMIN)->create();
    }

    /** @test */
    public function it_can_store_a_user(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'roles' => [Roles::ADMIN],
        ];

        $this->actingAs($this->user)->post(action([UserController::class, 'store']), $userData)->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        $user = User::where('email', 'johndoe@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertTrue($user->hasRole(Roles::ADMIN));
    }

    /** @test */
    public function it_can_update_a_user(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $userData = [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'roles' => [Roles::ADMIN],
        ];

        $this->actingAs($this->user)->put(action([UserController::class, 'update'], $user->id), $userData)->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $user->refresh();
        $this->assertTrue($user->hasRole(Roles::ADMIN));
    }

    /** @test */
    public function it_can_delete_a_user(): void
    {

        $user = User::factory()->create();

        $this->actingAs($this->user)->delete(action([UserController::class, 'destroy'], $user->id))->assertOk();

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_show_a_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->user)
            ->get(action([UserController::class, 'show'], $user->id))
            ->assertOk()
            ->assertExactJson([
                'email' => $user->email,
                'name' => $user->name,
                'roles' => [],
                'id' => $user->id,
            ]);

    }

    /** @test */
    public function it_can_return_a_collection_of_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->user)
            ->get(action([UserController::class, 'index']))
            ->assertOk()
            ->assertExactJson([
                [
                    'email' => $this->user->email,
                    'name' => $this->user->name,
                    'roles' => [Roles::ADMIN],
                    'id' => $this->user->id,
                ],
                [
                    'email' => $user->email,
                    'name' => $user->name,
                    'roles' => [],
                    'id' => $user->id,
                ],
            ]);

        // Asegúrate de incluir más aserciones para los datos que esperas en la colección de recursos.
    }
}
