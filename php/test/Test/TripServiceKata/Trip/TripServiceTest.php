<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    /**
     * @var TripService
     */
    private $tripService;

    protected function setUp()
    {
        $this->tripService = new TesteableTripService();
    }

    /** @test */
    public function should_throw_an_exception_when_user_is_not_logged_in() {
        $this->expectException(UserNotLoggedInException::class);
        $this->tripService->getTripsByUser(new User(null));
    }

}

class TesteableTripService extends TripService {

    protected function getLoggedInUser()
    {
        return null;
    }
}
