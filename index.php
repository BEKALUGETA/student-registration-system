<?php
require_once 'db.php';

$query = "SELECT * FROM students ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <h2>Student List</h2>
            <a href="create.php" class="btn btn-primary">+ Register New Student</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No students registered yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>