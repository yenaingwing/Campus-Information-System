<?php
declare(strict_types=1);

final class Department
{
    public function __construct(private mysqli $db) {}

    public function all(): array
    {
        $sql = 'SELECT d.id, d.rid, d.brid, d.departmentname, d.floors, d.imgdepartment, d.descriptionOfDepartment,
                       r.roomnum, b.bname AS building_name
                FROM department d
                JOIN room r ON r.id = d.rid
                JOIN buildings b ON b.id = d.brid
                ORDER BY d.id';
        $result = $this->db->query($sql);
        if (!$result) throw new RuntimeException('Unable to load departments.');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM department WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id); $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function create(int $roomId, int $buildingId, string $name, string $floors, string $image, string $description): bool
    {
        $stmt = $this->db->prepare('INSERT INTO department (rid, brid, departmentname, floors, imgdepartment, descriptionOfDepartment) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('iissss', $roomId, $buildingId, $name, $floors, $image, $description);
        return $stmt->execute();
    }

    public function update(int $id, int $roomId, int $buildingId, string $name, string $floors, string $description, ?string $image = null): bool
    {
        if ($image !== null) {
            $stmt = $this->db->prepare('UPDATE department SET rid=?, brid=?, departmentname=?, floors=?, imgdepartment=?, descriptionOfDepartment=? WHERE id=?');
            $stmt->bind_param('iissssi', $roomId, $buildingId, $name, $floors, $image, $description, $id);
        } else {
            $stmt = $this->db->prepare('UPDATE department SET rid=?, brid=?, departmentname=?, floors=?, descriptionOfDepartment=? WHERE id=?');
            $stmt->bind_param('iisssi', $roomId, $buildingId, $name, $floors, $description, $id);
        }
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM department WHERE id = ?');
        $stmt->bind_param('i', $id); $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
