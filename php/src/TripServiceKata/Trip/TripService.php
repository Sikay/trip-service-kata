<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user, TripDAO $tripDAO, User $loggedInUser = null): array
    {
        if ($loggedInUser == null) {
            throw new UserNotLoggedInException();
        }

        return $user->isFriendsWith($loggedInUser) ? $tripDAO->tripsBy($user) : $this->noTrips();
    }

    private function noTrips(): array
    {
        return array();
    }
}
