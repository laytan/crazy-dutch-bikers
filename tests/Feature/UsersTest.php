<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    private static $successMessage = 'Gebruiker geregistreerd';

    private function data()
    {
        return [
            'name' => 'Bob',
            'email' => 'mail@example.com',
            'password' => '',
            'generate-password' => true,
            'profile_picture' => UploadedFile::fake()->image('test.jpg'),
            'role' => 'member',
        ];
    }

    public function testAdminCanCreateMember()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->post(route('users.store'), $this->data());

        $response->assertSessionHas('success', self::$successMessage);
        $response->assertRedirect(route('users.index'));
        $this->assertCount(2, User::all());
    }

    public function testSuperAdminCanCreateAdmin()
    {
        $user = factory(User::class)->create([
            'role' => 'super-admin',
        ]);

        $response = $this->actingAs($user)->post(route('users.store'), array_merge($this->data(), [
            'role' => 'admin',
        ]));

        $response->assertSessionHas('success', self::$successMessage);
        $response->assertRedirect(route('users.index'));
        $this->assertCount(2, User::all());
    }

    public function testAdminCanNotCreateAdmin()
    {
        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->post(route('users.store'), array_merge($this->data(), [
            'role' => 'admin',
        ]));

        $response->assertSessionHas('error', 'Als beheerder kun je geen beheerders aanmaken');
        $response->assertRedirect(route('users.index'));
        $this->assertCount(1, User::all());
    }

    public function testMemberCanNotCreateUsers()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post(route('users.store'), $this->data());

        $response->assertSessionHas('error', 'Je kunt deze actie alleen als beheerder uitvoeren');
        $response->assertRedirect(route('index'));
        $this->assertCount(1, User::all());
    }
}
