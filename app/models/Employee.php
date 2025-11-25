<?php
class Employee {
    public static function all($limit = 10, $offset = 0, $keyword = null) {
        $pdo = Database::getInstance();
        $sql = "SELECT e.*, d.name as department FROM employees e LEFT JOIN departments d ON e.department_id = d.id WHERE e.is_deleted = 0";
        $params = [];
        if ($keyword) {
            $sql .= " AND (e.fullname LIKE :kw OR e.employee_code LIKE :kw OR e.email LIKE :kw)";
            $params[':kw'] = "%$keyword%";
        }
        $sql .= " ORDER BY e.created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        foreach ($params as $k=>$v) $stmt->bindValue($k, $v);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function countAll($keyword = null) {
        $pdo = Database::getInstance();
        $sql = "SELECT COUNT(*) FROM employees WHERE is_deleted = 0";
        $params = [];
        if ($keyword) {
            $sql .= " AND (fullname LIKE :kw OR employee_code LIKE :kw OR email LIKE :kw)";
            $params[':kw'] = "%$keyword%";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public static function find($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = :id AND is_deleted = 0");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            INSERT INTO employees (employee_code, fullname, gender, dob, email, phone, department_id, position, start_date, avatar, salary, notes)
            VALUES (:code, :name, :gender, :dob, :email, :phone, :dept, :position, :start_date, :avatar, :salary, :notes)
        ");
        return $stmt->execute([
            ':code' => $data['employee_code'],
            ':name' => $data['fullname'],
            ':gender' => $data['gender'] ?? 'other',
            ':dob' => $data['dob'] ?: null,
            ':email' => $data['email'] ?: null,
            ':phone' => $data['phone'] ?: null,
            ':dept' => $data['department_id'] ?: null,
            ':position' => $data['position'] ?: null,
            ':start_date' => $data['start_date'] ?: null,
            ':avatar' => $data['avatar'] ?? null,
            ':salary' => $data['salary'] ?: 0,
            ':notes' => $data['notes'] ?: null
        ]);
    }

    public static function update($id, $data) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            UPDATE employees SET
              employee_code = :code,
              fullname = :name,
              gender = :gender,
              dob = :dob,
              email = :email,
              phone = :phone,
              department_id = :dept,
              position = :position,
              start_date = :start_date,
              avatar = :avatar,
              salary = :salary,
              notes = :notes,
              updated_at = NOW()
            WHERE id = :id
        ");
        return $stmt->execute([
            ':code'=>$data['employee_code'],
            ':name'=>$data['fullname'],
            ':gender'=>$data['gender'] ?? 'other',
            ':dob'=>$data['dob'] ?: null,
            ':email'=>$data['email'] ?: null,
            ':phone'=>$data['phone'] ?: null,
            ':dept'=>$data['department_id'] ?: null,
            ':position'=>$data['position'] ?: null,
            ':start_date'=>$data['start_date'] ?: null,
            ':avatar'=>$data['avatar'] ?? null,
            ':salary'=>$data['salary'] ?: 0,
            ':notes'=>$data['notes'] ?: null,
            ':id'=>$id
        ]);
    }

    public static function softDelete($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE employees SET is_deleted = 1, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([':id'=>$id]);
    }

    public static function findByUserId($userId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT e.* FROM employees e JOIN users u ON u.employee_id = e.id WHERE u.id = :uid AND e.is_deleted = 0 LIMIT 1");
        $stmt->execute([':uid'=>$userId]);
        return $stmt->fetch();
    }
}
