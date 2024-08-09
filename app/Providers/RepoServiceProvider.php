<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
			'App\Repositories\Addlisting\AddlistingInterface',
			'App\Repositories\Addlisting\AddlistingRepository'
		);
       	
    }
}