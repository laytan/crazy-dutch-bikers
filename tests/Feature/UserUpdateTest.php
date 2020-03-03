<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanUpdateItsName()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->patch(route('users.update', ['user' => $user->id]), ['name' => 'test 2']);
        $updated_user = $user::first();

        // Verify response
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Lid is bijgewerkt');

        // Verify name changed
        $this->assertEquals($updated_user->name, 'test 2');

        // Verify nothing else changed
        $this->assertEquals($updated_user->description, $user->description);
        $this->assertEquals($updated_user->role, $user->role);
        $this->assertEquals($updated_user->profile_picture, $user->profile_picture);
        $this->assertEquals($updated_user->password, $user->password);
        $this->assertEquals($updated_user->email, $user->email);
    }

    public function testAUserCanUpdateItsPassword()
    {
        $user = factory(User::class)->create();
        $oldHash = $user->password;
        $response = $this->actingAs($user)->patch(route('users.update', ['user' => $user->id]), [
            'password' => 'password2',
            'old_password' => 'password',
        ]);
        $updated_user = $user::first();

        // Verify response
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Lid is bijgewerkt');

        // Verify password changed
        $this->assertNotEquals($updated_user->password, $oldHash);

        // Verify nothing else changed
        $this->assertEquals($updated_user->description, $user->description);
        $this->assertEquals($updated_user->role, $user->role);
        $this->assertEquals($updated_user->profile_picture, $user->profile_picture);
        $this->assertEquals($updated_user->name, $user->name);
        $this->assertEquals($updated_user->email, $user->email);
    }

    public function testAMemberCanNotUpdateItsRoleToAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->patch(route('users.update', ['user' => $user->id]), [
            'role' => 'admin',
        ]);
        $updated_user = $user::first();

        // Verify response
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error', 'Je kunt deze gebruiker geen beheerder maken');

        // Verify nothing else changed
        $this->assertEquals($updated_user->password, $user->password);
        $this->assertEquals($updated_user->description, $user->description);
        $this->assertEquals($updated_user->role, $user->role);
        $this->assertEquals($updated_user->profile_picture, $user->profile_picture);
        $this->assertEquals($updated_user->name, $user->name);
        $this->assertEquals($updated_user->email, $user->email);
    }

    public function testAnAdminCanNotMakeAMemberAnAdmin()
    {
        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);
        $member = factory(User::class)->create([
            'role' => 'member',
        ]);
        $response = $this->actingAs($user)->patch(route('users.update', ['user' => $member->id]), [
            'role' => 'admin',
        ]);
        $updated_member = $user::find(2);

        // Verify response
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error', 'Je kunt deze gebruiker geen beheerder maken');

        // Verify nothing else changed
        $this->assertEquals($updated_member->password, $member->password);
        $this->assertEquals($updated_member->description, $member->description);
        $this->assertEquals($updated_member->role, $member->role);
        $this->assertEquals($updated_member->profile_picture, $member->profile_picture);
        $this->assertEquals($updated_member->name, $member->name);
        $this->assertEquals($updated_member->email, $member->email);
    }

    public function testASuperAdminCanUpdateAUsersRole()
    {
        $user = factory(User::class)->create([
            'role' => 'super-admin',
        ]);
        $admin = factory(User::class)->create([
            'role' => 'admin',
        ]);
        $response = $this->actingAs($user)->patch(route('users.update', ['user' => $admin->id]), [
            'role' => 'member',
        ]);
        $updated_admin = $user::find(2);

        // Verify response
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Lid is bijgewerkt');

        $this->assertEquals($updated_admin->role, 'member');

        // Verify nothing else changed
        $this->assertEquals($updated_admin->password, $admin->password);
        $this->assertEquals($updated_admin->description, $admin->description);
        $this->assertEquals($updated_admin->profile_picture, $admin->profile_picture);
        $this->assertEquals($updated_admin->name, $admin->name);
        $this->assertEquals($updated_admin->email, $admin->email);
    }
}
