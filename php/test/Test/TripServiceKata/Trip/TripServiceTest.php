<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Exception\UserNotLoggedInException;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripDAO;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    private const GUEST = null;
    private const UNUSED_USER = null;
    private const REGISTERED_USER = 'Francisco';
    private const ANOTHER_USER = 'Pepe';

    private TripService $tripService;
    private User $loggedInUser;
    private TripDAO $tripDAO;

    protected function setUp()
    {
        $this->tripService = new TripService();
        $this->loggedInUser = new User(self::REGISTERED_USER);
        $this->tripDAO = $this->getMockBuilder(TripDAO::class)->getMock();
    }

    /** @test */
    public function should_throw_an_exception_when_user_is_not_logged_in() {
        $this->expectException(UserNotLoggedInException::class);

        $this->loggedInUser = new User(self::GUEST);

        $this->tripService->getTripsByUser(new User(self::UNUSED_USER), $this->tripDAO, self::GUEST);
    }

    /** @test */
    public function should_not_return_any_trips_when_users_are_not_friends() {
        $anotherUser = new User(self::ANOTHER_USER);
        $toBrazil = new Trip();

        $this->tripDAO
            ->method('tripsBy')
            ->willReturn([]);

        $friend = UserBuilder::aUser()
                    ->friendsWith($anotherUser)
                    ->withTrips($toBrazil)
                    ->build();

        $friendTrip = $this->tripService->getTripsByUser($friend, $this->tripDAO, $this->loggedInUser);

        self::assertTrue(sizeof($friendTrip) === 0);
    }

    /** @test */
    public function should_return_friends_trips_when_users_are_friends() {
        $anotherUser = new User(self::ANOTHER_USER);
        $toBrazil = new Trip();
        $toLondon = new Trip();

        $this->tripDAO
            ->method('tripsBy')
            ->willReturn([$toBrazil, $toLondon]);

        $friend = UserBuilder::aUser()
                    ->friendsWith($anotherUser, $this->loggedInUser)
                    ->withTrips($toBrazil, $toLondon)
                    ->build();

        $friendTrip = $this->tripService->getTripsByUser($friend, $this->tripDAO, $this->loggedInUser);

        self::assertTrue(sizeof($friendTrip) === 2);
    }

}
