<?php
$title = 'Task Manager - All Tasks';
ob_start();
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>All Tasks</h2>
        <a href="<?php echo BASE_URL; ?>/task/create" class="btn btn-primary">Add New Task</a>
    </div>
    
    <?php if (empty($tasks)): ?>
        <p>No tasks found. <a href="<?php echo BASE_URL; ?>/task/create">Create your first task!</a></p>
    <?php else: ?>
        <table class="task-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['id']); ?></td>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars(substr($task['description'], 0, 50)) . (strlen($task['description']) > 50 ? '...' : ''); ?></td>
                        <td>
                            <span class="<?php echo $task['status'] ? 'status-complete' : 'status-incomplete'; ?>">
                                <?php echo $task['status'] ? 'Completed' : 'Incomplete'; ?>
                            </span>
                        </td>
                        <td><?php echo date('M j, Y', strtotime($task['created_at'])); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>/task/edit/<?php echo $task['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="<?php echo BASE_URL; ?>/task/delete/<?php echo $task['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>