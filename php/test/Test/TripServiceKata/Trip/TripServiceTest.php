<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    private const GUEST = null;
    private const UNUSED_USER = null;
    private const REGISTERED_USER = 'Francisco';
    private const ANOTHER_USER = 'Pepe';

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

    /** @test */
    public function should_not_return_any_trips_when_users_are_not_friends() {

        $friend = new User('Juan');
        $friend->addFriend(new User(self::ANOTHER_USER));
        $friend->addTrip(new Trip());

        $this->tripService->loggedInUser = new User(self::REGISTERED_USER);;
        $friendTrip = $this->tripService->getTripsByUser($friend);

        self::assertTrue(sizeof($friendTrip) === 0);
    }

}

class TesteableTripService extends TripService {

    public $loggedInUser;

    protected function getLoggedInUser()
    {
        return $this->loggedInUser;
    }
}
