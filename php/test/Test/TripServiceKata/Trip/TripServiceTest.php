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
        $this->tripService->loggedInUser = new User(self::REGISTERED_USER);
    }

    /** @test */
    public function should_throw_an_exception_when_user_is_not_logged_in() {
        $this->expectException(UserNotLoggedInException::class);

        $this->tripService->loggedInUser = self::GUEST;

        $this->tripService->getTripsByUser(new User(self::UNUSED_USER));
    }

    /** @test */
    public function should_not_return_any_trips_when_users_are_not_friends() {
        $anotherUser = new User(self::ANOTHER_USER);
        $toBrazil = new Trip();

        $friend = UserBuilder::aUser()
                    ->friendsWith($anotherUser)
                    ->withTrips($toBrazil)
                    ->build();

        $friendTrip = $this->tripService->getTripsByUser($friend);

        self::assertTrue(sizeof($friendTrip) === 0);
    }

    /** @test */
    public function should_return_friends_trips_when_users_are_friends() {
        $anotherUser = new User(self::ANOTHER_USER);
        $toBrazil = new Trip();
        $toLondon = new Trip();

        $friend = UserBuilder::aUser()
                    ->friendsWith($anotherUser, $this->tripService->loggedInUser)
                    ->withTrips($toBrazil, $toLondon)
                    ->build();

        $friendTrip = $this->tripService->getTripsByUser($friend);

        self::assertTrue(sizeof($friendTrip) === 2);
    }

}

class TesteableTripService extends TripService {

    public $loggedInUser;

    protected function getLoggedInUser()
    {
        return $this->loggedInUser;
    }

    protected function tripsBy(User $user): array
    {
        return $user->getTrips();
    }
}
