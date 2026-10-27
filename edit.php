<?php
require_once 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$error = '';

// Fetch existing record
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    header("Location: index.php");
    exit();
}

// Handle Update Request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $full_name  = trim($_POST['full_name']);
    $email      = trim($_POST['email']);
    $department = trim($_POST['department']);

    if (!empty($student_id) && !empty($full_name) && !empty($email) && !empty($department)) {
        $update_stmt = $conn->prepare("UPDATE students SET student_id = ?, full_name = ?, email = ?, department = ? WHERE id = ?");
        $update_stmt->bind_param("ssssi", $student_id, $full_name, $email, $department, $id);

        if ($update_stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Update failed: " . $conn->error;
        }
        $update_stmt->close();
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Student Information</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red; margin-bottom: 15px;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="edit.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($student['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($student['department']); ?>" required>
            </div>

            <button type="submit" class="btn btn-warning">Update Record</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>