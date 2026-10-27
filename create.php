<?php
require_once 'db.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $full_name  = trim($_POST['full_name']);
    $email      = trim($_POST['email']);
    $department = trim($_POST['department']);

    if (!empty($student_id) && !empty($full_name) && !empty($email) && !empty($department)) {
        $stmt = $conn->prepare("INSERT INTO students (student_id, full_name, email, department) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $student_id, $full_name, $email, $department);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Database Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Register New Student</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red; margin-bottom: 15px;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="create.php" method="POST">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="department" name="department" required>
            </div>

            <button type="submit" class="btn btn-success">Save Student</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>