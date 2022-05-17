<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user) {
        if ($this->getLoggedInUser() == null) {
            throw new UserNotLoggedInException();
        }

        return $user->isFriendsWith($this->getLoggedInUser()) ? $this->tripsBy($user) : $this->noTrips();
    }

    protected function getLoggedInUser()
    {
        return UserSession::getInstance()->getLoggedUser();
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
