<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * Test that the login modal shows on clicking login
     *
     * @return void
     */
    public function testLoginModal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('#login-link')
                    ->assertSee('E-Mail')
                    ->assertSee('Wachtwoord')
                    ->assertSee('LOG IN!');
        });
    }
}
