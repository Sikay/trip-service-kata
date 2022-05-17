<?php

namespace Test\TripServiceKata\Trip;

use TripServiceKata\Trip\Trip;
use TripServiceKata\User\User;

class UserBuilder {

    private array $friends;
    private array $trips;

    public static function aUser(): UserBuilder
    {
        return new UserBuilder;
    }

    public function friendsWith(User... $friends): self
    {
        $this->friends = $friends;
        return $this;
    }

    public function withTrips(Trip... $trips): self
    {
        $this->trips = $trips;
        return $this;
    }

    public function build(): User
    {
        $user = new User();
        $this->addTripsTo($user);
        $this->addFriendsTo($user);
        return $user;
    }

    private function addTripsTo(User $user)
    {
        foreach ($this->trips as $trip) {
            $user->addTrip($trip);
        }
    }

    private function addFriendsTo(User $user)
    {
        foreach ($this->friends as $friend) {
            $user->addFriend($friend);
        }
    }
}