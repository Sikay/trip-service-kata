<?php

namespace Test\TripServiceKata\User;

use PHPUnit\Framework\TestCase;
use Test\TripServiceKata\Trip\UserBuilder;
use TripServiceKata\User\User;

class UserTest extends TestCase
{
    /** @test */
    public function should_inform_when_users_are_not_friends() {
        $bob = new User();
        $paul = new User();

        $user = UserBuilder::aUser()
                    ->friendsWith($bob)
                    ->build();

        self::assertFalse($user->isFriendsWith($paul));
    }
}
