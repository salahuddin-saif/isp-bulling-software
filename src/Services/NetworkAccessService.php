<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Env;

final class NetworkAccessService
{
    public function enableAccessForUser(int $userId): void
    {
        $provider = Env::get('NETWORK_PROVIDER', 'mock');
        if ($provider === 'mock' || $provider === '' ) {
            return; // no-op in dev
        }
        // Placeholder for real integration (e.g., RADIUS, MikroTik API)
        // Use Env::get('NETWORK_PROVIDER_BASE_URL'), USERNAME, PASSWORD
    }
}


