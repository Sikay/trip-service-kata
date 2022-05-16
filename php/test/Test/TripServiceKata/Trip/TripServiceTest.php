<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    private const GUEST = null;
    private const UNUSED_USER = null;

    private TesteableTripService $tripService;

    protected function setUp()
    {
        $this->tripService = new TesteableTripService();
    }

    /** @test */
    public function should_throw_an_exception_when_user_is_not_logged_in() {
        $this->expectException(UserNotLoggedInException::class);

        $this->tripService->loggedInUser = self::GUEST;

        $this->tripService->getTripsByUser(new User(self::UNUSED_USER));
    }

}

class TesteableTripService extends TripService {

    public $loggedInUser;

    protected function getLoggedInUser()
    {
        return $this->loggedInUser;
    }
}
