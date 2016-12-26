<?php

namespace App\Models;

trait Addressable
{
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function addressesWithoutPrimary()
    {
        return $this->morphMany(Address::class, 'addressable')->where('primary',0);
    }

    public function primaryAddress()
    {
        return $this->morphOne(Address::class, 'addressable')->where('primary',1);
    }

    public function getAddressesCountAttribute()
    {
        return (int) $this->addresses()->count();
    }

    public function getAddressesWithoutPrimaryCountAttribute()
    {
        return (int) $this->addressesWithoutPrimary()->count();
    }
}