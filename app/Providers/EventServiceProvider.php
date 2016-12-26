<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Email;
use App\Models\Telephone;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Telephone::updating(function(Telephone $telephone){
            //dd($telephone->getAttribute('delete'));
           if($telephone->getAttribute('__delete__'))
           {
               $telephone->delete();
           }
        });

        Telephone::created(function($telephone){
            if($telephone->entity->telephones()->count() == 0) {
                $telephone->makePrimary();
            }
        });

        Email::created(function($email){
            if($email->entity->emails()->count() == 1) {
                $email->makePrimary();
            }
        });

        Address::created(function($address){
            if($address->entity->addresses()->count() == 1) {
                $address->makePrimary();
            }
        });
    }
}
