<?php

namespace App\Providers;

use App\Helpers\FileUpload\FileManager;
use App\Helpers\FileUpload\FileManagerLocalStorage;
use App\Helpers\FileUpload\FileManagerS3;
use App\Helpers\FileUpload\FileManagerTesting;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire;
use Spatie\LaravelData\Contracts\BaseData;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {








                 #   Model::shouldBeStrict(! app()->isProduction());

                    Filament::serving(function () {
                        Filament::registerTheme(mix('css/app.css'));

                    });
                    Factory::guessFactoryNamesUsing(
                        function ($modelName)
                        {
                            return 'Database\\Factories\\' . Str::after($modelName, "Models\\") . 'Factory';
                        }
                    );
        JsonResource::withoutWrapping();


    }
}
