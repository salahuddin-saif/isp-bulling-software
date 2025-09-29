<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

final class Invoice extends Model
{
    public function forUser(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM invoices WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM invoices WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(int $userId, int $planId, int $amountCents, string $dueDate): int
    {
        $stmt = $this->db->prepare('INSERT INTO invoices (user_id, plan_id, amount_cents, due_date) VALUES (?,?,?,?)');
        $stmt->execute([$userId, $planId, $amountCents, $dueDate]);
        return (int)$this->db->lastInsertId();
    }

    public function markPaid(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE invoices SET status='paid' WHERE id=?");
        $stmt->execute([$id]);
    }

    public function attachStripeSession(int $id, string $sessionId): void
    {
        $stmt = $this->db->prepare('UPDATE invoices SET stripe_session_id=? WHERE id=?');
        $stmt->execute([$sessionId, $id]);
    }
}


