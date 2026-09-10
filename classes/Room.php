<?php
declare(strict_types=1);

final class Room
{
    public function __construct(private mysqli $db) {}

    public function all(): array
    {
        $sql = 'SELECT r.id, r.bid, r.roomnum, r.floor, r.imgroom, r.descriptionOfRoom, b.bname AS building_name
                FROM room r JOIN buildings b ON b.id = r.bid ORDER BY r.bid, r.id';
        $result = $this->db->query($sql);
        if (!$result) throw new RuntimeException('Unable to load rooms.');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM room WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id); $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function exists(int $id): bool { return $this->find($id) !== null; }

    public function create(int $buildingId, string $roomNumber, string $floor, string $image, string $description): bool
    {
        $stmt = $this->db->prepare('INSERT INTO room (bid, roomnum, floor, imgroom, descriptionOfRoom) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('issss', $buildingId, $roomNumber, $floor, $image, $description);
        return $stmt->execute();
    }

    public function update(int $id, int $buildingId, string $roomNumber, string $floor, string $description, ?string $image = null): bool
    {
        if ($image !== null) {
            $stmt = $this->db->prepare('UPDATE room SET bid=?, roomnum=?, floor=?, descriptionOfRoom=?, imgroom=? WHERE id=?');
            $stmt->bind_param('issssi', $buildingId, $roomNumber, $floor, $description, $image, $id);
        } else {
            $stmt = $this->db->prepare('UPDATE room SET bid=?, roomnum=?, floor=?, descriptionOfRoom=? WHERE id=?');
            $stmt->bind_param('isssi', $buildingId, $roomNumber, $floor, $description, $id);
        }
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $this->db->begin_transaction();
        try {
            $stmt = $this->db->prepare('DELETE FROM department WHERE rid = ?');
            $stmt->bind_param('i', $id); $stmt->execute();
            $stmt = $this->db->prepare('DELETE FROM room WHERE id = ?');
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
