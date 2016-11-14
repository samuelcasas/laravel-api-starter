<?php

namespace App\Models;

trait Telephoneable
{
    protected static $type = 'telephoneable';

    public function telephones()
    {
        return $this->morphMany(Telephone::class, self::$type);
    }

    public function telephonesWithoutPrimary()
    {
        return $this->morphMany(Telephone::class, self::$type)->where('primary',0);
    }

    public function primaryTelephone()
    {
        return $this->morphOne(Telephone::class, self::$type)->where('primary',1);
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