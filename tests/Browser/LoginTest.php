<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use Tests\Browser\Pages\HomePage;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test the login flow through the general navbar and modal
     *
     * @return void
     */
    public function testLoginModal()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $browser->visit(new HomePage)
                    // Open modal
                    ->click('@login-link')
                    ->assertLoginModal()
                    // Clear fields
                    ->clear('email')
                    ->clear('password')
                    // Type user credentials
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    // Click login
                    ->click('@login-submit')
                    // Assert that the user dropdown has the users name as the link
                    ->assertSeeIn('#user-dropdown', $user->name);
        });
    }

    /**
     * Test that we see the login modal after clicking the big login btn on the homepage
     */
    public function testLoginHomepageLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                    ->click('@home-login-btn')
                    ->assertLoginModal();
        });
    }

    /**
     * Test that we see the login modal when we click a route we can't view logged out
     */
    public function testLoggedOutSeesLoginModalTryingToAccessLoggedInRoute()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                    ->click('@merchandise-btn')
                    ->assertLoginModal();
        });
    }
}
