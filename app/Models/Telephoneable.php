<?php

namespace App\Models;

trait Telephoneable
{
    public function telephones()
    {
        return $this->morphMany(Telephone::class, 'telephoneable');
    }

    public function telephonesWithoutPrimary()
    {
        return $this->morphMany(Telephone::class, 'telephoneable')->where('primary',0);
    }

    public function primaryTelephone()
    {
        return $this->morphOne(Telephone::class, 'telephoneable')->where('primary',1);
    }

    public function getTelephonesCountAttribute()
    {
        return (int) $this->telephones()->count();
    }

    public function getTelephonesWithoutPrimaryCountAttribute()
    {
        return (int) $this->telephonesWithoutPrimary()->count();
    }
}