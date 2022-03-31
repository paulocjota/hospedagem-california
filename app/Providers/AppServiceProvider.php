<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::directive('decToBrl', function ($value) {
            return "<?php echo dec_to_brl($value) ?>";
        });

        Blade::directive('brlToDec', function ($value) {
            return "<?php echo brl_to_dec($value) ?>";
        });

        Blade::directive('dateToBr', function ($value) {
            return "<?php echo date_to_br($value) ?>";
        });

        Blade::directive('datetimeToBr', function ($value) {
            return "<?php echo datetime_to_br($value) ?>";
        });
    }
}
