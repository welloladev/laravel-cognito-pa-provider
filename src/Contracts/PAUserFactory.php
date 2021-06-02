<?php declare(strict_types=1);

namespace Wellola\PACognito\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface PAUserFactory
{
    public function make(array $payload): ?Authenticatable;
}