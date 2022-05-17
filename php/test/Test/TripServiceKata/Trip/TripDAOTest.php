<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;
use TripServiceKata\Trip\TripDAO;
use TripServiceKata\User\User;

class TripDAOTest extends TestCase
{
    /** @test  */
    public function should_throw_exception_when_retrieving_user_trips()
    {
        self::expectException(DependentClassCalledDuringUnitTestException::class);
        $tripDao = new TripDAO();
        $tripDao->tripsBy(new User());
    }
}
