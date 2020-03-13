<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    private $user_properties = ['name', 'email', 'role', 'profile_picture', 'password', 'description'];

    private function assertNothingElseChanged($user, $other_user, $dont_check)
    {
        $to_check = array_filter($this->user_properties, fn($property) => !in_array($property, $dont_check));
        foreach ($to_check as $property) {
            $this->assertEquals($user->$property, $other_user->$property);
        }
    }

    public function testAMemberCanNotUpdateItsName()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->patch(route('users.update', ['user' => $user->id]), ['name' => 'test 2']);
        $updated_user = $user::first();

        // Verify response
        $response->assertRedirect(route('users.edit', ['user' => $user->id]));
        $response->assertSessionHas('error', 'Als member kan je niet je naam veranderen, vraag een beheerder hiervoor');

        // Verify name did not change
        $this->assertEquals($updated_user->name, $user->name);

        $this->assertNothingElseChanged($user, $updated_user, ['name']);
    }

    public function testAnAdminCanUpdateAMembersName()
    {
        // Set up
        $admin = factory(User::class)->create(['role' => 'admin']);
        $user = factory(User::class)->create();

        // Execute request
        $response = $this->actingAs($admin)->patch(route('users.update', ['user' => $user->id]), ['name' => 'test123']);
        $updated_user = $user::find($user->id);

        // Verify redirect and session
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Lid is bijgewerkt');

        // Verify name change
        $this->assertEquals($updated_user->name, 'test123');

        $this->assertNothingElseChanged($user, $updated_user, ['name']);
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

        $this->assertNothingElseChanged($user, $updated_user, ['password']);
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

        $this->assertNothingElseChanged($user, $updated_user, []);
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

        $this->assertNothingElseChanged($updated_member, $member, []);
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

        $this->assertNothingElseChanged($updated_admin, $admin, ['role']);
    }

    public function testAnAdminCanNotUpdateAMembersEmailWhenItIsTaken()
    {
        // Set up
        $admin = factory(User::class)->create(['role' => 'admin']);
        $user = factory(User::class)->create();
        $takenEmailUser = factory(User::class)->create(['email' => 'test@test.test']);

        // Execute request
        $response = $this->actingAs($admin)->patch(
            route(
                'users.update',
                ['user' => $user->id]
            ),
            ['email' => 'test@test.test']
        );

        $updated_user = $user::find($user->id);

        $response->assertRedirect(route('users.edit', ['user' => $user->id]));
        $response->assertSessionHas('error', 'Deze email is al bezet');

        $this->assertNotEquals($updated_user->email, 'test@test.test');

        $this->assertNothingElseChanged($updated_user, $user, ['email']);
    }

    public function testAnAdminCanUpdateAMembersEmail()
    {
        $member = factory(User::class)->create();
        $admin = factory(User::class)->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->patch(
            route(
                'users.update',
                ['user' => $member->id]
            ),
            ['email' => 'test@test.test']
        );
        $updated_member = User::find($member->id);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Lid is bijgewerkt');

        $this->assertEquals($updated_member->email, 'test@test.test');
        $this->assertNothingElseChanged($member, $updated_member, ['email']);
    }

    public function testAMemberCanNotUpdateItsEmail()
    {
        $member = factory(User::class)->create();

        $response = $this->actingAs($member)->patch(
            route(
                'users.update',
                ['user' => $member->id]
            ),
            ['email' => 'test@test.test']
        );
        $updated_member = User::first();

        $response->assertRedirect(route('users.update', ['user' => $member->id]));
        $response->assertSessionHas(
            'error',
            'Als member kan je niet je email veranderen, vraag een beheerder hiervoor'
        );

        $this->assertNothingElseChanged($member, $updated_member, []);
    }
}
