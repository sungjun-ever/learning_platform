<?php

namespace App\Providers;

use App\Repositories\CompanyProfile\CompanyProfileRepository;
use App\Repositories\CompanyProfile\ICompanyProfileRepository;
use App\Repositories\IndividualProfile\IIndividualProfileRepository;
use App\Repositories\IndividualProfile\IndividualProfileRepository;
use App\Repositories\User\IRoleRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IIndividualProfileRepository::class, IndividualProfileRepository::class);
        $this->app->bind(ICompanyProfileRepository::class, CompanyProfileRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
