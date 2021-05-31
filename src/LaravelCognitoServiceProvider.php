<?php declare(strict_types=1);

namespace Wellola\PACognito;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

final class LaravelCognitoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerIssuer();

        $this->registerCognitoUserProvider();
    }

    private function registerIssuer(): void
    {
        $this->app->bind(Issuer::class, function () {
            $config = $this->app->get('config');

            $pool = $config->get('auth.cognito-pa.pool');

            $region = $config->get('auth.cognito-pa.region');

            return new Issuer($pool, $region);
        });
    }

    private function registerCognitoUserProvider(): void
    {
        Auth::provider(CognitoUserProvider::class, function (Container $app) {
            return $app->make(CognitoUserProvider::class);
        });
    }
}
