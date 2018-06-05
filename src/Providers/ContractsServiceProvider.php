<?php

namespace Jarhen\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Jarhen\Modules\Contracts\RepositoryInterface;
use Jarhen\Modules\Laravel\Repository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, Repository::class);
    }
}
