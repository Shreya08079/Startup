<?php
namespace App\Models;

use App\Core\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create($data)
    {
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => PASSWORD_HASH_COST]);
        
        // Add created_at timestamp
        $data['created_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert('users', $data);
    }

    public function findByEmail($email)
    {
        return $this->db->fetch(
            "SELECT * FROM users WHERE email = ?",
            [$email]
        );
    }

    public function findById($id)
    {
        return $this->db->fetch(
            "SELECT * FROM users WHERE id = ?",
            [$id]
        );
    }

    public function update($id, $data)
    {
        // If password is being updated, hash it
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => PASSWORD_HASH_COST]);
        }
        
        // Add updated_at timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->update('users', $data, 'id = ?', [$id]);
    }

    public function delete($id)
    {
        return $this->db->delete('users', 'id = ?', [$id]);
    }

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function getAll($limit = 10, $offset = 0)
    {
        return $this->db->fetchAll(
            "SELECT * FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?",
            [$limit, $offset]
        );
    }

    public function count()
    {
        $result = $this->db->fetch("SELECT COUNT(*) as count FROM users");
        return $result['count'];
    }

    public function search($query, $limit = 10, $offset = 0)
    {
        return $this->db->fetchAll(
            "SELECT * FROM users 
            WHERE name LIKE ? OR email LIKE ? 
            ORDER BY created_at DESC 
            LIMIT ? OFFSET ?",
            ["%{$query}%", "%{$query}%", $limit, $offset]
        );
    }

    public function updateProfile($id, $data)
    {
        // Remove sensitive fields
        unset($data['password']);
        unset($data['email']);
        
        return $this->update($id, $data);
    }

    public function updatePassword($id, $currentPassword, $newPassword)
    {
        $user = $this->findById($id);
        
        if (!$user || !$this->verifyPassword($currentPassword, $user['password'])) {
            return false;
        }
        
        return $this->update($id, ['password' => $newPassword]);
    }
} 