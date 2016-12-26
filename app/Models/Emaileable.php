<?php

namespace App\Models;

trait Emaileable
{
    public function emails()
    {
        return $this->morphMany(Email::class, 'emaileable');
    }

    public function emailsWithoutPrimary()
    {
        return $this->morphMany(Email::class, 'emaileable')->where('primary',0);
    }

    public function primaryEmail()
    {
        return $this->morphOne(Email::class, 'emaileable')->where('primary',1);
    }

    public function getEmailsCountAttribute()
    {
        return (int) $this->emails()->count();
    }

    public function getEmailsWithoutPrimaryCountAttribute()
    {
        return (int) $this->emailsWithoutPrimary()->count();
    }
}