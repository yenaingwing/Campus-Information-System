<?php
declare(strict_types=1);

final class Building
{
    public function __construct(private mysqli $db) {}

    public function all(): array
    {
        $result = $this->db->query('SELECT id, bname, img, description FROM buildings ORDER BY id');
        if (!$result) throw new RuntimeException('Unable to load buildings.');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, bname, img, description FROM buildings WHERE id = ? LIMIT 1');
        if (!$stmt) throw new RuntimeException('Unable to prepare building query.');
        $stmt->bind_param('i', $id); $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function exists(int $id): bool { return $this->find($id) !== null; }

    public function create(string $name, string $image, string $description): bool
    {
        $stmt = $this->db->prepare('INSERT INTO buildings (bname, img, description) VALUES (?, ?, ?)');
        if (!$stmt) throw new RuntimeException('Unable to prepare building insert.');
        $stmt->bind_param('sss', $name, $image, $description);
        return $stmt->execute();
    }

    public function update(int $id, string $name, string $description, ?string $image = null): bool
    {
        if ($image !== null) {
            $stmt = $this->db->prepare('UPDATE buildings SET bname = ?, img = ?, description = ? WHERE id = ?');
            if (!$stmt) throw new RuntimeException('Unable to prepare building update.');
            $stmt->bind_param('sssi', $name, $image, $description, $id);
        } else {
            $stmt = $this->db->prepare('UPDATE buildings SET bname = ?, description = ? WHERE id = ?');
            if (!$stmt) throw new RuntimeException('Unable to prepare building update.');
            $stmt->bind_param('ssi', $name, $description, $id);
        }
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $this->db->begin_transaction();
        try {
            $stmt = $this->db->prepare('DELETE FROM department WHERE brid = ?');
            $stmt->bind_param('i', $id); $stmt->execute();
            $stmt = $this->db->prepare('DELETE FROM room WHERE bid = ?');
            $stmt->bind_param('i', $id); $stmt->execute();
            $stmt = $this->db->prepare('DELETE FROM buildings WHERE id = ?');
            $stmt->bind_param('i', $id); $stmt->execute();
            $deleted = $stmt->affected_rows > 0;
            $this->db->commit();
            return $deleted;
        } catch (Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }
}
