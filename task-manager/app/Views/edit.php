<?php
$title = 'Edit Task';
ob_start();
?>

<div class="card">
    <h2>Edit Task</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo BASE_URL; ?>/task/update/<?php echo $task['id']; ?>">
        <div class="form-group">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" required 
                   value="<?php echo htmlspecialchars($_POST['title'] ?? $task['title']); ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($_POST['description'] ?? $task['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="status" name="status" 
                       <?php echo (isset($_POST['status']) || $task['status']) ? 'checked' : ''; ?>>
                <label for="status">Mark as completed</label>
            </div>
        </div>
        
        <button type="submit" class="btn btn-success">Update Task</button>
        <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Cancel</a>
    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>