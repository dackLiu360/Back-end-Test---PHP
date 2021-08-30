<?php

namespace App\Models;

class Users
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                id, username
            FROM
                users;
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
                username
            FROM
                users
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

    public function findByUsername($username)
    {
        $statement = "
            SELECT 
                *
            FROM
                users
            WHERE username = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$username]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function insert($data)
    {
        $statement = "
            INSERT INTO users 
                (username, password)
            VALUES
                (:username, :password);
        ";

        $options = [
            'cost' => 12,
        ];

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'username' => $data['username'],
                'password'  => password_hash($data['password'], PASSWORD_BCRYPT, $options)
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function updateUsername($id, $data)
    {
        $statement = "
            UPDATE users
            SET 
            username = :username
            where id = :id
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(
                ['username' => $data['username'], 'id' => $id]
            );
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function updatePassword($id, $data){
        $statement = "
        UPDATE users
        SET 
        password = :password
        where id = :id
    ";
        $options = [
            'cost' => 12,
        ];

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(
                ['password' => password_hash($data['password'], PASSWORD_BCRYPT, $options), 'id' => $id]
            );
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM users
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

}
