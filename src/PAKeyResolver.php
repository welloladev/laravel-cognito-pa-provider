<?php declare(strict_types=1);

namespace Wellola\PACognito;

use Illuminate\Contracts\Cache\Repository;

final class PAKeyResolver
{
    private $cache;

    private $issuer;

    public function __construct(PAIssuer $issuer, Repository $cache)
    {
        $this->issuer = $issuer;
        $this->cache = $cache;
    }

    public function jwkset(): string
    {
        $url = $this->issuer->toString() . '/.well-known/jwks.json';

        return $this->cache->remember(config('cognito.pa.user_pool_id'), 7200, function() use ($url) {
            return file_get_contents($url);
        });
    }

    public function issuer(): PAIssuer
    {
        return $this->issuer;
    }
}
