<?php

namespace App\Models;

class States
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
                state
            FROM
                states;
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
                state
            FROM
                states
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
                state
            FROM
                states
            WHERE fk_user = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result['state'];
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
                states
            WHERE state = ?;
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
            INSERT INTO states 
                (fk_user, state)
            VALUES
                (:fk_user, :state);
        ";

        $options = [
            'cost' => 12,
        ];

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'fk_user' => $id,
                'state'  => $data['state']
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, $data)
    {
        $statement = "
            UPDATE states
            SET 
            state = :state
            where fk_user = :fk_user
        ";

        $options = [
            'cost' => 12,
        ];

        if (empty($data['state'])) {
            return true;
        }

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(
                ['state' => $data['state'], 'fk_user' => $id]
            );
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
