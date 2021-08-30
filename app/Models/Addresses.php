<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findById($id)
    {
        $statement = "
            SELECT distinct
                address
            FROM
                addresses
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

    public function findAll()
    {
        $statement = "
            SELECT 
                address
            FROM
                addresses;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByFkUser($id)
    {
        $statement = "
            SELECT 
                address
            FROM
                addresses
            WHERE fk_user = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result['address'];
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert($id, $data)
    {
        $statement = "
            INSERT INTO addresses 
                (fk_user, address)
            VALUES
                (:fk_user, :address);
        ";

        $options = [
            'cost' => 12,
        ];

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'fk_user' => $id,
                'address'  => $data['address']
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, $data)
    {
        $statement = "
            UPDATE addresses
            SET 
            address = :address
            where fk_user = :fk_user
        ";

        $options = [
            'cost' => 12,
        ];

        if (empty($data['address'])) {
            return true;
        }

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(
                ['address' => $data['address'], 'fk_user' => $id]
            );
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
