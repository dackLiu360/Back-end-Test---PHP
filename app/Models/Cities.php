<?php

namespace App\Models;

class Cities
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT distinct
                city
            FROM
                cities;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findById($id)
    {
        $statement = "
            SELECT 
                city
            FROM
                cities
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByFkUser($id)
    {
        $statement = "
            SELECT 
                city
            FROM
                cities
            WHERE fk_user = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result['city'];
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByName($name)
    {
        $statement = "
            SELECT 
                count(*) as total
            FROM
                cities
            WHERE city = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$name]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert($id, $data)
    {
        $statement = "
            INSERT INTO cities 
                (fk_user, city)
            VALUES
                (:fk_user, :city);
        ";

        $options = [
            'cost' => 12,
        ];

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'fk_user' => $id,
                'city'  => $data['city']
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, $data)
    {
        $statement = "
            UPDATE cities
            SET 
            city = :city
            where fk_user = :fk_user
        ";

        $options = [
            'cost' => 12,
        ];

        if (empty($data['city'])) {
            return true;
        }

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(
                ['city' => $data['city'], 'fk_user' => $id]
            );
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
