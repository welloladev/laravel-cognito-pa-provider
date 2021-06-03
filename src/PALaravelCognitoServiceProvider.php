<?php declare(strict_types=1);

namespace Wellola\PACognito;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

final class PALaravelCognitoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerIssuer();

        $this->registerCognitoUserProvider();
    }

    private function registerIssuer(): void
    {
        $this->app->bind(PAIssuer::class, function () {
            $config = $this->app->get('config');

            $pool = $config->get('cognito.pa.user_pool_id');

            $region = $config->get('cognito.pa.region');

            return new PAIssuer($pool, $region);
        });
    }

    private function registerCognitoUserProvider(): void
    {
        Auth::provider(PACognitoUserProvider::class, function (Container $app) {
            return $app->make(PACognitoUserProvider::class);
        });
    }
}
