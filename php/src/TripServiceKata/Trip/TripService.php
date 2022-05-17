<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user, User $loggedInUser = null): array
    {
        if ($loggedInUser == null) {
            throw new UserNotLoggedInException();
        }

        return $user->isFriendsWith($loggedInUser) ? $this->tripsBy($user) : $this->noTrips();
    }

    protected function tripsBy(User $user)
    {
        return TripDAO::findTripsByUser($user);
    }

    private function noTrips(): array
    {
        return array();
    }
}
