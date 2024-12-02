<?php

namespace App\Providers;

use App\Models\ACL\Permission;
use App\Models\User;
use Illuminate\Support\Facades\{Blade, Gate};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, $ability) {
            if ($user->isSupport()) {
                return true;
            }
        });

        Gate::after(function (User $user, $ability) {
            if (Permission::existsOnCache($ability)) {
                return $user->hasPermissionTo($ability);
            }
        });

        Blade::directive('cpf_cnpj', function (string $expression) {
            return "<?php echo \App\Helpers\Formatter::cpfCnpj($expression); ?>";
        });

        Blade::directive('phone', function (string $expression) {
            return "<?php echo \App\Helpers\Formatter::phone($expression); ?>";
        });

        Blade::directive('dateBR', function (string $expression) {
            return "<?php echo \App\Helpers\Formatter::dateBR($expression); ?>";
        });

        Blade::directive('dateTimeBR', function (string $expression) {
            return "<?php echo \App\Helpers\Formatter::dateTimeBR($expression); ?>";
        });

        Blade::directive('currency', function ($expression) {
            return "<?php echo number_format($expression, 2, ',', '.'); ?>";
        });
    }
}
