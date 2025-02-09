<?php

namespace TripServiceKata\User;

use TripServiceKata\Trip\Trip;

class User
{
    private $trips;
    private $friends;
    private $name;

    public function __construct($name = null)
    {
        $this->name = $name;
        $this->trips = array();
        $this->friends = array();
    }

    public function getTrips()
    {
        return $this->trips;
    }

    public function getFriends()
    {
        return $this->friends;
    }

    public function addFriend(User $user)
    {
        $this->friends[] = $user;
    }

    public function addTrip(Trip $trip)
    {
        $this->trips[] = $trip;
    }

    public function isFriendsWith(User $anotherUser): bool
    {
        return in_array($anotherUser, $this->friends, true);
    }
}
