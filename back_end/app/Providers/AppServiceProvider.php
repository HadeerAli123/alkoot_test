<?php

namespace App\Providers;

use App\Interfaces\AdsInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\SocialInterface;
use App\Repositories\AdsRepository;
use App\Interfaces\CompanyInterface;
use App\Interfaces\DetailsInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\SettingInterface;
use App\Repositories\UserRepository;
use App\Interfaces\CategoryInterface;
use App\Interfaces\DomainInterface;
use App\Repositories\SocialRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\DetailsRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\DomainRepository;
use Illuminate\Support\Facades\View;
use App\Models\Company;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(SettingInterface::class, SettingRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(SocialInterface::class, SocialRepository::class);
        $this->app->bind(AdsInterface::class, AdsRepository::class);
        $this->app->bind(DetailsInterface::class, DetailsRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(DomainInterface::class, DomainRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
  
public function boot()
{
    View::composer('includes.sidebar', function ($view) {
        $view->with('company', Company::first());
    });
}
}
