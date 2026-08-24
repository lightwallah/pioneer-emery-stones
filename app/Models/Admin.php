<?php

namespace App\Models;

use App\Core\Model;

class Admin extends Model
{
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE username = ?');
        $stmt->execute([$username]);
        return $stmt->fetch() ?: null;
    }

    public function updatePassword(int $id, string $password): void
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->db->prepare('UPDATE admins SET password = ? WHERE id = ?')->execute([$hash, $id]);
    }
}
