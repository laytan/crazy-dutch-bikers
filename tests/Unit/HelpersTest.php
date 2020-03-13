<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function testCentsToEuroWorks()
    {
        $this->assertEquals(centsToEuro(100), '1.00');
    }

    public function testResolveProfilePicReturnsDefaultPathWhenNotGivenAProfilePicture()
    {
        $user = factory(User::class);
        $user->profile_picture = null;
        resolveProfilePic($user);

        $this->assertEquals($user->profile_picture, '/images/profile-placeholder.png');
    }
}
