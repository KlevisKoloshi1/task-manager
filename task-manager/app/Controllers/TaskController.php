<?php
require_once __DIR__ . '/../Models/Task.php';

class TaskController {
    private $taskModel;
    
    public function __construct() {
        $this->taskModel = new Task();
    }
    
    public function index() {
        $tasks = $this->taskModel->getAllTasks();
        require_once __DIR__ . '/../Views/index.php';
    }
    
    public function create() {
        require_once __DIR__ . '/../Views/add.php';
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = isset($_POST['status']) ? 1 : 0;
            
            if (empty($title)) {
                $error = "Title is required";
                require_once __DIR__ . '/../Views/add.php';
                return;
            }
            
            if ($this->taskModel->createTask($title, $description, $status)) {
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $error = "Failed to create task";
                require_once __DIR__ . '/../Views/add.php';
            }
        }
    }
    
    public function edit($id) {
        $task = $this->taskModel->getTaskById($id);
        if (!$task) {
            header('Location: ' . BASE_URL);
            exit;
        }
        require_once __DIR__ . '/../Views/edit.php';
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = isset($_POST['status']) ? 1 : 0;
            
            if (empty($title)) {
                $error = "Title is required";
                $task = $this->taskModel->getTaskById($id);
                require_once __DIR__ . '/../Views/edit.php';
                return;
            }
            
            if ($this->taskModel->updateTask($id, $title, $description, $status)) {
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $error = "Failed to update task";
                $task = $this->taskModel->getTaskById($id);
                require_once __DIR__ . '/../Views/edit.php';
            }
        }
    }
    
    public function delete($id) {
        if ($this->taskModel->deleteTask($id)) {
            header('Location: ' . BASE_URL);
        } else {
            // Handle error - for simplicity, just redirect back
            header('Location: ' . BASE_URL);
        }
        exit;
    }
}
?>