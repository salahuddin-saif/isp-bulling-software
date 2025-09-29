<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

final class Plan extends Model
{
    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM plans ORDER BY price_cents ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM plans WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(string $name, int $speedMbps, int $priceCents, ?string $description): int
    {
        $stmt = $this->db->prepare('INSERT INTO plans (name, speed_mbps, price_cents, description) VALUES (?,?,?,?)');
        $stmt->execute([$name, $speedMbps, $priceCents, $description]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, string $name, int $speedMbps, int $priceCents, ?string $description): void
    {
        $stmt = $this->db->prepare('UPDATE plans SET name=?, speed_mbps=?, price_cents=?, description=? WHERE id=?');
        $stmt->execute([$name, $speedMbps, $priceCents, $description, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM plans WHERE id=?');
        $stmt->execute([$id]);
    }
}


