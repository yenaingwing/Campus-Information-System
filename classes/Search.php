<?php
declare(strict_types=1);

final class Search
{
    public function __construct(private mysqli $db) {}

    public function search(string $term): array
    {
        $term = trim($term);
        if ($term === '') return ['buildings' => [], 'rooms' => [], 'departments' => []];
        $like = '%' . preg_replace('/\s+/', '', $term) . '%';

        $buildings = $this->query('SELECT id AS building_id, bname AS building_name, img AS image, description AS building_description
            FROM buildings WHERE REPLACE(bname, " ", "") LIKE ? ORDER BY id', [$like], 's');

        $rooms = $this->query('SELECT r.id, r.roomnum AS roomnumber, r.floor AS floornumber, r.imgroom AS imageroom,
            r.descriptionOfRoom AS room_description, b.bname AS building_name
            FROM room r JOIN buildings b ON r.bid=b.id
            WHERE REPLACE(r.roomnum, " ", "") LIKE ? OR REPLACE(r.floor, " ", "") LIKE ? ORDER BY r.id', [$like, $like], 'ss');

        $departments = $this->query('SELECT d.id AS department_id, d.departmentname, d.floors, d.imgdepartment AS imagedepartment,
            d.descriptionOfDepartment AS department_description, r.roomnum, r.floor, b.bname AS building_name
            FROM department d JOIN room r ON r.id=d.rid JOIN buildings b ON b.id=d.brid
            WHERE REPLACE(d.departmentname, " ", "") LIKE ? OR REPLACE(d.floors, " ", "") LIKE ?
               OR REPLACE(r.roomnum, " ", "") LIKE ? OR REPLACE(r.floor, " ", "") LIKE ? ORDER BY d.id',
            [$like, $like, $like, $like], 'ssss');

        return compact('buildings', 'rooms', 'departments');
    }

    private function query(string $sql, array $params, string $types): array
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) throw new RuntimeException('Unable to prepare search query.');
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
