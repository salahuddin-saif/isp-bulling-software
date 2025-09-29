<?php
declare(strict_types=1);

namespace App\Models;

final class Payment extends Model
{
    public function record(int $invoiceId, string $provider, ?string $providerRef, int $amountCents, string $currency = 'USD'): int
    {
        $stmt = $this->db->prepare('INSERT INTO payments (invoice_id, provider, provider_ref, amount_cents, currency) VALUES (?,?,?,?,?)');
        $stmt->execute([$invoiceId, $provider, $providerRef, $amountCents, $currency]);
        return (int)$this->db->lastInsertId();
    }
}


