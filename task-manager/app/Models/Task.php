<?php
require_once __DIR__ . '/../Core/Database.php';

class Task {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAllTasks() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tasks ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching tasks: " . $e->getMessage());
            return [];
        }
    }
    
    public function getTaskById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error fetching task: " . $e->getMessage());
            return false;
        }
    }
    
    public function createTask($title, $description, $status = 0) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO tasks (title, description, status, created_at, updated_at) 
                VALUES (?, ?, ?, NOW(), NOW())
            ");
            return $stmt->execute([$title, $description, $status]);
        } catch (PDOException $e) {
            error_log("Error creating task: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateTask($id, $title, $description, $status) {
        try {
            $stmt = $this->db->prepare("
                UPDATE tasks 
                SET title = ?, description = ?, status = ?, updated_at = NOW() 
                WHERE id = ?
            ");
            return $stmt->execute([$title, $description, $status, $id]);
        } catch (PDOException $e) {
            error_log("Error updating task: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteTask($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM tasks WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error deleting task: " . $e->getMessage());
            return false;
        }
    }
}
?>