<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('gen {model} {file}', function ($model, $file) {
     Artisan::call("infyom:api",[
        'model' => $model,
        '--fieldsFile' => $file.'.json',
         '--skip' => 'views,repository,tests,menu,dump-autoload,scaffold_routes,scaffold_controller',
         '--quiet'
    ]);
})->describe('Generate from JSON');

Artisan::command('rol {model}', function ($model) {
    Artisan::call("infyom:rollback",[
        'model' => $model,
        'type' => 'api',
    ]);
})->describe('Rollback from Model');

Artisan::command('user:create {name} {user} {password}',function($name, $user, $password){
    if($this->confirm("Create user \"$user\"")) {
        $user = \App\Models\User::create([
            'name' => $name,
            'email' => $user,
            'password' => bcrypt($password)
        ]);

        if($user)
        {
            $this->info('User Created!');
        } else {
            $this->error('User not Created');
        }
    }
})->describe('Create user');